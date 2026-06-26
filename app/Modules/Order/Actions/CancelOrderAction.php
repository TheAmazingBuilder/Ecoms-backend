<?php
declare(strict_types=1);

namespace App\Modules\Order\Actions;

use App\Modules\Order\Models\Order;
use App\Modules\Order\Services\OrderService;

class CancelOrderAction
{
    public function __construct(private readonly OrderService $orderService) {}

    public function execute(string $id): Order
    {
        return $this->orderService->cancel($id);
    }
}
