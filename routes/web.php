<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/time', function() {
    return view('time.listagem');
});

Route::get('/campeonato', function() {
    return view('campeonato.listagem');
});

Route::get('/atleta', function() {
    return view('atleta.listagem');
});

Route::get('/timecampeonato', function() {
    return view('time_campeonato.listagem');
});