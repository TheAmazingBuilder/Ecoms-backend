<?php
declare(strict_types=1);

namespace App\Modules\Order\Jobs;

use App\Modules\Order\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly Order $order) {}

    public function handle(): void
    {
        Log::info('Processing order', ['order_id' => $this->order->id]);
        // Payment processing, fraud checks, etc.
    }
}
