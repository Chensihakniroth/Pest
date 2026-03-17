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

        // Debug database connections (logged to Railway console)
        $this->checkDatabaseConnections();
    }

    /**
     * Check and log database connection status
     */
    protected function checkDatabaseConnections()
    {
        try {
            \Illuminate\Support\Facades\DB::connection('mongodb')->getMongoClient()->listDatabases();
            \Illuminate\Support\Facades\Log::info('MongoDB Connection: SUCCESS (✧ω✧)');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('MongoDB Connection: FAILED - ' . $e->getMessage());
        }

        try {
            \Illuminate\Support\Facades\DB::connection('mysql')->getPdo();
            \Illuminate\Support\Facades\Log::info('MySQL Connection: SUCCESS (•̀ᴗ•́)و');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('MySQL Connection: FAILED (Expected if not migrating) - ' . $e->getMessage());
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
        if ($mongoUrl = getenv('MONGO_URL')) {
            config(['database.default' => 'mongodb']);
            config(['database.connections.mongodb.dsn' => $mongoUrl]);
            if ($mongoDb = getenv('MONGODATABASE')) {
                config(['database.connections.mongodb.database' => $mongoDb]);
            }
        }

        if ($host = getenv('MYSQLHOST')) {
            config(['database.connections.mysql.host' => $host]);
            config(['database.connections.mysql.port' => getenv('MYSQLPORT')]);
            config(['database.connections.mysql.database' => getenv('MYSQLDATABASE')]);
            config(['database.connections.mysql.username' => getenv('MYSQLUSER')]);
            config(['database.connections.mysql.password' => getenv('MYSQLPASSWORD')]);
        }
    }
}
