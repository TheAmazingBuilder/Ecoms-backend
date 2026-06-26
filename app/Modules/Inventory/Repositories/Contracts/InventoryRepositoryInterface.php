<?php
declare(strict_types=1);

namespace App\Modules\Inventory\Repositories\Contracts;

use App\Modules\Inventory\Models\Inventory;
use Illuminate\Pagination\LengthAwarePaginator;

interface InventoryRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function find(string $id): ?Inventory;
    public function findOrFail(string $id): Inventory;
    public function findByProduct(string $productId): ?Inventory;
    public function create(array $data): Inventory;
    public function update(Inventory $inventory, array $data): bool;
    public function adjustStock(Inventory $inventory, int $adjustment): bool;
}
