<?php
declare(strict_types=1);

namespace App\Modules\Auth\DTOs;

use App\Modules\Foundation\DTOs\BaseDTO;

class RegisterDTO extends BaseDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly string $role = 'customer',
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            role: $data['role'] ?? 'customer',
        );
    }
}
