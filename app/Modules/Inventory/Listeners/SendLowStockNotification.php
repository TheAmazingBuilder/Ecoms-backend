<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Listeners;

use App\Modules\Inventory\Events\StockLow;
use App\Modules\Inventory\Notifications\LowStockNotification;
use App\Modules\User\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLowStockNotification implements ShouldQueue
{
    public function handle(StockLow $event): void
    {
        // Notify all admin users
        User::where('role', 'admin')->each(function (User $admin) use ($event) {
            $admin->notify(new LowStockNotification($event->inventory));
        });
    }
}
