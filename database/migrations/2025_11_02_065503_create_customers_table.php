<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_customers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->unique();
            $table->string('name');
            $table->text('address');
            $table->string('google_map_link')->nullable();
            $table->string('phone_number');
            $table->string('service_name');
            $table->decimal('service_price', 10, 2);
            $table->enum('service_type', ['baiting_system_complete', 'baiting_system_not_complete', 'host_system']);
            $table->date('contract_start_date');
            $table->date('contract_end_date');
            $table->enum('status', ['active', 'expired', 'pending'])->default('active');
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};