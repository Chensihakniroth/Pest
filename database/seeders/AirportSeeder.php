<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Airport; // Import the Airport model

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airports = [
            ['code' => 'JFK', 'name' => 'John F. Kennedy International Airport', 'city' => 'New York', 'country' => 'USA'],
            ['code' => 'LAX', 'name' => 'Los Angeles International Airport', 'city' => 'Los Angeles', 'country' => 'USA'],
            ['code' => 'ORD', 'name' => 'O\'Hare International Airport', 'city' => 'Chicago', 'country' => 'USA'],
            ['code' => 'LHR', 'name' => 'Heathrow Airport', 'city' => 'London', 'country' => 'UK'],
            ['code' => 'CDG', 'name' => 'Charles de Gaulle Airport', 'city' => 'Paris', 'country' => 'France'],
            ['code' => 'DXB', 'name' => 'Dubai International Airport', 'city' => 'Dubai', 'country' => 'UAE'],
            ['code' => 'HND', 'name' => 'Haneda Airport', 'city' => 'Tokyo', 'country' => 'Japan'],
            ['code' => 'SYD', 'name' => 'Sydney Airport', 'city' => 'Sydney', 'country' => 'Australia'],
            ['code' => 'PEK', 'name' => 'Beijing Capital International Airport', 'city' => 'Beijing', 'country' => 'China'],
            ['code' => 'FRA', 'name' => 'Frankfurt Airport', 'city' => 'Frankfurt', 'country' => 'Germany'],
            ['code' => 'AMS', 'name' => 'Amsterdam Airport Schiphol', 'city' => 'Amsterdam', 'country' => 'Netherlands'],
            ['code' => 'SIN', 'name' => 'Singapore Changi Airport', 'city' => 'Singapore', 'country' => 'Singapore'],
            ['code' => 'MAD', 'name' => 'Adolfo Suárez Madrid–Barajas Airport', 'city' => 'Madrid', 'country' => 'Spain'],
            ['code' => 'FCO', 'name' => 'Leonardo da Vinci–Fiumicino Airport', 'city' => 'Rome', 'country' => 'Italy'],
            ['code' => 'GRU', 'name' => 'São Paulo/Guarulhos International Airport', 'city' => 'São Paulo', 'country' => 'Brazil'],
            ['code' => 'CPT', 'name' => 'Cape Town International Airport', 'city' => 'Cape Town', 'country' => 'South Africa'],
        ];

        foreach ($airports as $airportData) {
            Airport::firstOrCreate(
                ['code' => $airportData['code']],
                $airportData
            );
        }
    }
}
