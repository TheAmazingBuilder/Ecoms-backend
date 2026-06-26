<?php
declare(strict_types=1);

namespace App\Modules\Order\Http\Controllers;

use App\Modules\Foundation\Helpers\ApiResponse;
use App\Modules\Order\Actions\CancelOrderAction;
use App\Modules\Order\Actions\PlaceOrderAction;
use App\Modules\Order\Actions\UpdateOrderStatusAction;
use App\Modules\Order\DTOs\OrderDTO;
use App\Modules\Order\Http\Requests\PlaceOrderRequest;
use App\Modules\Order\Http\Requests\UpdateOrderStatusRequest;
use App\Modules\Order\Http\Resources\OrderResource;
use App\Modules\Order\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class OrderController extends Controller
{
    public function __construct(private readonly OrderService $orderService) {}

    public function index(Request $request): JsonResponse
    {
        $orders = $request->user()->isAdmin()
            ? $this->orderService->list($request->integer('per_page', 15))
            : $this->orderService->listForUser($request->user()->id, $request->integer('per_page', 15));

        return ApiResponse::success(OrderResource::collection($orders));
    }

    public function store(PlaceOrderRequest $request, PlaceOrderAction $action): JsonResponse
    {
        $dto = OrderDTO::fromRequest($request->validated(), $request->user()->id);
        $order = $action->execute($dto);
        return ApiResponse::created(new OrderResource($order));
    }

    public function show(Request $request, string $id): JsonResponse
    {
        $order = $this->orderService->show($id);
        return ApiResponse::success(new OrderResource($order));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, string $id, UpdateOrderStatusAction $action): JsonResponse
    {
        $order = $action->execute($id, $request->validated('status'));
        return ApiResponse::success(new OrderResource($order), 'Order status updated');
    }

    public function cancel(string $id, CancelOrderAction $action): JsonResponse
    {
        $order = $action->execute($id);
        return ApiResponse::success(new OrderResource($order), 'Order cancelled');
    }
}
