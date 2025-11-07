<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Add missing columns in the correct order with safety checks
            if (!Schema::hasColumn('customers', 'customer_id')) {
                $table->string('customer_id')->unique()->after('id');
            }

            if (!Schema::hasColumn('customers', 'name')) {
                $table->string('name')->after('customer_id');
            }

            if (!Schema::hasColumn('customers', 'address')) {
                $table->text('address')->after('name');
            }

            if (!Schema::hasColumn('customers', 'phone_number')) {
                $table->string('phone_number')->after('address');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['customer_id', 'name', 'address', 'phone_number']);
        });
    }
};
