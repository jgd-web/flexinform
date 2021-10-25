<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('cars')->truncate();
        Schema::enableForeignKeyConstraints();

        $cars = json_decode(Storage::get("json/cars.json"));
        $carsToDatabase = [];

        foreach ($cars as $car) {
            $carsToDatabase[] = [
                'car_id' => $car->car_id,
                'client_id' => $car->client_id,
                'type' => $car->type,
                'registered' => $car->registered,
                'ownbrand' => $car->ownbrand,
                'accident' => $car->accident,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ];
        }

        $chunks = array_chunk($carsToDatabase, 500);

        foreach ($chunks as $chunk) {;
            Car::insert($chunk);
        }
    }
}
