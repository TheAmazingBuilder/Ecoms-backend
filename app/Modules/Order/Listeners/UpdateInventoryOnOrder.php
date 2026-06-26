<?php
declare(strict_types=1);

namespace App\Modules\Order\Listeners;

use App\Modules\Order\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class UpdateInventoryOnOrder implements ShouldQueue
{
    public function handle(OrderPlaced $event): void
    {
        Log::info('Order placed, inventory reservations confirmed', [
            'order_id' => $event->order->id,
        ]);
    }
}
