<?php
declare(strict_types=1);

namespace App\Modules\User\Repositories\Contracts;

use App\Modules\User\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function find(string $id): ?User;
    public function findOrFail(string $id): User;
    public function findByEmail(string $email): ?User;
    public function create(array $data): User;
    public function update(User $user, array $data): bool;
    public function delete(User $user): bool;
}
