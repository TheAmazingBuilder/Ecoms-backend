<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'product_id'           => $this->product_id,
            'quantity'             => $this->quantity,
            'reserved_quantity'    => $this->reserved_quantity,
            'available_quantity'   => $this->available_quantity,
            'low_stock_threshold'  => $this->low_stock_threshold,
            'is_low_stock'         => $this->isLowStock(),
            'is_in_stock'          => $this->isInStock(),
            'created_at'           => $this->created_at?->toIso8601String(),
            'updated_at'           => $this->updated_at?->toIso8601String(),
        ];
    }
}
