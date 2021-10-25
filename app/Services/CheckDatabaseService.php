<?php

namespace App\Services;

use App\Models\Car;
use App\Models\Client;
use App\Models\Service;
use Illuminate\Support\Facades\Artisan;

class CheckDatabaseService
{
    // Leellenőrizzük, hogy bármelyik tábla üres-e. Ha igen akkor újrahúzzuk az adatbázist a seeder osztályok segítségével.
    // Éles környezetben nem tennék ilyet!
    public function check()
    {
        $clients = Client::exists();
        $cars = Car::exists();
        $services = Service::exists();

        if (!$clients || !$cars || !$services) {
            Artisan::call('db:seed');
        }
    }
}
