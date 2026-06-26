<?php
declare(strict_types=1);

namespace App\Modules\User\Repositories;

use App\Modules\Foundation\Abstracts\BaseRepository;
use App\Modules\User\Models\User;
use App\Modules\User\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->newQuery()->latest()->paginate($perPage);
    }

    public function find(string $id): ?User
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(string $id): User
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->newQuery()->where('email', $email)->first();
    }

    public function create(array $data): User
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function delete(User $user): bool
    {
        return (bool) $user->delete();
    }
}
