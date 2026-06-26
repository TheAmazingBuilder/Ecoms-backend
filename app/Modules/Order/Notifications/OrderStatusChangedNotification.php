<?php
declare(strict_types=1);

namespace App\Modules\Order\Notifications;

use App\Modules\Order\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Order $order,
        private readonly string $oldStatus,
        private readonly string $newStatus,
    ) {}

    public function via(object $notifiable): array { return ['mail']; }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order Status Updated #' . $this->order->id)
            ->line('Your order status has been updated.')
            ->line('From: ' . $this->oldStatus . ' → To: ' . $this->newStatus);
    }
}
