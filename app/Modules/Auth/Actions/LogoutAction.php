<?php
declare(strict_types=1);

namespace App\Modules\Auth\Actions;

use App\Modules\Auth\Services\AuthService;
use App\Modules\User\Models\User;

class LogoutAction
{
    public function __construct(private readonly AuthService $authService) {}

    public function execute(User $user): void
    {
        $this->authService->logout($user);
    }
}
