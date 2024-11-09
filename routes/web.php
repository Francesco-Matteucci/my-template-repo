<?php

use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('players.index');
    }
    return view('home');
});

Auth::routes();

Route::get('/home', function () {
    return redirect()->route('players.index');
});

Route::resource('players', PlayerController::class)->middleware('auth');
Route::get('/players/{player}/add', [PlayerController::class, 'add'])->name('players.add');
Route::post('/players/{player}/storeAdd', [PlayerController::class, 'storeAdd'])->name('players.storeAdd');


Route::get('/players/assignPoints', [PlayerController::class, 'assignPointsPage'])->name('players.assignPoints');
Route::post('/players/assignPoints', [PlayerController::class, 'assignPoints'])->name('players.assignPoints');