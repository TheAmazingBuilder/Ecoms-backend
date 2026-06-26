<?php
declare(strict_types=1);

namespace App\Modules\Order\Observers;

use App\Modules\Order\Events\OrderStatusChanged;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Notifications\OrderStatusChangedNotification;

class OrderObserver
{
    public function updated(Order $order): void
    {
        if ($order->isDirty('status')) {
            $order->user?->notify(new OrderStatusChangedNotification(
                $order,
                $order->getOriginal('status'),
                $order->status
            ));
        }
    }
}
