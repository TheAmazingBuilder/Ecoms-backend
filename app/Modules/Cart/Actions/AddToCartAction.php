<?php
declare(strict_types=1);

namespace App\Modules\Cart\Actions;

use App\Modules\Cart\DTOs\CartItemDTO;
use App\Modules\Cart\Models\CartItem;
use App\Modules\Cart\Services\CartService;

class AddToCartAction
{
    public function __construct(private readonly CartService $cartService) {}

    public function execute(string $userId, CartItemDTO $dto): CartItem
    {
        return $this->cartService->addItem($userId, $dto);
    }
}
