@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-light">Assegna Punti Raid ai Giocatori</h1>

    <form action="{{ route('players.assignPoints') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="raid_points" class="form-label text-light">Punti da Aggiungere</label>
            <input type="number" name="raid_points" id="raid_points" class="form-control" min="1" required>
        </div>

        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Seleziona</th>
                    <th>Nome Giocatore</th>
                    <th>Ruolo</th>
                    <th>Raid Partecipati</th>
                </tr>
            </thead>
            <tbody>
                @foreach($players as $player)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_players[]" value="{{ $player->id }}">
                        </td>
                        <td>{{ $player->name }}</td>
                        <td>
                            <span class="badge badge-{{ strtolower($player->role->name ?? 'unknown') }}">
                                {{ $player->role->name ?? 'No Role' }}
                            </span>
                        </td>
                        <td>{{ $player->raid_participations }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Assegna Punti Raid</button>
        <a href="{{ route('players.index') }}" class="btn btn-secondary">Annulla</a>
    </form>
</div>
@endsection
