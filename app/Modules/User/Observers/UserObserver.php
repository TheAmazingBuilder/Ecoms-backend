<?php
declare(strict_types=1);

namespace App\Modules\User\Observers;

use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    public function created(User $user): void
    {
        Log::info('User created', ['id' => $user->id, 'email' => $user->email]);
    }

    public function updated(User $user): void
    {
        Log::info('User updated', ['id' => $user->id]);
    }

    public function deleted(User $user): void
    {
        Log::info('User soft deleted', ['id' => $user->id]);
    }

    public function restored(User $user): void
    {
        Log::info('User restored', ['id' => $user->id]);
    }
}
