<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemperatuurController;

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

Route::get('/', [TemperatuurController::class, 'index']);
Route::get('overzicht', [TemperatuurController::class, 'detail']);
Route::get('contact', [TemperatuurController::class, 'contact']);
Route::post('nieuwsbrief', [TemperatuurController::class, 'nieuwsbrief']);
