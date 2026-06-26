<?php
declare(strict_types=1);

namespace App\Modules\Media\Policies;

use App\Modules\User\Models\User;

class MediaPolicy
{
    public function create(User $user): bool { return true; }
    public function delete(User $user): bool { return $user->isAdmin(); }
}
