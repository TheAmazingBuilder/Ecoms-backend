<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Models;

use App\Modules\Foundation\Abstracts\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends BaseModel
{
    protected $fillable = ['product_id', 'quantity', 'reserved_quantity', 'low_stock_threshold'];

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'quantity'           => 'integer',
            'reserved_quantity'  => 'integer',
            'low_stock_threshold'=> 'integer',
        ]);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Product\Models\Product::class);
    }

    public function getAvailableQuantityAttribute(): int
    {
        return $this->quantity - $this->reserved_quantity;
    }

    public function isLowStock(): bool
    {
        return $this->available_quantity <= $this->low_stock_threshold;
    }

    public function isInStock(): bool
    {
        return $this->available_quantity > 0;
    }
}
