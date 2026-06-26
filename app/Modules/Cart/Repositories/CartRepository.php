<?php
declare(strict_types=1);

namespace App\Modules\Cart\Repositories;

use App\Modules\Cart\Models\Cart;
use App\Modules\Cart\Models\CartItem;
use App\Modules\Cart\Repositories\Contracts\CartRepositoryInterface;
use App\Modules\Foundation\Abstracts\BaseRepository;

class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    public function __construct(Cart $model)
    {
        parent::__construct($model);
    }

    public function findForUser(string $userId): ?Cart
    {
        return $this->model->newQuery()->with('items.product')->where('user_id', $userId)->first();
    }

    public function findOrCreateForUser(string $userId): Cart
    {
        return $this->model->newQuery()->firstOrCreate(
            ['user_id' => $userId],
            ['user_id' => $userId]
        );
    }

    public function findItem(string $cartId, string $productId): ?CartItem
    {
        return CartItem::where('cart_id', $cartId)->where('product_id', $productId)->first();
    }

    public function addItem(Cart $cart, array $data): CartItem
    {
        return $cart->items()->create($data);
    }

    public function updateItem(CartItem $item, array $data): bool
    {
        return $item->update($data);
    }

    public function removeItem(CartItem $item): bool
    {
        return (bool) $item->delete();
    }

    public function clearCart(Cart $cart): bool
    {
        return (bool) $cart->items()->delete();
    }
}
