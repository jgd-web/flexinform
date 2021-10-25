<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ServicesTableSeeder extends Seeder
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

        $services = json_decode(Storage::get("json/services.json"));
        $servicesToDatabase = [];

        foreach ($services as $service) {
            $servicesToDatabase[] = [
                'car_id' => $service->car_id,
                'client_id' => $service->client_id,
                'lognumber' => $service->lognumber,
                'event' => $service->event,
                'eventtime' => $service->eventtime ?? null,
                'document_id' => $service->document_id,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ];
        }

        $chunks = array_chunk($servicesToDatabase, 500);

        foreach ($chunks as $chunk) {
            Service::insert($chunk);
        }
    }
}
