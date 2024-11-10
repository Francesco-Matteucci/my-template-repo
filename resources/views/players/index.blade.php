@extends('layouts.app')

@section('content')
<div class="background-wrapper">
    <div class="fog-overlay"></div>
    <div class="content-center">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="display-4 title-glow text-light animate__animated animate__fadeInDown">La Forgia Celeste</h1>
                <!-- Input di ricerca -->
                <div class="search-container">
                    <input type="text" id="search" class="form-control" placeholder="Cerca giocatore">
                    <i class="bi bi-search search-icon"></i>
                </div>
            </div>

            <!-- Bottoni per admin -->
            @if(auth()->check() && auth()->user()->is_admin)
                <a href="{{ route('players.create') }}" class="btn btn-primary mb-3 animate__animated animate__fadeInLeft">Arruola un Nuovo Guerriero</a>
                <a href="{{ route('players.incrementRaidForm') }}" class="btn btn-secondary mb-3 animate__animated animate__fadeInRight">Aggiungi Raid ai Giocatori</a>

                <!-- Pulsanti per filtrare i giocatori -->
                <div class="mb-3">
                    <button type="button" class="btn btn-primary mb-3 animate__animated animate__fadeInLeft" id="filter-selected-btn">Filtra Selezionati</button>
                    <button type="button" class="btn btn-secondary mb-3 animate__animated animate__fadeInRight" id="reset-filter-btn" style="display: none;">Reset Filtri</button>
                </div>
            @endif

            <!-- Tabella dei giocatori -->
            <div class="animate__animated animate__fadeIn">
                <table class="table table-dark table-striped" id="players-table">
                    <thead class="name-h fw-bold">
                        <tr>
                            @if(auth()->check() && auth()->user()->is_admin)
                            <th>
                                <input type="checkbox" id="select-all-checkboxes">
                            </th>
                            @endif
                            <th>
                                <a href="#" class="sortable" data-sort="name">Nome Giocatore
                                    @if ($sortBy === 'name')
                                        <i class="bi bi-arrow-{{ $sortOrder === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Ruolo</th>
                            <th>
                                <a href="#" class="sortable" data-sort="raid_participations">Raid Partecipati
                                    @if ($sortBy === 'raid_participations')
                                        <i class="bi bi-arrow-{{ $sortOrder === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="#" class="sortable" data-sort="priority">Priorità
                                    @if ($sortBy === 'priority')
                                        <i class="bi bi-arrow-{{ $sortOrder === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody class="fs-4">
                        @foreach($players as $player)
                            <tr>
                                @if(auth()->check() && auth()->user()->is_admin)
                                <td>
                                    <input type="checkbox" class="player-checkbox" value="{{ $player->id }}">
                                </td>
                                @endif
                                <td class="fw-bold name-h">{{ $player->name }}</td>
                                <td>
                                    <span>
                                        <img src="{{ asset('img/' . strtolower($player->role->name ?? 'unknown') . '.png') }}" alt="{{ $player->role->name ?? 'No Role' }}" class="role-icon">
                                    </span>
                                </td>
                                <td class="fw-bold name-h">{{ $player->raid_participations }}</td>
                                <td class="priority-highlight">{{ $player->priority }}</td>
                                <td>
                                    <a href="{{ route('players.show', $player->id) }}" class="btn btn-info btn-sm">Visualizza</a>
                                    @if(auth()->check() && auth()->user()->is_admin)
                                        <a href="{{ route('players.edit', $player->id) }}" class="btn btn-warning btn-sm">Modifica</a>
                                        <a href="{{ route('players.add', $player->id) }}" class="btn btn-success btn-sm">Aggiungi</a>
                                        <form action="{{ route('players.destroy', $player->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Sei sicuro di voler eliminare questo giocatore?')">Elimina</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginazione -->
            <div class="d-flex justify-content-center">
                {{ $players->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Includi Animate.css se non già incluso -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<!-- Includi Bootstrap Icons se non già incluso -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
    // Definiamo le variabili JavaScript necessarie
    const searchUrl = "{{ route('players.search') }}";
    const isAdmin = @json(auth()->check() && auth()->user()->is_admin);
    const csrfToken = "{{ csrf_token() }}";
</script>

<script>
    // Seleziona/Deseleziona tutte le caselle di controllo (solo se l'utente è admin)
    if (isAdmin) {
        document.getElementById('select-all-checkboxes').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.player-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Funzione per filtrare i giocatori selezionati
        document.getElementById('filter-selected-btn').addEventListener('click', function() {
            // Ottieni gli ID dei giocatori selezionati
            let selectedPlayerIds = [];
            document.querySelectorAll('.player-checkbox:checked').forEach(function(checkbox) {
                selectedPlayerIds.push(checkbox.value);
            });

            if (selectedPlayerIds.length === 0) {
                alert('Per favore, seleziona almeno un giocatore.');
                return;
            }

            // Effettua una richiesta AJAX per ottenere solo i giocatori selezionati
            fetch(`{{ route('players.filter') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ player_ids: selectedPlayerIds })
            })
            .then(response => response.json())
            .then(data => {
                // Aggiorna la tabella con i giocatori filtrati
                updatePlayersTable(data.players);
                // Nascondi il pulsante "Filtra" e mostra "Reset Filtri"
                document.getElementById('filter-selected-btn').style.display = 'none';
                document.getElementById('reset-filter-btn').style.display = 'inline-block';
            })
            .catch(error => {
                console.error('Errore nel filtraggio:', error);
            });
        });

        // Funzione per resettare i filtri
        document.getElementById('reset-filter-btn').addEventListener('click', function() {
            // Ricarica la pagina per ripristinare lo stato originale
            window.location.reload();
        });
    }

    // Funzione per aggiornare la tabella dei giocatori
    function updatePlayersTable(players) {
        let tbodyContent = '';
        if (players.length > 0) {
            players.forEach(player => {
                tbodyContent += `
                    <tr>
                        ${isAdmin ? `
                        <td>
                            <input type="checkbox" class="player-checkbox" value="${player.id}">
                        </td>
                        ` : ''}
                        <td class="fw-bold name-h">${player.name}</td>
                        <td>
                            <span>
                                <img src="/img/${player.role ? player.role.name.toLowerCase() : 'unknown'}.png" alt="${player.role ? player.role.name : 'No Role'}" class="role-icon">
                            </span>
                        </td>
                        <td class="fw-bold name-h">${player.raid_participations}</td>
                        <td class="priority-highlight">${player.priority}</td>
                        <td>
                            <a href="/players/${player.id}" class="btn btn-info btn-sm">Visualizza</a>
                            ${isAdmin ? `
                                <a href="/players/${player.id}/edit" class="btn btn-warning btn-sm">Modifica</a>
                                <a href="/players/${player.id}/add" class="btn btn-success btn-sm">Aggiungi</a>
                                <form action="/players/${player.id}" method="POST" class="d-inline delete-form">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Sei sicuro di voler eliminare questo giocatore?')">Elimina</button>
                                </form>
                            ` : ''}
                        </td>
                    </tr>
                `;
            });
        } else {
            tbodyContent = `
                <tr>
                    <td colspan="${isAdmin ? '6' : '5'}">Nessun giocatore trovato.</td>
                </tr>
            `;
        }
        document.querySelector('#players-table tbody').innerHTML = tbodyContent;

        // Se l'utente è admin, riapplica lo stile alle caselle di controllo
        if (isAdmin) {
            const checkboxes = document.querySelectorAll('.player-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.style.transform = 'scale(1.2)';
                checkbox.style.marginRight = '5px';
            });
        }
    }

    // Funzione di ricerca AJAX
    document.getElementById('search').addEventListener('keyup', function() {
        let query = this.value;
        let tbody = document.querySelector('#players-table tbody');

        // Aggiungi classe di caricamento
        tbody.classList.add('loading');

        fetch(`${searchUrl}?search=${encodeURIComponent(query)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            updatePlayersTable(data.players);

            // Rimuovi classe di caricamento
            tbody.classList.remove('loading');
        })
        .catch(error => {
            console.error('Errore nella ricerca AJAX:', error);
            // Rimuovi classe di caricamento
            tbody.classList.remove('loading');
        });
    });

    // Funzione per l'ordinamento
    document.querySelectorAll('.sortable').forEach(function (header) {
        header.addEventListener('click', function (e) {
            e.preventDefault();

            let sortBy = this.dataset.sort;
            let currentOrder = '{{ $sortOrder }}';
            let sortOrder = (currentOrder === 'asc') ? 'desc' : 'asc';

            // Aggiunge i parametri di ordinamento all'URL mantenendo la query di ricerca
            let searchQuery = document.getElementById('search').value;
            window.location.href = `?sort_by=${sortBy}&sort_order=${sortOrder}&search=${encodeURIComponent(searchQuery)}`;
        });
    });

    // Applica stile alle caselle di controllo (opzionale)
    document.addEventListener('DOMContentLoaded', function() {
        if (isAdmin) {
            const checkboxes = document.querySelectorAll('.player-checkbox, #select-all-checkboxes');
            checkboxes.forEach(checkbox => {
                checkbox.style.transform = 'scale(1.2)';
                checkbox.style.marginRight = '5px';
            });
        }
    });
</script>
@endsection
