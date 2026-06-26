<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Observers;

use App\Modules\Inventory\Events\StockLow;
use App\Modules\Inventory\Models\Inventory;

class InventoryObserver
{
    public function updated(Inventory $inventory): void
    {
        if ($inventory->isDirty('quantity') && $inventory->isLowStock()) {
            event(new StockLow($inventory));
        }
    }
}
