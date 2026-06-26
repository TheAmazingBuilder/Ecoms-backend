<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Http\Controllers;

use App\Modules\Foundation\Helpers\ApiResponse;
use App\Modules\Inventory\Actions\AdjustStockAction;
use App\Modules\Inventory\Http\Requests\AdjustStockRequest;
use App\Modules\Inventory\Http\Resources\InventoryResource;
use App\Modules\Inventory\Services\InventoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class InventoryController extends Controller
{
    public function __construct(private readonly InventoryService $inventoryService) {}

    public function index(): JsonResponse
    {
        $inventories = $this->inventoryService->list(request()->integer('per_page', 15));
        return ApiResponse::success(InventoryResource::collection($inventories));
    }

    public function show(string $id): JsonResponse
    {
        $inventory = $this->inventoryService->show($id);
        return ApiResponse::success(new InventoryResource($inventory));
    }

    public function adjust(AdjustStockRequest $request, string $id, AdjustStockAction $action): JsonResponse
    {
        $inventory = $action->execute($id, $request->integer('quantity'), $request->string('reason', '')->toString());
        return ApiResponse::success(new InventoryResource($inventory), 'Stock adjusted successfully');
    }
}
