<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('maintenance_histories', function (Blueprint $table) {
            // Make sure these columns exist
            if (!Schema::hasColumn('maintenance_histories', 'status')) {
                $table->enum('status', ['completed', 'pending', 'cancelled'])->default('completed');
            }
        });
    }

    public function down(): void
    {
        // No need to drop columns in down method
    }
};
