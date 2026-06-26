<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Policies;

use App\Modules\User\Models\User;

class InventoryPolicy
{
    public function viewAny(User $user): bool { return $user->isAdmin(); }
    public function view(User $user): bool { return $user->isAdmin(); }
    public function adjust(User $user): bool { return $user->isAdmin(); }
}
