<?php
declare(strict_types=1);

namespace App\Modules\Foundation\Abstracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository
{
    public function __construct(protected Model $model) {}

    public function all(): Collection
    {
        return $this->model->newQuery()->get();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->newQuery()->latest()->paginate($perPage);
    }

    public function find(string $id): ?Model
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(string $id): Model
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    public function delete(Model $model): bool
    {
        return (bool) $model->delete();
    }

    public function restore(Model $model): bool
    {
        return (bool) $model->restore();
    }

    public function forceDelete(Model $model): bool
    {
        return (bool) $model->forceDelete();
    }
}
