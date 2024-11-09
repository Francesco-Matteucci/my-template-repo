@extends('layouts.app')

@section('content')
<div class="container fc-table">
    <h1 class="text-light">Dettagli Giocatore: {{ $player->name }}</h1>

    <table class="table table-dark table-striped">
        <tr>
            <th>Nome Giocatore</th>
            <td>{{ $player->name }}</td>
        </tr>
        <tr>
            <th>Ruolo</th>
            <td>
                <span class="badge badge-{{ strtolower($player->role->name ?? 'unknown') }}">
                    {{ $player->role->name ?? 'No Role' }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Raid Partecipati</th>
            <td>{{ $player->raid_participations }}</td>
        </tr>
        <tr>
            <th>Drop Rari Assegnati da Sistema</th>
            <td>{{ $player->rare_drops_system }}</td>
        </tr>
        <tr>
            <th>Drop Super Rari Assegnati da Sistema</th>
            <td>{{ $player->super_rare_drops_system }}</td>
        </tr>
        <tr>
            <th>Drop Raro Redistribuito</th>
            <td>{{ $player->redistributed_rare_drop }}</td>
        </tr>
        <tr>
            <th>Drop Super Raro Redistribuito</th>
            <td>{{ $player->redistributed_super_rare_drop }}</td>
        </tr>
        <tr>
            <th>Ha Ricevuto Drop Raro Redistribuito</th>
            <td>{{ $player->received_rare_drop }}</td>
        </tr>
        <tr>
            <th>Ha Ricevuto Drop Super Raro Redistribuito</th>
            <td>{{ $player->received_super_rare_drop }}</td>
        </tr>
        <tr>
            <th>Totale Drop Rari Droppati</th>
            <td>{{ $player->total_rare_dropped }}</td>
        </tr>
        <tr>
            <th>Totale Drop Rari Assegnati da Sistema</th>
            <td>{{ $player->total_rare_system }}</td>
        </tr>
        <tr>
            <th>Totale Drop Rari Distribuiti</th>
            <td>{{ $player->total_rare_distributed }}</td>
        </tr>
        <tr>
            <th>Priorità</th>
            <td>{{ $player->priority }}</td>
        </tr>
    </table>

    <a href="{{ route('players.index') }}" class="btn btn-secondary">Torna alla Lista</a>
</div>
@endsection
