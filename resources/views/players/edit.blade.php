@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-light">Modifica Giocatore</h1>

    <!-- Form per modificare i dati del giocatore -->
    <form action="{{ route('players.update', $player->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Campo per il nome del giocatore -->
        <div class="mb-3">
            <label for="name" class="form-label text-light">Nome Giocatore</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $player->name }}" required>
        </div>

        <!-- Select per il ruolo del giocatore -->
        <div class="mb-3">
            <label for="role_id" class="form-label text-light">Ruolo</label>
            <select name="role_id" id="role_id" class="form-control" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $player->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Aggiungi qui tutti i campi della tabella players -->
        <div class="mb-3">
            <label for="raid_participations" class="form-label text-light">Raid Partecipati</label>
            <input type="number" name="raid_participations" id="raid_participations" class="form-control" value="{{ $player->raid_participations }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="priority_points" class="form-label text-light">Punti Priorità</label>
            <input type="number" name="priority_points" id="priority_points" class="form-control" value="{{ $player->priority_points }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="rare_drops_system" class="form-label text-light">Drop Rari Assegnati da Sistema</label>
            <input type="number" name="rare_drops_system" id="rare_drops_system" class="form-control" value="{{ $player->rare_drops_system }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="super_rare_drops_system" class="form-label text-light">Drop Super Rari Assegnati da Sistema</label>
            <input type="number" name="super_rare_drops_system" id="super_rare_drops_system" class="form-control" value="{{ $player->super_rare_drops_system }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="kept_rare_drop" class="form-label text-light">Ha Mantenuto il Drop Raro</label>
            <input type="number" name="kept_rare_drop" id="kept_rare_drop" class="form-control" value="{{ $player->kept_rare_drop }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="kept_super_rare_drop" class="form-label text-light">Ha Mantenuto il Drop Super Raro</label>
            <input type="number" name="kept_super_rare_drop" id="kept_super_rare_drop" class="form-control" value="{{ $player->kept_super_rare_drop }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="redistributed_rare_drop" class="form-label text-light">Drop Raro Redistribuito</label>
            <input type="number" name="redistributed_rare_drop" id="redistributed_rare_drop" class="form-control" value="{{ $player->redistributed_rare_drop }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="redistributed_super_rare_drop" class="form-label text-light">Drop Super Raro Redistribuito</label>
            <input type="number" name="redistributed_super_rare_drop" id="redistributed_super_rare_drop" class="form-control" value="{{ $player->redistributed_super_rare_drop }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="received_rare_drop" class="form-label text-light">Ha Ricevuto Drop Raro Redistribuito</label>
            <input type="number" name="received_rare_drop" id="received_rare_drop" class="form-control" value="{{ $player->received_rare_drop }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="received_super_rare_drop" class="form-label text-light">Ha Ricevuto Drop Super Raro Redistribuito</label>
            <input type="number" name="received_super_rare_drop" id="received_super_rare_drop" class="form-control" value="{{ $player->received_super_rare_drop }}" min="0" required>
        </div>

        <!-- Aggiungi i campi per i totali -->
        <div class="mb-3">
            <label for="total_rare_dropped" class="form-label text-light">Totale Drop Rari Droppati</label>
            <input type="number" name="total_rare_dropped" id="total_rare_dropped" class="form-control" value="{{ $player->total_rare_dropped }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="total_rare_system" class="form-label text-light">Totale Drop Rari Assegnati da Sistema</label>
            <input type="number" name="total_rare_system" id="total_rare_system" class="form-control" value="{{ $player->total_rare_system }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="total_rare_distributed" class="form-label text-light">Totale Drop Rari Distribuiti</label>
            <input type="number" name="total_rare_distributed" id="total_rare_distributed" class="form-control" value="{{ $player->total_rare_distributed }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="priority" class="form-label text-light">Priorità</label>
            <input type="number" name="priority" id="priority" class="form-control" value="{{ $player->priority }}" required>
        </div>

        <!-- Bottone per salvare le modifiche -->
        <button type="submit" class="btn btn-primary">Salva Modifiche</button>
        <a href="{{ route('players.index') }}" class="btn btn-secondary">Annulla</a>
    </form>
</div>
@endsection
