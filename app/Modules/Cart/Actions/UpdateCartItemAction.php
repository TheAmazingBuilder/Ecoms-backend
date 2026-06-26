<?php
declare(strict_types=1);

namespace App\Modules\Cart\Actions;

use App\Modules\Cart\Models\CartItem;
use App\Modules\Cart\Services\CartService;

class UpdateCartItemAction
{
    public function __construct(private readonly CartService $cartService) {}

    public function execute(string $userId, string $itemId, int $quantity): CartItem
    {
        return $this->cartService->updateItem($userId, $itemId, $quantity);
    }
}
