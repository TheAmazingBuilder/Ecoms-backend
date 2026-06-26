<?php
declare(strict_types=1);

namespace App\Modules\Auth\Actions;

use App\Modules\Auth\DTOs\RegisterDTO;
use App\Modules\Auth\Services\AuthService;

class RegisterAction
{
    public function __construct(private readonly AuthService $authService) {}

    public function execute(RegisterDTO $dto): array
    {
        return $this->authService->register($dto);
    }
}
