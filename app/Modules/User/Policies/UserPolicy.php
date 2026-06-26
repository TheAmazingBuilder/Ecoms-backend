<?php
declare(strict_types=1);

namespace App\Modules\User\Policies;

use App\Modules\User\Models\User;

class UserPolicy
{
    public function viewAny(User $authUser): bool
    {
        return $authUser->isAdmin();
    }

    public function view(User $authUser, User $user): bool
    {
        return $authUser->isAdmin() || $authUser->id === $user->id;
    }

    public function create(User $authUser): bool
    {
        return $authUser->isAdmin();
    }

    public function update(User $authUser, User $user): bool
    {
        return $authUser->isAdmin() || $authUser->id === $user->id;
    }

    public function delete(User $authUser, User $user): bool
    {
        return $authUser->isAdmin() && $authUser->id !== $user->id;
    }
}
