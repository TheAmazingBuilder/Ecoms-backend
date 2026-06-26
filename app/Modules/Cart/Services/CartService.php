<?php
declare(strict_types=1);

namespace App\Modules\Cart\Services;

use App\Modules\Cart\DTOs\CartItemDTO;
use App\Modules\Cart\Models\Cart;
use App\Modules\Cart\Models\CartItem;
use App\Modules\Cart\Repositories\Contracts\CartRepositoryInterface;
use App\Modules\Foundation\Abstracts\BaseService;
use App\Modules\Foundation\Exceptions\BusinessException;
use App\Modules\Product\Repositories\Contracts\ProductRepositoryInterface;

class CartService extends BaseService
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
        private readonly ProductRepositoryInterface $productRepository,
    ) {}

    public function getCart(string $userId): Cart
    {
        return $this->cartRepository->findOrCreateForUser($userId);
    }

    public function addItem(string $userId, CartItemDTO $dto): CartItem
    {
        $product = $this->productRepository->findOrFail($dto->product_id);
        $cart = $this->cartRepository->findOrCreateForUser($userId);

        // If item already exists, increment quantity
        $existingItem = $this->cartRepository->findItem($cart->id, $dto->product_id);

        if ($existingItem) {
            $this->cartRepository->updateItem($existingItem, [
                'quantity' => $existingItem->quantity + $dto->quantity,
            ]);
            return $existingItem->fresh();
        }

        return $this->cartRepository->addItem($cart, [
            'product_id' => $dto->product_id,
            'quantity'   => $dto->quantity,
            'unit_price' => $product->price,
        ]);
    }

    public function updateItem(string $userId, string $itemId, int $quantity): CartItem
    {
        $cart = $this->cartRepository->findForUser($userId);
        $item = CartItem::where('cart_id', $cart?->id)->findOrFail($itemId);

        if ($quantity <= 0) {
            $this->cartRepository->removeItem($item);
            throw new BusinessException('Item removed from cart', 200);
        }

        $this->cartRepository->updateItem($item, ['quantity' => $quantity]);
        return $item->fresh();
    }

    public function removeItem(string $userId, string $itemId): void
    {
        $cart = $this->cartRepository->findForUser($userId);
        $item = CartItem::where('cart_id', $cart?->id)->findOrFail($itemId);
        $this->cartRepository->removeItem($item);
    }

    public function clearCart(string $userId): void
    {
        $cart = $this->cartRepository->findOrCreateForUser($userId);
        $this->cartRepository->clearCart($cart);
    }
}
