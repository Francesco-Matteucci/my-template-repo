@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-light">Aggiorna Partecipazione e Drop per {{ $player->name }}</h1>

    <form action="{{ route('players.storeAdd', $player->id) }}" method="POST">
        @csrf
        <!-- Campi di incremento/decremento -->
        <div class="mb-3">
            <label for="raid_participations" class="form-label text-light">Raid Partecipati (Incremento/Decremento)</label>
            <input type="number" name="raid_participations" id="raid_participations" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label for="rare_drops_system" class="form-label text-light">Drop Rari Assegnati da Sistema (Incremento/Decremento)</label>
            <input type="number" name="rare_drops_system" id="rare_drops_system" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label for="super_rare_drops_system" class="form-label text-light">Drop Super Rari Assegnati da Sistema (Incremento/Decremento)</label>
            <input type="number" name="super_rare_drops_system" id="super_rare_drops_system" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label for="kept_rare_drop" class="form-label text-light">Ha Mantenuto il Drop Raro (Incremento/Decremento)</label>
            <input type="number" name="kept_rare_drop" id="kept_rare_drop" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label for="kept_super_rare_drop" class="form-label text-light">Ha Mantenuto il Drop Super Raro (Incremento/Decremento)</label>
            <input type="number" name="kept_super_rare_drop" id="kept_super_rare_drop" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label for="redistributed_rare_drop" class="form-label text-light">Drop Raro Redistribuito (Incremento/Decremento)</label>
            <input type="number" name="redistributed_rare_drop" id="redistributed_rare_drop" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label for="redistributed_super_rare_drop" class="form-label text-light">Drop Super Raro Redistribuito (Incremento/Decremento)</label>
            <input type="number" name="redistributed_super_rare_drop" id="redistributed_super_rare_drop" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label for="received_rare_drop" class="form-label text-light">Ha Ricevuto Drop Raro Redistribuito (Incremento/Decremento)</label>
            <input type="number" name="received_rare_drop" id="received_rare_drop" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label for="received_super_rare_drop" class="form-label text-light">Ha Ricevuto Drop Super Raro Redistribuito (Incremento/Decremento)</label>
            <input type="number" name="received_super_rare_drop" id="received_super_rare_drop" class="form-control" value="0">
        </div>

        <button type="submit" class="btn btn-primary">Aggiorna Valori</button>
        <a href="{{ route('players.index') }}" class="btn btn-secondary">Annulla</a>
    </form>
</div>
@endsection
