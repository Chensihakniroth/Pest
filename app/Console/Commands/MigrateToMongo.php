<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Payment;

class MigrateToMongo extends Command
{
    protected $signature = 'migrate:mongo';
    protected $description = 'Migrate data from MySQL to MongoDB with duplicate prevention';

    private $idMapping = [];

    public function handle()
    {
        $this->info('Testing database connections...');

        try {
            DB::connection('mongodb')->getMongoClient()->listDatabases();
            $this->info('MongoDB Connection: [CONNECTED] (✧ω✧)');
        } catch (\Exception $e) {
            $this->error('MongoDB Connection: [FAILED] - ' . $e->getMessage());
            return 1;
        }

        try {
            DB::connection('mysql')->getPdo();
            $this->info('MySQL Connection: [CONNECTED] (•̀ᴗ•́)و');
        } catch (\Exception $e) {
            $this->error('MySQL Connection: [FAILED] - ' . $e->getMessage());
            return 1;
        }

        $this->info('Starting migration to MongoDB...');

        // 1. Airports - Match by 'code'
        $this->migrateTable('airports', Airport::class, [], ['code']);

        // 2. Users - Match by 'email'
        $this->migrateTable('users', User::class, [], ['email']);

        // 3. Flights - Match by 'flight_number'
        $this->migrateTable('flights', Flight::class, [
            'origin_airport_id' => 'airports', 
            'destination_airport_id' => 'airports'
        ], ['flight_number']);

        // 4. Bookings - Match by 'booking_reference'
        $this->migrateTable('bookings', Booking::class, [
            'user_id' => 'users', 
            'flight_id' => 'flights'
        ], ['booking_reference']);

        // 5. Passengers - Match by 'passport_number' and 'booking_id'
        $this->migrateTable('passengers', Passenger::class, [
            'booking_id' => 'bookings'
        ], ['passport_number', 'booking_id']);

        // 6. Payments - Match by 'payment_reference'
        $this->migrateTable('payments', Payment::class, [
            'user_id' => 'users', 
            'booking_id' => 'bookings'
        ], ['payment_reference']);

        $this->info('Migration completed! (ﾉ◕ヮ◕)ﾉ*:･ﾟ✧');
    }

    private function migrateTable($tableName, $modelClass, $foreignKeys = [], $matchBy = [])
    {
        $this->info("Processing $tableName...");
        $this->idMapping[$tableName] = [];
        
        try {
            $records = DB::connection('mysql')->table($tableName)->get();
            
            if ($records->isEmpty()) {
                $this->warn("No records found in MySQL table: $tableName");
                return;
            }

            $skipped = 0;
            $migrated = 0;

            foreach ($records as $record) {
                $data = (array) $record;
                $mysqlId = $data['id'];
                unset($data['id']);

                // Map foreign keys to MongoDB IDs
                foreach ($foreignKeys as $key => $targetTable) {
                    if (isset($data[$key]) && isset($this->idMapping[$targetTable][$data[$key]])) {
                        $data[$key] = $this->idMapping[$targetTable][$data[$key]];
                    }
                }

                // Prepare match criteria
                $matchCriteria = [];
                foreach ($matchBy as $field) {
                    if (isset($data[$field])) {
                        $matchCriteria[$field] = $data[$field];
                    }
                }

                // Check if already exists in MongoDB
                $existing = $modelClass::where($matchCriteria)->first();
                
                if ($existing) {
                    $this->idMapping[$tableName][$mysqlId] = $existing->_id;
                    $skipped++;
                    continue;
                }

                $newModel = $modelClass::create($data);
                $this->idMapping[$tableName][$mysqlId] = $newModel->_id;
                $migrated++;
            }
            
            $this->info("Done! Migrated: $migrated, Skipped (already exists): $skipped");
        } catch (\Exception $e) {
            $this->error("Error in $tableName: " . $e->getMessage());
        }
    }
}
