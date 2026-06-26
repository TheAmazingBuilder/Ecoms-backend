<?php
declare(strict_types=1);

namespace App\Modules\Cart\Policies;

use App\Modules\Cart\Models\Cart;
use App\Modules\User\Models\User;

class CartPolicy
{
    public function view(User $user, Cart $cart): bool
    {
        return $user->id === $cart->user_id;
    }
}
