<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

final class AppServiceProvider extends ServiceProvider
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
        // @codeCoverageIgnoreStart
        // Force root URL for all routes (even Livewire)
        URL::forceRootUrl(Config::string('app.url'));
        if (Str::contains(Config::string('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
        // @codeCoverageIgnoreEnd
    }
}
