<?php
declare(strict_types=1);

namespace App\Modules\Media\Repositories;

use App\Modules\Foundation\Abstracts\BaseRepository;
use App\Modules\Media\Models\Media;
use App\Modules\Media\Repositories\Contracts\MediaRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class MediaRepository extends BaseRepository implements MediaRepositoryInterface
{
    public function __construct(Media $model)
    {
        parent::__construct($model);
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->newQuery()->latest()->paginate($perPage);
    }

    public function find(string $id): ?Media { return $this->model->newQuery()->find($id); }
    public function findOrFail(string $id): Media { return $this->model->newQuery()->findOrFail($id); }
    public function create(array $data): Media { return $this->model->newQuery()->create($data); }
    public function delete(Media $media): bool { return (bool) $media->delete(); }
}
