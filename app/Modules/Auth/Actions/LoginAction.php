<?php
declare(strict_types=1);

namespace App\Modules\Auth\Actions;

use App\Modules\Auth\DTOs\LoginDTO;
use App\Modules\Auth\Services\AuthService;

class LoginAction
{
    public function __construct(private readonly AuthService $authService) {}

    public function execute(LoginDTO $dto): array
    {
        return $this->authService->login($dto);
    }
}
