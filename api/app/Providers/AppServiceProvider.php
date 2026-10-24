<?php

namespace App\Providers;

use App\Domain\Repositories\CallRepositoryInterface;
use App\Domain\Services\IdempotencyServiceInterface;
use App\Infrastructure\Persistence\Repositories\EloquentCallRepository;
use App\Infrastructure\Services\RedisIdempotencyService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CallRepositoryInterface::class, EloquentCallRepository::class);
        $this->app->bind(IdempotencyServiceInterface::class, RedisIdempotencyService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
