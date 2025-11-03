<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_columns_to_maintenance_history_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('maintenance_history', function (Blueprint $table) {
            // Add customer_id foreign key
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            
            // Add maintenance_date
            $table->date('maintenance_date');
            
            // Add service_type enum
            $table->enum('service_type', [
                'baiting_system_complete', 
                'baiting_system_not_complete', 
                'host_system'
            ]);
            
            // Add notes column
            $table->text('notes')->nullable();
            
            // Add performed_by column
            $table->string('performed_by');
            
            // Add index for better performance
            $table->index(['customer_id', 'maintenance_date']);
        });
    }

    public function down()
    {
        Schema::table('maintenance_history', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropIndex(['customer_id', 'maintenance_date']);
            $table->dropColumn([
                'customer_id',
                'maintenance_date', 
                'service_type',
                'notes',
                'performed_by'
            ]);
        });
    }
};