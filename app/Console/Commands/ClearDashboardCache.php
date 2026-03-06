<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearDashboardCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:clear-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear dashboard cache to refresh statistics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cacheKeys = [
            'dashboard_users',
            'dashboard_flights',
            'dashboard_bookings',
            'dashboard_stats'
        ];

        foreach ($cacheKeys as $key) {
            if (Cache::has($key)) {
                Cache::forget($key);
                $this->info("Cleared cache: {$key}");
            } else {
                $this->comment("Cache not found: {$key}");
            }
        }

        $this->info('Dashboard cache cleared successfully!');
        $this->info('Statistics will be regenerated on next dashboard load.');

        return 0;
    }
}
