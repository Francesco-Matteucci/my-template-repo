@extends('layouts.app')

@section('content')
<div class="background-wrapper">
    <div class="fog-overlay"></div>
    <div class="content-center">
        <div class="container">
            <h1>Aggiungi Raid ai Giocatori</h1>

            <!-- Mostra i messaggi di errore, se presenti -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form per incrementare le partecipazioni raid -->
            <form action="{{ route('players.incrementRaid') }}" method="POST">
                @csrf

                <!-- Campo per specificare il numero di raid da aggiungere -->
                <div class="form-group mb-4">
                    <label for="increment_value">Numero di Raid da aggiungere:</label>
                    <input type="number" name="increment_value" id="increment_value" class="form-control" value="1" min="1" required>
                </div>

                <!-- Tabella con la lista dei giocatori -->
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <!-- Checkbox "Seleziona Tutti" nella colonna corretta -->
                            <th>
                                <input type="checkbox" id="select_all">
                            </th>
                            <th>Nome Giocatore</th>
                            <th>Ruolo</th>
                            <th>Raid Partecipati</th>
                            <th>Priorità</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($players as $player)
                            <tr>
                                <!-- Checkbox per selezionare il giocatore -->
                                <td>
                                    <input type="checkbox" name="selected_players[]" value="{{ $player->id }}" class="player-checkbox">
                                </td>
                                <td>{{ $player->name }}</td>
                                <td>
                                    <span class="badge badge-{{ strtolower($player->role->name ?? 'unknown') }}">
                                        {{ $player->role->name ?? 'No Role' }}
                                    </span>
                                </td>
                                <td>{{ $player->raid_participations }}</td>
                                <td class="priority-highlight">{{ $player->priority }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Bottone per inviare il form -->
                <button type="submit" class="btn btn-primary">Aggiorna Raid Partecipati</button>
                <a href="{{ route('players.index') }}" class="btn btn-secondary ml-2">Annulla</a>
            </form>
        </div>
    </div>
</div>

<!-- Script per selezionare/deselezionare tutti i giocatori -->
@section('scripts')
<script>
    document.getElementById('select_all').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('.player-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    document.querySelectorAll('.player-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            let allChecked = document.querySelectorAll('.player-checkbox:checked').length === document.querySelectorAll('.player-checkbox').length;
            document.getElementById('select_all').checked = allChecked;
        });
    });
</script>
@endsection

@endsection
