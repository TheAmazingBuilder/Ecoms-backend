<?php
declare(strict_types=1);

namespace App\Modules\User\Actions;

use App\Modules\User\DTOs\UserDTO;
use App\Modules\User\Models\User;
use App\Modules\User\Services\UserService;

class UpdateUserAction
{
    public function __construct(private readonly UserService $userService) {}

    public function execute(string $id, UserDTO $dto): User
    {
        return $this->userService->update($id, $dto);
    }
}
