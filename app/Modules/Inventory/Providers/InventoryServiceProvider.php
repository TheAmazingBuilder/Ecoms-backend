<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Providers;

use App\Modules\Inventory\Events\StockLow;
use App\Modules\Inventory\Listeners\SendLowStockNotification;
use App\Modules\Inventory\Models\Inventory;
use App\Modules\Inventory\Observers\InventoryObserver;
use App\Modules\Inventory\Repositories\Contracts\InventoryRepositoryInterface;
use App\Modules\Inventory\Repositories\InventoryRepository;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class InventoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(InventoryRepositoryInterface::class, InventoryRepository::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        Inventory::observe(InventoryObserver::class);
        Event::listen(StockLow::class, SendLowStockNotification::class);
    }
}
