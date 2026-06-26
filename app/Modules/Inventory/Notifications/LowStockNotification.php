<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Notifications;

use App\Modules\Inventory\Models\Inventory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly Inventory $inventory) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Low Stock Alert')
            ->line('Product stock is running low.')
            ->line('Product ID: ' . $this->inventory->product_id)
            ->line('Available Quantity: ' . $this->inventory->available_quantity)
            ->line('Threshold: ' . $this->inventory->low_stock_threshold);
    }
}
