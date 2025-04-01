<?php

namespace App\Providers;

use App\Contracts\BookingServiceInterface;
use App\Services\BookingService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Привязка интерфейса к реализации
        $this->app->bind(
            BookingServiceInterface::class,
            BookingService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
