<?php
declare(strict_types=1);

namespace App\Modules\Order\Repositories\Contracts;

use App\Modules\Order\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function paginateForUser(string $userId, int $perPage = 15): LengthAwarePaginator;
    public function find(string $id): ?Order;
    public function findOrFail(string $id): Order;
    public function create(array $data): Order;
    public function update(Order $order, array $data): bool;
    public function delete(Order $order): bool;
}
