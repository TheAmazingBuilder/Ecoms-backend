<?php
declare(strict_types=1);

namespace App\Modules\Auth\Services;

use App\Modules\Auth\DTOs\LoginDTO;
use App\Modules\Auth\DTOs\RegisterDTO;
use App\Modules\Foundation\Abstracts\BaseService;
use App\Modules\Foundation\Exceptions\BusinessException;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService
{
    public function login(LoginDTO $dto): array
    {
        $user = User::where('email', $dto->email)->first();

        if (!$user || !Hash::check($dto->password, $user->password)) {
            throw new BusinessException('Invalid credentials', 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function register(RegisterDTO $dto): array
    {
        $user = User::create([
            'name'     => $dto->name,
            'email'    => $dto->email,
            'password' => Hash::make($dto->password),
            'role'     => $dto->role,
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
