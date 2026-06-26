<?php
declare(strict_types=1);

namespace App\Modules\Cart\Repositories\Contracts;

use App\Modules\Cart\Models\Cart;
use App\Modules\Cart\Models\CartItem;

interface CartRepositoryInterface
{
    public function findForUser(string $userId): ?Cart;
    public function findOrCreateForUser(string $userId): Cart;
    public function findItem(string $cartId, string $productId): ?CartItem;
    public function addItem(Cart $cart, array $data): CartItem;
    public function updateItem(CartItem $item, array $data): bool;
    public function removeItem(CartItem $item): bool;
    public function clearCart(Cart $cart): bool;
}
