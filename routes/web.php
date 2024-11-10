<?php

use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Rotta per la homepage
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('players.index');
    }
    return view('home');
});

// Rotte di autenticazione
Auth::routes();

// Rotta per reindirizzare /home alla lista dei giocatori
Route::get('/home', function () {
    return redirect()->route('players.index');
});

// Definiamo un pattern per il parametro {player} per evitare conflitti
Route::pattern('player', '[0-9]+');

Route::middleware(['auth'])->get('/regolamento-raid', [PlayerController::class, 'showRaidRules'])->name('raid.rules');

// Gruppo di rotte protette dal middleware 'auth'
Route::middleware('auth')->group(function () {

       // Rotta per la pagina Cavallopatia
       Route::get('/players/cavallopatia', [PlayerController::class, 'cavallopatia'])
       ->name('players.cavallopatia');


    // Rotta per visualizzare il form di incremento raid
    Route::get('/players/incrementRaidForm', [PlayerController::class, 'incrementRaidForm'])
        ->name('players.incrementRaidForm');

    // Rotta per processare il form di incremento raid
    Route::post('/players/incrementRaid', [PlayerController::class, 'incrementRaid'])
        ->name('players.incrementRaid');

    // Rotta per aggiungere dati a un giocatore specifico
    Route::get('/players/{player}/add', [PlayerController::class, 'add'])
        ->name('players.add');

    // Rotta per salvare i dati aggiunti a un giocatore specifico
    Route::post('/players/{player}/storeAdd', [PlayerController::class, 'storeAdd'])
        ->name('players.storeAdd');

    // **Nuova Rotta per la Ricerca AJAX**
    Route::get('/players/search', [PlayerController::class, 'search'])
        ->name('players.search');

    // Rotte CRUD per i giocatori
    // Index - Lista dei giocatori
    Route::get('/players', [PlayerController::class, 'index'])
        ->name('players.index');

    // Create - Form per creare un nuovo giocatore
    Route::get('/players/create', [PlayerController::class, 'create'])
        ->name('players.create');

    // Store - Salva un nuovo giocatore
    Route::post('/players', [PlayerController::class, 'store'])
        ->name('players.store');

        Route::get('/players/cavallopatia', [PlayerController::class, 'cavallopatia'])
        ->name('players.cavallopatia');


    // Show - Visualizza un giocatore specifico
    Route::get('/players/{player}', [PlayerController::class, 'show'])
        ->name('players.show');

    // Edit - Form per modificare un giocatore specifico
    Route::get('/players/{player}/edit', [PlayerController::class, 'edit'])
        ->name('players.edit');

    // Update - Aggiorna un giocatore specifico
    Route::put('/players/{player}', [PlayerController::class, 'update'])
        ->name('players.update');

    // Destroy - Elimina un giocatore specifico
    Route::delete('/players/{player}', [PlayerController::class, 'destroy'])
        ->name('players.destroy');

    Route::post('/filter', [PlayerController::class, 'filter'])->name('players.filter');

});