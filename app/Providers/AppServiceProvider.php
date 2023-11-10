<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\UrlGenerator;
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
     * @param UrlGenerator $url
     */
    public function boot(UrlGenerator $url): void
    {
        JsonResource::withoutWrapping();
        if (env('APP_ENV') == 'production') {
            // $url->forceScheme('https');
        }
    }
}
