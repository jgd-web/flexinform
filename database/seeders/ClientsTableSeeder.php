<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('clients')->truncate();
        Schema::enableForeignKeyConstraints();

        $clients = json_decode(Storage::get("json/clients.json"));
        $clientsToDatabase = [];

        foreach ($clients as $client) {
            $clientsToDatabase[] = [
                'id' => $client->id,
                'name' => $client->name,
                'idcard' => $client->idcard,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ];
        }

        $chunks = array_chunk($clientsToDatabase, 500);

        foreach ($chunks as $chunk) {
            Client::insert($chunk);
        }
    }
}
