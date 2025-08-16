<?php

namespace App\Providers;

use App\Listeners\CreateDefaultCategories;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            CreateDefaultCategories::class,
        );
        Vite::prefetch(concurrency: 3);
    }
}
