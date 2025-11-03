<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->date('maintenance_date'); // Date when maintenance was performed
            $table->enum('service_type', ['baiting_system_complete', 'baiting_system_not_complete', 'host_system']);
            $table->string('performed_by')->nullable(); // Employee name
            $table->text('notes')->nullable(); // Any notes about the maintenance
            $table->enum('status', ['completed', 'pending', 'cancelled'])->default('completed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_histories');
    }
};