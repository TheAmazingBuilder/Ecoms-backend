<?php
declare(strict_types=1);

namespace App\Modules\Order\Http\Resources;

use App\Modules\User\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'status'           => $this->status,
            'total_amount'     => $this->total_amount,
            'tax_amount'       => $this->tax_amount,
            'shipping_amount'  => $this->shipping_amount,
            'discount_amount'  => $this->discount_amount,
            'payment_method'   => $this->payment_method,
            'notes'            => $this->notes,
            'shipping_address' => $this->shipping_address,
            'billing_address'  => $this->billing_address,
            'paid_at'          => $this->paid_at?->toIso8601String(),
            'user'             => $this->whenLoaded('user', fn() => new UserResource($this->user)),
            'items'            => $this->whenLoaded('items', fn() => OrderItemResource::collection($this->items)),
            'created_at'       => $this->created_at?->toIso8601String(),
            'updated_at'       => $this->updated_at?->toIso8601String(),
        ];
    }
}
