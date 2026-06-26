<?php
declare(strict_types=1);

namespace App\Modules\User\DTOs;

use App\Modules\Foundation\DTOs\BaseDTO;

class UserDTO extends BaseDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $password = null,
        public readonly string $role = 'customer',
        public readonly ?string $phone = null,
        public readonly ?string $avatar = null,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            name:     $data['name'],
            email:    $data['email'],
            password: $data['password'] ?? null,
            role:     $data['role'] ?? 'customer',
            phone:    $data['phone'] ?? null,
            avatar:   $data['avatar'] ?? null,
        );
    }
}
