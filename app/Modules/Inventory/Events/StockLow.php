<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Events;

use App\Modules\Inventory\Models\Inventory;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockLow
{
    use Dispatchable, SerializesModels;

    public function __construct(public readonly Inventory $inventory) {}
}
