<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Jobs;

use App\Modules\Inventory\Events\StockLow;
use App\Modules\Inventory\Models\Inventory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckLowStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        Inventory::whereRaw('quantity - reserved_quantity <= low_stock_threshold')
            ->each(fn (Inventory $inventory) => event(new StockLow($inventory)));
    }
}
