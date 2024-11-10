@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cavallopatia</h1>
    <p>Seleziona i giocatori che parteciperanno alla corsa:</p>

    <!-- Form di selezione dei giocatori -->
    <form id="race-form">
        @csrf
        <div class="form-check mb-3 fs-3">
            <input type="checkbox" class="form-check-input" id="select-all">
            <label class="form-check-label fs-3" for="select-all">Seleziona tutti i giocatori</label>
        </div>

        <div class="mb-3">
            @foreach($players as $player)
                <div class="form-check mb-3 fs-3">
                    <input type="checkbox" class="form-check-input player-checkbox" id="player-{{ $player->id }}" value="{{ $player->name }}">
                    <label class="form-check-label" for="player-{{ $player->id }}">{{ $player->name }}</label>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-primary" id="start-race-btn">Avvia la Corsa</button>
    </form>

    <!-- Area della corsa -->
    <div id="race-area" style="display: none; margin-top: 20px;">
        <h2>La corsa è iniziata!</h2>
        <div id="race-progress-bars"></div>
    </div>

    <!-- Risultato della corsa -->
    <div id="race-result" class="text-center" style="display: none; margin-top: 20px;">
        <h2>Abbiamo un vincitore!</h2>
        <p id="winner-name" style="font-size: 1.5em; font-weight: bold;"></p>
        <button type="button" class="btn btn-secondary" id="reset-race-btn">Inizia una Nuova Corsa</button>
    </div>

    <!-- Elementi audio -->
    <audio id="race-sound" src="{{ asset('audio/race-theme.ogg') }}" preload="auto" loop></audio>
    <audio id="victory-sound" preload="auto">
        <source src="{{ asset('audio/win.mp3') }}" type="audio/mpeg">
        <source src="{{ asset('audio/win.ogg') }}" type="audio/ogg">
    </audio>

</div>
@endsection

@section('scripts')
<script>
    let raceSound = document.getElementById('race-sound');
    let victorySound = document.getElementById('victory-sound');

    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.player-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    document.getElementById('start-race-btn').addEventListener('click', function() {
        let selectedPlayers = [];
        document.querySelectorAll('.player-checkbox:checked').forEach(function(checkbox) {
            selectedPlayers.push(checkbox.value);
        });

        if (selectedPlayers.length < 2) {
            alert('Per favore, seleziona almeno due giocatori per iniziare la corsa.');
            return;
        }

        raceSound.volume = 0.1;
        raceSound.play().catch(error => console.error('Errore nella riproduzione:', error));

        document.getElementById('race-form').style.display = 'none';
        document.getElementById('race-area').style.display = 'block';

        startRace(selectedPlayers);
    });

    function startRace(players) {
        const raceArea = document.getElementById('race-progress-bars');
        raceArea.innerHTML = '';
        let raceInProgress = true;
        let winner = null;

        function getRandomColor() {
            let letters = '0123456789ABCDEF';
            return '#' + Array.from({ length: 6 }, () => letters[Math.floor(Math.random() * 16)]).join('');
        }

        let progressBars = [];
        players.forEach(playerName => {
            let progressBarContainer = document.createElement('div');
            progressBarContainer.style.marginBottom = '20px';
            progressBarContainer.style.textAlign = 'center';

            // Aggiungi l'immagine avatar accanto al nome
            let avatarImage = document.createElement('img');
            avatarImage.src = "{{ asset('img/avatar-horse.png') }}";
            avatarImage.style.width = '160px';
            avatarImage.style.height = '80px';
            avatarImage.style.marginRight = '10px';

            let progressLabel = document.createElement('div');
            progressLabel.innerHTML = avatarImage.outerHTML + playerName;
            progressLabel.style.fontWeight = 'bold';
            progressLabel.style.display = 'flex';
            progressLabel.style.alignItems = 'center';
            progressLabel.style.justifyContent = 'center';

            let progressBar = document.createElement('div');
            progressBar.classList.add('progress');
            progressBar.style.height = '25px';
            progressBar.style.width = '100%';
            progressBar.style.marginTop = '10px';

            let progress = document.createElement('div');
            progress.classList.add('progress-bar');
            progress.setAttribute('role', 'progressbar');
            progress.setAttribute('aria-valuemin', '0');
            progress.setAttribute('aria-valuemax', '100');
            progress.style.width = '0%';
            progress.style.backgroundColor = getRandomColor();
            progressBar.appendChild(progress);

            progressBarContainer.appendChild(progressLabel);
            progressBarContainer.appendChild(progressBar);
            raceArea.appendChild(progressBarContainer);

            progressBars.push({
                name: playerName,
                element: progress,
                progress: 0
            });
        });

        let raceInterval = setInterval(() => {
            progressBars.forEach(bar => {
                if (raceInProgress) {
                    let increment = Math.floor(Math.random() * 3) + 1;
                    bar.progress += increment;
                    if (bar.progress >= 100) {
                        bar.progress = 100;
                        if (!winner) {
                            winner = bar.name;
                            raceInProgress = false;
                            raceSound.pause();
                            raceSound.currentTime = 0;
                            victorySound.volume = 0.2;
                            victorySound.play().catch(error => console.error('Errore nella riproduzione:', error));
                            announceWinner(winner);
                        }
                    }
                    bar.element.style.width = bar.progress + '%';
                    bar.element.setAttribute('aria-valuenow', bar.progress);
                }
            });

            if (!raceInProgress) {
                clearInterval(raceInterval);
            }
        }, 400);
    }

    function announceWinner(winnerName) {
        document.getElementById('race-result').style.display = 'block';
        document.getElementById('winner-name').innerText = winnerName + ' ha vinto la corsa!';
        raceSound.pause();
        raceSound.currentTime = 0;
    }

    document.getElementById('reset-race-btn').addEventListener('click', function() {
        document.getElementById('race-form').style.display = 'block';
        document.getElementById('race-area').style.display = 'none';
        document.getElementById('race-result').style.display = 'none';
        document.getElementById('race-progress-bars').innerHTML = '';
        document.getElementById('select-all').checked = false;
        document.querySelectorAll('.player-checkbox').forEach(function(checkbox) {
            checkbox.checked = false;
        });

        victorySound.pause();
        victorySound.currentTime = 0;
    });
</script>
@endsection
