<?php
declare(strict_types=1);

namespace App\Modules\Order\Notifications;

use App\Modules\Order\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly Order $order) {}

    public function via(object $notifiable): array { return ['mail']; }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order Confirmation #' . $this->order->id)
            ->line('Thank you for your order!')
            ->line('Order ID: ' . $this->order->id)
            ->line('Total: $' . $this->order->total_amount)
            ->line('Status: ' . $this->order->status);
    }
}
