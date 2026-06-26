<?php
declare(strict_types=1);

namespace App\Modules\Order\Actions;

use App\Modules\Order\DTOs\OrderDTO;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Services\OrderService;

class PlaceOrderAction
{
    public function __construct(private readonly OrderService $orderService) {}

    public function execute(OrderDTO $dto): Order
    {
        return $this->orderService->place($dto);
    }
}
