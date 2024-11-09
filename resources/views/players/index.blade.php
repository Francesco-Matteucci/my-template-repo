<!-- index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="background-wrapper">
    <div class="fog-overlay"></div>
    <div class="content-center">
        <div class="container">
            <h1>La Forgia Celeste - Lista dei Giocatori</h1>
            <a href="{{ route('players.create') }}" class="btn btn-primary mb-3">Arruola un Nuovo Guerriero</a>

            <!-- Pulsante per assegnare punti raid -->
            <a href="{{ route('players.assignPoints') }}" class="btn btn-secondary mb-3">Assegna Punti Raid</a>

            <!-- Tabella dei giocatori -->
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Nome Giocatore</th>
                        <th>Ruolo</th>
                        <th>Raid Partecipati</th>
                        <th>Priorità</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($players as $player)
                        <tr>
                            <td>{{ $player->name }}</td>
                            <td>
                                <span class="badge badge-{{ strtolower($player->role->name ?? 'unknown') }}">
                                    {{ $player->role->name ?? 'No Role' }}
                                </span>
                            </td>
                            <td>{{ $player->raid_participations }}</td>
                            <td class="priority-highlight">{{ $player->priority }}</td>
                            <td>
                                <a href="{{ route('players.show', $player->id) }}" class="btn btn-info btn-sm">Visualizza</a>
                                <a href="{{ route('players.edit', $player->id) }}" class="btn btn-warning btn-sm">Modifica</a>
                                <a href="{{ route('players.add', $player->id) }}" class="btn btn-success btn-sm">Aggiungi</a>
                                <form action="{{ route('players.destroy', $player->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Sei sicuro di voler eliminare questo giocatore?')">Elimina</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginazione -->
            <div class="d-flex justify-content-center">
                {{ $players->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
