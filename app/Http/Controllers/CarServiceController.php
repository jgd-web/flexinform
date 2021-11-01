<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientSearchRequest;
use App\Services\CarService;
use App\Services\CheckDatabaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarServiceController extends Controller
{
    private CheckDatabaseService $checkDatabaseService;
    private CarService $carService;

    public function __construct(CheckDatabaseService $checkDatabaseService, CarService $carService)
    {
        $this->checkDatabaseService = $checkDatabaseService;
        $this->carService = $carService;
    }

    // Grid betöltése
    public function index()
    {
        $this->checkDatabaseService->check();
        $clients = $this->carService->getClients();

        return view('clients/index')->with(compact('clients'));
    }

    // Ajax végpont a klienshez tartozó járművek lekérdezéséhez
    public function getClientCars(int $clientId, Request $request): JsonResponse
    {
        if (!$request->ajax()) {
            return $this->sendOnlyAjaxError();
        }

        $clientCars = $this->carService->getClientCars($clientId);
        return response()->json(['data' => $clientCars]);
    }

    // Ajax végpont a járműhöz tartozó szervízek lekérdezéséhez.
    public function getClientCarServices(int $clientId, int $carId, Request $request): JsonResponse
    {
        if (!$request->ajax()) {
            return $this->sendOnlyAjaxError();
        }

        $clientCars = $this->carService->getClientCarServices($clientId, $carId);
        return response()->json(['data' => $clientCars]);
    }

    // Ajax végpont kliensek keresésére. Az adatok validálását a ClientSearchRequest végzi.
    public function clientSearch(ClientSearchRequest $request): JsonResponse
    {
        if (!$request->ajax()) {
            return $this->sendOnlyAjaxError();
        }

        // Bejövő paraméterek kinyerése
        $input = $request->all();
        $clientData = $this->carService->getClientData($request->validated());

        if ($clientData['count'] > 1) {
            return $this->customErrorResponse('A keresés több mint 1 darab találatot eredményezett!');
        }

        return response()->json(['data' => $clientData['data']]);
    }

    // Csak ajax hívás a megengedett.
    private function sendOnlyAjaxError(): JsonResponse
    {
        return response()->json([
            'error' => 'true',
            'message' => 'Only ajax request accpetable!'
        ]);
    }

    // Egyedi hibaüzenet.
    private function customErrorResponse(string $message): JsonResponse
    {
        return response()->json(
            [
                'message' => $message,
                'errors' => [
                    'client_name' => $message
                ]
            ], 422);
    }
}
