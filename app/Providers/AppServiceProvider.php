<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enumerators\Webmania;
use Illuminate\Support\Facades\Http;
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
        Http::macro(
            Webmania::WEBMANIA->value,
            fn () => Http::withHeaders(Webmania::getHeaders())->baseUrl(Webmania::getApiURI())
        );
    }
}
