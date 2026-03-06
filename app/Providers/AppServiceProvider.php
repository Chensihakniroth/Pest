<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Load Railway configuration if running on Railway
        if (getenv('RAILWAY_STATIC_URL')) {
            $this->loadConfiguration();
        }

        if(config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }

    /**
     * Load Railway-specific configuration
     */
    protected function loadConfiguration()
    {
        // Override app settings for Railway
        if ($env = getenv('APP_ENV')) {
            config(['app.env' => $env]);
        }

        if ($debug = getenv('APP_DEBUG')) {
            config(['app.debug' => filter_var($debug, FILTER_VALIDATE_BOOLEAN)]);
        }

        if ($url = getenv('RAILWAY_STATIC_URL')) {
            config(['app.url' => $url]);
        }

        if ($logLevel = getenv('LOG_LEVEL')) {
            config(['app.log_level' => $logLevel]);
        }

        // Override database settings for Railway
        if ($host = getenv('MYSQLHOST')) {
            config(['database.connections.mysql.host' => $host]);
        }

        if ($port = getenv('MYSQLPORT')) {
            config(['database.connections.mysql.port' => $port]);
        }

        if ($database = getenv('MYSQLDATABASE')) {
            config(['database.connections.mysql.database' => $database]);
        }

        if ($username = getenv('MYSQLUSER')) {
            config(['database.connections.mysql.username' => $username]);
        }

        if ($password = getenv('MYSQLPASSWORD')) {
            config(['database.connections.mysql.password' => $password]);
        }
    }
}
