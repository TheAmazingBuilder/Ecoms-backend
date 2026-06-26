<?php
declare(strict_types=1);

namespace App\Modules\Cart\Providers;

use App\Modules\Cart\Repositories\CartRepository;
use App\Modules\Cart\Repositories\Contracts\CartRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
    }
}
