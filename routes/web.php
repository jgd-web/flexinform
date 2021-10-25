<?php

use App\Http\Controllers\CarServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [CarServiceController::class, 'index'])->name('index');
Route::get('ajax/get-client-cars/{clientId}', [CarServiceController::class, 'getClientCars'])->name('ajax-get-client-cars');
Route::get('ajax/get-client-car-services/{clientId}/{carId}', [CarServiceController::class, 'getClientCarServices'])->name('ajax-get-client-car-services');
Route::post('ajax/client-search', [CarServiceController::class, 'clientSearch'])->name('ajax-client-search');

