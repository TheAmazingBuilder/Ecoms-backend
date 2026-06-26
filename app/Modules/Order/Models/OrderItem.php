<?php
declare(strict_types=1);

namespace App\Modules\Order\Models;

use App\Modules\Foundation\Abstracts\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends BaseModel
{
    protected $fillable = ['order_id', 'product_id', 'product_name', 'product_sku', 'quantity', 'unit_price', 'total_price'];

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'quantity'    => 'integer',
            'unit_price'  => 'decimal:2',
            'total_price' => 'decimal:2',
        ]);
    }

    public function order(): BelongsTo { return $this->belongsTo(Order::class); }
    public function product(): BelongsTo { return $this->belongsTo(\App\Modules\Product\Models\Product::class); }
}
