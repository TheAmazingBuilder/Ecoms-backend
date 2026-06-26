<?php
declare(strict_types=1);

namespace App\Modules\Cart\Http\Resources;

use App\Modules\Product\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'product_id' => $this->product_id,
            'quantity'   => $this->quantity,
            'unit_price' => $this->unit_price,
            'subtotal'   => $this->subtotal,
            'product'    => $this->whenLoaded('product', fn() => new ProductResource($this->product)),
        ];
    }
}
