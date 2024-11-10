@extends('layouts.app')

@section('content')
<div class="background-wrapper">
    <div class="fog-overlay"></div>
    <div class="content-center">
        <div class="container fc-table">
            <h1 class="display-4 title-glow text-light animate__animated animate__fadeInDown"> {{ $player->name }}</h1>

            <table class="table table-dark table-striped animate__animated animate__fadeIn">
                <tr>
                    <th>Nome Giocatore</th>
                    <td class="fw-bold name-h">{{ $player->name }}</td>
                </tr>
                <tr>
                    <th>Ruolo</th>
                    <td>
                        <span>
                            <img src="{{ asset('img/' . strtolower($player->role->name ?? 'unknown') . '.png') }}" alt="{{ $player->role->name ?? 'No Role' }}" class="role-icon"> {{ $player->role->name }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Raid Partecipati</th>
                    <td class="fw-bold name-h">{{ $player->raid_participations }}</td>
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
                    <th>Totale Droppati</th>
                    <td>{{ $player->total_rare_dropped }}</td>
                </tr>
                <tr>
                    <th>Totale Drop Mantenuti</th>
                    <td>{{ $player->total_rare_system }}</td>
                </tr>
                <tr>
                    <th>Totale Drop Redistribuiti</th>
                    <td>{{ $player->total_rare_distributed }}</td>
                </tr>
                <tr>
                    <th>Priorità</th>
                    <td class="priority-highlight">{{ $player->priority }}</td>
                </tr>
            </table>

            <a href="{{ route('players.index') }}" class="btn btn-secondary">Torna alla Lista</a>
        </div>
    </div>
</div>
@endsection

