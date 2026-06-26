<?php
declare(strict_types=1);

namespace App\Modules\Cart\Models;

use App\Modules\Foundation\Abstracts\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends BaseModel
{
    protected $fillable = ['user_id', 'session_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\User\Models\User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getTotalAttribute(): float
    {
        return $this->items->sum(fn ($item) => $item->quantity * $item->unit_price);
    }

    public function getItemCountAttribute(): int
    {
        return $this->items->sum('quantity');
    }
}
