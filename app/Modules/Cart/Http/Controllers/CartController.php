<?php
declare(strict_types=1);

namespace App\Modules\Cart\Http\Controllers;

use App\Modules\Cart\Actions\AddToCartAction;
use App\Modules\Cart\Actions\ClearCartAction;
use App\Modules\Cart\Actions\RemoveFromCartAction;
use App\Modules\Cart\Actions\UpdateCartItemAction;
use App\Modules\Cart\DTOs\CartItemDTO;
use App\Modules\Cart\Http\Requests\AddToCartRequest;
use App\Modules\Cart\Http\Requests\UpdateCartItemRequest;
use App\Modules\Cart\Http\Resources\CartResource;
use App\Modules\Cart\Services\CartService;
use App\Modules\Foundation\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cartService) {}

    public function show(Request $request): JsonResponse
    {
        $cart = $this->cartService->getCart($request->user()->id);
        return ApiResponse::success(new CartResource($cart->load('items.product')));
    }

    public function addItem(AddToCartRequest $request, AddToCartAction $action): JsonResponse
    {
        $action->execute($request->user()->id, CartItemDTO::fromRequest($request->validated()));
        $cart = $this->cartService->getCart($request->user()->id)->load('items.product');
        return ApiResponse::success(new CartResource($cart), 'Item added to cart');
    }

    public function updateItem(UpdateCartItemRequest $request, string $itemId, UpdateCartItemAction $action): JsonResponse
    {
        $action->execute($request->user()->id, $itemId, $request->integer('quantity'));
        $cart = $this->cartService->getCart($request->user()->id)->load('items.product');
        return ApiResponse::success(new CartResource($cart), 'Cart updated');
    }

    public function removeItem(Request $request, string $itemId, RemoveFromCartAction $action): JsonResponse
    {
        $action->execute($request->user()->id, $itemId);
        return ApiResponse::noContent();
    }

    public function clear(Request $request, ClearCartAction $action): JsonResponse
    {
        $action->execute($request->user()->id);
        return ApiResponse::success(null, 'Cart cleared');
    }
}
