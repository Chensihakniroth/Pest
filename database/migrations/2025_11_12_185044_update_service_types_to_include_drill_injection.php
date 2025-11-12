<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateServiceTypesToIncludeDrillInjection extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update customers table service_type enum
        DB::statement("ALTER TABLE customers MODIFY COLUMN service_type ENUM('baiting_system_complete', 'baiting_system_not_complete', 'host_system', 'drill_injection')");

        // Update maintenance_histories table service_type enum
        DB::statement("ALTER TABLE maintenance_histories MODIFY COLUMN service_type ENUM('baiting_system_complete', 'baiting_system_not_complete', 'host_system', 'drill_injection')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE customers MODIFY COLUMN service_type ENUM('baiting_system_complete', 'baiting_system_not_complete', 'host_system')");
        DB::statement("ALTER TABLE maintenance_histories MODIFY COLUMN service_type ENUM('baiting_system_complete', 'baiting_system_not_complete', 'host_system')");
    }
}
