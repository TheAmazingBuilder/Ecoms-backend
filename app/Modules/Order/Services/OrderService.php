<?php
declare(strict_types=1);

namespace App\Modules\Order\Services;

use App\Modules\Foundation\Abstracts\BaseService;
use App\Modules\Foundation\Exceptions\BusinessException;
use App\Modules\Inventory\Services\InventoryService;
use App\Modules\Order\DTOs\OrderDTO;
use App\Modules\Order\Events\OrderCancelled;
use App\Modules\Order\Events\OrderPlaced;
use App\Modules\Order\Events\OrderStatusChanged;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Repositories\Contracts\OrderRepositoryInterface;
use App\Modules\Product\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderService extends BaseService
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly InventoryService $inventoryService,
    ) {}

    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return $this->orderRepository->paginate($perPage);
    }

    public function listForUser(string $userId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->orderRepository->paginateForUser($userId, $perPage);
    }

    public function show(string $id): Order
    {
        return $this->orderRepository->findOrFail($id);
    }

    public function place(OrderDTO $dto): Order
    {
        return DB::transaction(function () use ($dto) {
            $totalAmount = 0;

            // Validate & reserve stock for all items
            foreach ($dto->items as $itemData) {
                $this->inventoryService->reserveStock($itemData['product_id'], $itemData['quantity']);
            }

            // Create order
            $order = $this->orderRepository->create([
                'user_id'          => $dto->user_id,
                'status'           => Order::STATUS_PENDING,
                'shipping_address' => $dto->shipping_address,
                'billing_address'  => $dto->billing_address,
                'payment_method'   => $dto->payment_method,
                'notes'            => $dto->notes,
                'shipping_amount'  => $dto->shipping_amount,
                'discount_amount'  => $dto->discount_amount,
                'tax_amount'       => 0,
                'total_amount'     => 0,
            ]);

            // Create order items
            foreach ($dto->items as $itemData) {
                $product = $this->productRepository->findOrFail($itemData['product_id']);
                $unitPrice = $product->price;
                $totalPrice = $unitPrice * $itemData['quantity'];
                $totalAmount += $totalPrice;

                $order->items()->create([
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'product_sku'  => $product->sku,
                    'quantity'     => $itemData['quantity'],
                    'unit_price'   => $unitPrice,
                    'total_price'  => $totalPrice,
                ]);
            }

            $grandTotal = $totalAmount + $dto->shipping_amount - $dto->discount_amount;
            $this->orderRepository->update($order, ['total_amount' => $grandTotal]);

            event(new OrderPlaced($order->fresh('items')));

            return $order->fresh('items');
        });
    }

    public function cancel(string $id): Order
    {
        $order = $this->show($id);

        if (!$order->isCancellable()) {
            throw new BusinessException('Order cannot be cancelled in its current status: ' . $order->status);
        }

        // Release reserved stock
        foreach ($order->items as $item) {
            $this->inventoryService->releaseReservation($item->product_id, $item->quantity);
        }

        $this->orderRepository->update($order, ['status' => Order::STATUS_CANCELLED]);
        event(new OrderCancelled($order->fresh()));

        return $order->fresh();
    }

    public function updateStatus(string $id, string $status): Order
    {
        $order = $this->show($id);
        $oldStatus = $order->status;

        $this->orderRepository->update($order, ['status' => $status]);

        if ($status === Order::STATUS_DELIVERED) {
            foreach ($order->items as $item) {
                $this->inventoryService->confirmReservation($item->product_id, $item->quantity);
            }
        }

        event(new OrderStatusChanged($order->fresh(), $oldStatus, $status));

        return $order->fresh();
    }
}
