<?php
declare(strict_types=1);

namespace App\Modules\Order\Listeners;

use App\Modules\Order\Events\OrderPlaced;
use App\Modules\Order\Notifications\OrderPlacedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderConfirmation implements ShouldQueue
{
    public function handle(OrderPlaced $event): void
    {
        $event->order->user->notify(new OrderPlacedNotification($event->order));
    }
}
