<?php
declare(strict_types=1);

namespace App\Modules\Auth\DTOs;

use App\Modules\Foundation\DTOs\BaseDTO;

class LoginDTO extends BaseDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            email: $data['email'],
            password: $data['password'],
        );
    }
}
