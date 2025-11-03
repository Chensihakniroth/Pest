<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_maintenance_history_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('maintenance_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->date('maintenance_date');
            $table->string('service_type');
            $table->text('notes')->nullable();
            $table->string('performed_by');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('maintenance_history');
    }
};