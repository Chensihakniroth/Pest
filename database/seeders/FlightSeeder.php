<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Airport;
use App\Models\Flight;
use Carbon\Carbon;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airports = Airport::all();

        if ($airports->isEmpty()) {
            $this->call(AirportSeeder::class);
            $airports = Airport::all();
        }

        $airlines = ['Airline A', 'Airline B', 'Airline C', 'Airline D'];

        foreach ($airports as $originAirport) {
            foreach ($airports as $destinationAirport) {
                if ($originAirport->id === $destinationAirport->id) {
                    continue; // Skip flights to the same airport
                }

                for ($i = 0; $i < 3; $i++) { // Create 3 flights between each pair of airports
                    $departureTime = Carbon::now()->addDays(rand(1, 60))->addHours(rand(0, 23))->addMinutes(rand(0, 59));
                    $arrivalTime = $departureTime->copy()->addHours(rand(2, 10))->addMinutes(rand(0, 59));
                    $price = rand(100, 1000) / 100 * 100; // Price in hundreds
                    $airline = $airlines[array_rand($airlines)];
                    $flightNumber = strtoupper(substr($airline, 0, 2)) . rand(1000, 9999);
                    $capacity = rand(100, 200);

                    Flight::firstOrCreate(
                        ['flight_number' => $flightNumber],
                        [
                            'origin_airport_id' => $originAirport->id,
                            'destination_airport_id' => $destinationAirport->id,
                            'departure_time' => $departureTime,
                            'arrival_time' => $arrivalTime,
                            'price' => $price,
                            'airline' => $airline,
                            'capacity' => $capacity,
                        ]
                    );
                }
            }
        }
    }
}