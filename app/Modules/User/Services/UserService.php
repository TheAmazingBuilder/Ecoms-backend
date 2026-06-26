<?php
declare(strict_types=1);

namespace App\Modules\User\Services;

use App\Modules\Foundation\Abstracts\BaseService;
use App\Modules\Foundation\Exceptions\NotFoundException;
use App\Modules\User\DTOs\UserDTO;
use App\Modules\User\Models\User;
use App\Modules\User\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return $this->userRepository->paginate($perPage);
    }

    public function show(string $id): User
    {
        return $this->userRepository->findOrFail($id);
    }

    public function create(UserDTO $dto): User
    {
        return $this->userRepository->create([
            'name'     => $dto->name,
            'email'    => $dto->email,
            'password' => $dto->password ? Hash::make($dto->password) : null,
            'role'     => $dto->role,
            'phone'    => $dto->phone,
            'avatar'   => $dto->avatar,
        ]);
    }

    public function update(string $id, UserDTO $dto): User
    {
        $user = $this->show($id);
        $data = array_filter($dto->toArray(), fn ($v) => $v !== null);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $this->userRepository->update($user, $data);

        return $user->fresh();
    }

    public function delete(string $id): void
    {
        $user = $this->show($id);
        $this->userRepository->delete($user);
    }
}
