<?php
declare(strict_types=1);

namespace App\Modules\Order\Models;

use App\Modules\Foundation\Abstracts\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends BaseModel
{
    protected $fillable = [
        'user_id', 'status', 'total_amount', 'tax_amount', 'shipping_amount',
        'discount_amount', 'notes', 'shipping_address', 'billing_address', 'payment_method', 'paid_at',
    ];

    const STATUS_PENDING    = 'pending';
    const STATUS_CONFIRMED  = 'confirmed';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED    = 'shipped';
    const STATUS_DELIVERED  = 'delivered';
    const STATUS_CANCELLED  = 'cancelled';
    const STATUS_REFUNDED   = 'refunded';

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'total_amount'    => 'decimal:2',
            'tax_amount'      => 'decimal:2',
            'shipping_amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'shipping_address'=> 'array',
            'billing_address' => 'array',
            'paid_at'         => 'datetime',
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\User\Models\User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isPending(): bool { return $this->status === self::STATUS_PENDING; }
    public function isCancellable(): bool { return in_array($this->status, [self::STATUS_PENDING, self::STATUS_CONFIRMED]); }
}
