<?php
declare(strict_types=1);

namespace App\Modules\Cart\Actions;

use App\Modules\Cart\Services\CartService;

class RemoveFromCartAction
{
    public function __construct(private readonly CartService $cartService) {}

    public function execute(string $userId, string $itemId): void
    {
        $this->cartService->removeItem($userId, $itemId);
    }
}
