<?php
declare(strict_types=1);

namespace App\Modules\Cart\Models;

use App\Modules\Foundation\Abstracts\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends BaseModel
{
    protected $fillable = ['cart_id', 'product_id', 'quantity', 'unit_price'];

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'quantity'   => 'integer',
            'unit_price' => 'decimal:2',
        ]);
    }

    public function cart(): BelongsTo { return $this->belongsTo(Cart::class); }
    public function product(): BelongsTo { return $this->belongsTo(\App\Modules\Product\Models\Product::class); }

    public function getSubtotalAttribute(): float
    {
        return $this->quantity * $this->unit_price;
    }
}
