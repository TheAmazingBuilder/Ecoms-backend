<?php
declare(strict_types=1);

namespace App\Modules\Cart\Actions;

use App\Modules\Cart\Services\CartService;

class ClearCartAction
{
    public function __construct(private readonly CartService $cartService) {}

    public function execute(string $userId): void
    {
        $this->cartService->clearCart($userId);
    }
}
