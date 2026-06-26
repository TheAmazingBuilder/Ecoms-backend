<?php
declare(strict_types=1);

namespace App\Modules\Media\Repositories\Contracts;

use App\Modules\Media\Models\Media;
use Illuminate\Pagination\LengthAwarePaginator;

interface MediaRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function find(string $id): ?Media;
    public function findOrFail(string $id): Media;
    public function create(array $data): Media;
    public function delete(Media $media): bool;
}
