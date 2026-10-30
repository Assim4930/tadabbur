<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Automatically create the SQLite database file if missing in non-memory setups
        if (config('database.default') === 'sqlite') {
            $dbPath = config('database.connections.sqlite.database');
            if ($dbPath && $dbPath !== ':memory:' && ! file_exists($dbPath)) {
                $dir = dirname($dbPath);
                if (is_dir($dir) && is_writable($dir)) {
                    @touch($dbPath);
                }
            }
        }
    }
}
