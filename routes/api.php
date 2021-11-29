<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\AtletaController;
use App\Http\Controllers\TimeCampeonatoController;
use App\Http\Controllers\CampeonatoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//time, atleta, campeonato, timecampeonato

Route::group(['prefix' => 'time'], function () {
    Route::get('', 'App\Http\Controllers\TimeController@listaTimes'); //Ok 

    Route::post('', [TimeController::class, 'addTime']); //Ok

    Route::put('/update/{id}', 'App\Http\Controllers\TimeController@updateTime'); //Ok

    Route::delete('/delete/{id}', 'App\Http\Controllers\TimeController@deleteTime'); //Ok

    Route::get('/detalhe/{id}', 'App\Http\Controllers\TimeController@detalhe'); //Ok
});

Route::group(['prefix' => 'atleta'], function () {
    Route::get('', 'App\Http\Controllers\AtletaController@listaAtletas'); //Ok 

    Route::post('', [AtletaController::class, 'addAtleta']); //Ok

    Route::put('/update/{id}', 'App\Http\Controllers\AtletaController@updateAtleta'); //Ok

    Route::delete('/delete/{id}', 'App\Http\Controllers\AtletaController@deleteAtleta'); //Ok

    Route::get('/detalhe/{id}', 'App\Http\Controllers\AtletaController@detalhe'); //Ok
});

Route::group(['prefix' => 'campeonato'], function () {
    
    Route::get('', 'App\Http\Controllers\CampeonatoController@listaCampeonatos'); //Ok 

    Route::post('', [CampeonatoController::class, 'addCampeonato']); //Ok

    Route::put('/update/{id}', 'App\Http\Controllers\CampeonatoController@updateCampeonato'); //Ok

    Route::delete('/delete/{id}', 'App\Http\Controllers\CampeonatoController@deleteCampeonato'); //Ok

    Route::get('/detalhe/{id}', 'App\Http\Controllers\CampeonatoController@detalhe'); //Ok
});

Route::group(['prefix' => 'timecampeonato'], function () {

    Route::get('', 'App\Http\Controllers\TimeCampeonatoController@listaTimeCampeonatos'); //Ok 

    Route::post('', [TimeCampeonatoController::class, 'addTimeCampeonato']); //Ok

    Route::put('/update/{id}', 'App\Http\Controllers\TimeCampeonatoController@updateTimeCampeonato'); //Ok

    Route::delete('/delete/{id}', 'App\Http\Controllers\TimeCampeonatoController@deleteTimeCampeonato'); //Ok

    Route::get('/detalhe/{id}', 'App\Http\Controllers\TimeCampeonatoController@detalhe'); //Ok
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});