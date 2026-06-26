<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Repositories;

use App\Modules\Foundation\Abstracts\BaseRepository;
use App\Modules\Inventory\Models\Inventory;
use App\Modules\Inventory\Repositories\Contracts\InventoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class InventoryRepository extends BaseRepository implements InventoryRepositoryInterface
{
    public function __construct(Inventory $model)
    {
        parent::__construct($model);
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->newQuery()->with('product')->latest()->paginate($perPage);
    }

    public function find(string $id): ?Inventory
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(string $id): Inventory
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function findByProduct(string $productId): ?Inventory
    {
        return $this->model->newQuery()->where('product_id', $productId)->first();
    }

    public function create(array $data): Inventory
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(Inventory $inventory, array $data): bool
    {
        return $inventory->update($data);
    }

    public function adjustStock(Inventory $inventory, int $adjustment): bool
    {
        return $inventory->increment('quantity', $adjustment) > 0;
    }
}
