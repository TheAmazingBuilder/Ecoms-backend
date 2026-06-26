<?php
declare(strict_types=1);

namespace App\Modules\Order\Policies;

use App\Modules\Order\Models\Order;
use App\Modules\User\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool { return true; }

    public function view(User $user, Order $order): bool
    {
        return $user->isAdmin() || $user->id === $order->user_id;
    }

    public function create(User $user): bool { return true; }

    public function updateStatus(User $user): bool { return $user->isAdmin(); }

    public function cancel(User $user, Order $order): bool
    {
        return $user->isAdmin() || $user->id === $order->user_id;
    }
}
