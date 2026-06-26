<?php
declare(strict_types=1);

namespace App\Modules\Cart\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'item_count' => $this->item_count,
            'total'      => $this->total,
            'items'      => $this->whenLoaded('items', fn() => CartItemResource::collection($this->items)),
        ];
    }
}
