<?php

namespace App\Providers;

use App\Domain\Repositories\CallRepositoryInterface;
use App\Infrastructure\Persistence\Repositories\EloquentCallRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CallRepositoryInterface::class, EloquentCallRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
