<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Actions;

use App\Modules\Inventory\Services\InventoryService;

class CheckStockAction
{
    public function __construct(private readonly InventoryService $inventoryService) {}

    public function execute(string $productId): bool
    {
        $inventory = $this->inventoryService->showByProduct($productId);
        return $inventory?->isInStock() ?? false;
    }
}
