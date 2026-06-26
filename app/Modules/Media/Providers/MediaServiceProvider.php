<?php
declare(strict_types=1);

namespace App\Modules\Media\Providers;

use App\Modules\Media\Repositories\Contracts\MediaRepositoryInterface;
use App\Modules\Media\Repositories\MediaRepository;
use Illuminate\Support\ServiceProvider;

class MediaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(MediaRepositoryInterface::class, MediaRepository::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
    }
}
