<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Actions;

use App\Modules\Inventory\Models\Inventory;
use App\Modules\Inventory\Services\InventoryService;

class AdjustStockAction
{
    public function __construct(private readonly InventoryService $inventoryService) {}

    public function execute(string $id, int $quantity, string $reason = ''): Inventory
    {
        return $this->inventoryService->adjustStock($id, $quantity, $reason);
    }
}
