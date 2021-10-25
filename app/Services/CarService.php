<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CarService
{
    // Az összes kliens lekérdezése lapozóval.
    public function getClients(): LengthAwarePaginator
    {
        return Client::paginate(10);
    }

    // A klienshez tartozó atók lekérdezése
    public function getClientCars(int $clientID): array
    {
        $ownBrandLookUp = [
            0 => 'Nem',
            1 => 'Igen'
        ];

        $clientCars = DB::table('services')
            ->select([
                'services.car_id',
                'services.client_id',
                'cars.type',
                'cars.registered',
                'cars.ownbrand',
                'cars.accident'
            ])
            ->selectRaw('MAX(services.lognumber) AS lognumber')
            ->join('cars', function ($join) {
                $join->on('cars.car_id', '=', 'services.car_id');
                $join->on('cars.client_id', '=', 'services.client_id');
            })
            ->where('services.client_id', '=', $clientID)
            ->groupBy(['services.car_id', 'services.client_id'])
            ->get()
            ->toArray();

        foreach ($clientCars as $clientCar) {
            $clientCar->ownbrand = $ownBrandLookUp[$clientCar->ownbrand];
        }

        return $clientCars;
    }

    // Az autóhoz tartozó szervízek lekérdezése.
    public function getClientCarServices(int $clientId, int $carId): array
    {
        return DB::table('services')
            ->select([
                'services.lognumber',
                'services.event',
                'services.eventtime',
                'services.document_id',
                'cars.registered'
            ])
            ->join('cars', function ($join) {
                $join->on('cars.car_id', '=', 'services.car_id');
                $join->on('cars.client_id', '=', 'services.client_id');
            })
            ->where('services.client_id', '=', $clientId)
            ->where('services.car_id', '=', $carId)
            ->get()
            ->toArray();
    }

    public function getClientData(array $validatedInput): array
    {
        $clients = [
            'count' => 1,
        ];

        // Ha csak idcard érkezett.
        if ($validatedInput['client_name'] === null) {
            $clients['data'] = DB::table('clients')
                ->select(['id', 'name', 'idcard'])
                ->where('idcard', '=', $validatedInput['idcard'])
                ->get()
                ->toArray();
        } else {
            // Ha csak kliens név érkezett.
            $clients['data'] = DB::table('clients')
                ->select(['id', 'name', 'idcard'])
                ->where('name', 'LIKE', '%'.$validatedInput['client_name'].'%')
                ->get()
                ->toArray();
        }

        // Ha több mint egy találat van (kliens név alapján) rögtön visszatérünk.
        if (count($clients['data']) > 1) {
            $clients['count'] = count($clients);
            return $clients;
        }

        // Ha a lekérdezésnek nincs eredménye rögtön visszatérünk.
        if (count($clients['data']) == 0) {
            return $clients;
        }

        // Ha egy konkrét találat van akkor lekérjük a klienshez tartozó autók és szervízek számát.
        $clientCountCars = DB::table('cars')
            ->where('client_id', '=', $clients['data'][0]->id)
            ->count('car_id');

        $clientServices = DB::table('services')
            ->where('client_id', '=', $clients['data'][0]->id)
            ->count('client_id');
        // A lekérdezett adatokat átadjuk a kliens objektumnak és visszatérünk vele.
        $clients['data'][0]->countCars = $clientCountCars;
        $clients['data'][0]->countServices = $clientServices;

        return $clients;
    }
}
