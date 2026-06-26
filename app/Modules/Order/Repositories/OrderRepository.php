<?php
declare(strict_types=1);

namespace App\Modules\Order\Repositories;

use App\Modules\Foundation\Abstracts\BaseRepository;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->newQuery()->with(['user', 'items.product'])->latest()->paginate($perPage);
    }

    public function paginateForUser(string $userId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->newQuery()->with(['items.product'])->where('user_id', $userId)->latest()->paginate($perPage);
    }

    public function find(string $id): ?Order
    {
        return $this->model->newQuery()->with(['user', 'items.product'])->find($id);
    }

    public function findOrFail(string $id): Order
    {
        return $this->model->newQuery()->with(['user', 'items.product'])->findOrFail($id);
    }

    public function create(array $data): Order
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(Order $order, array $data): bool
    {
        return $order->update($data);
    }

    public function delete(Order $order): bool
    {
        return (bool) $order->delete();
    }
}
