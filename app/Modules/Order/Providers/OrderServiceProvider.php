<?php
declare(strict_types=1);

namespace App\Modules\Order\Providers;

use App\Modules\Order\Events\OrderPlaced;
use App\Modules\Order\Events\OrderStatusChanged;
use App\Modules\Order\Listeners\SendOrderConfirmation;
use App\Modules\Order\Listeners\UpdateInventoryOnOrder;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Observers\OrderObserver;
use App\Modules\Order\Repositories\Contracts\OrderRepositoryInterface;
use App\Modules\Order\Repositories\OrderRepository;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        Order::observe(OrderObserver::class);
        Event::listen(OrderPlaced::class, SendOrderConfirmation::class);
        Event::listen(OrderPlaced::class, UpdateInventoryOnOrder::class);
    }
}
