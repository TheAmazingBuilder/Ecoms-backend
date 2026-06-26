<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Services;

use App\Modules\Foundation\Abstracts\BaseService;
use App\Modules\Foundation\Exceptions\BusinessException;
use App\Modules\Inventory\DTOs\InventoryDTO;
use App\Modules\Inventory\Events\StockLow;
use App\Modules\Inventory\Events\StockUpdated;
use App\Modules\Inventory\Models\Inventory;
use App\Modules\Inventory\Repositories\Contracts\InventoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class InventoryService extends BaseService
{
    public function __construct(
        private readonly InventoryRepositoryInterface $inventoryRepository,
    ) {}

    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return $this->inventoryRepository->paginate($perPage);
    }

    public function show(string $id): Inventory
    {
        return $this->inventoryRepository->findOrFail($id);
    }

    public function showByProduct(string $productId): ?Inventory
    {
        return $this->inventoryRepository->findByProduct($productId);
    }

    public function create(InventoryDTO $dto): Inventory
    {
        return $this->inventoryRepository->create($dto->toArray());
    }

    public function adjustStock(string $id, int $quantity, string $reason = ''): Inventory
    {
        $inventory = $this->show($id);
        $this->inventoryRepository->adjustStock($inventory, $quantity);
        $inventory->refresh();

        event(new StockUpdated($inventory, $quantity, $reason));

        if ($inventory->isLowStock()) {
            event(new StockLow($inventory));
        }

        return $inventory;
    }

    public function reserveStock(string $productId, int $quantity): void
    {
        $inventory = $this->inventoryRepository->findByProduct($productId);

        if (!$inventory || $inventory->available_quantity < $quantity) {
            throw new BusinessException('Insufficient stock for product: ' . $productId);
        }

        $this->inventoryRepository->update($inventory, [
            'reserved_quantity' => $inventory->reserved_quantity + $quantity,
        ]);
    }

    public function releaseReservation(string $productId, int $quantity): void
    {
        $inventory = $this->inventoryRepository->findByProduct($productId);
        if ($inventory) {
            $this->inventoryRepository->update($inventory, [
                'reserved_quantity' => max(0, $inventory->reserved_quantity - $quantity),
            ]);
        }
    }

    public function confirmReservation(string $productId, int $quantity): void
    {
        $inventory = $this->inventoryRepository->findByProduct($productId);
        if ($inventory) {
            $this->inventoryRepository->update($inventory, [
                'quantity'          => $inventory->quantity - $quantity,
                'reserved_quantity' => max(0, $inventory->reserved_quantity - $quantity),
            ]);
        }
    }
}
