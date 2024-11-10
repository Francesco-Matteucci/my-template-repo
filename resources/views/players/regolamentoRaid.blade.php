@extends('layouts.app')

@section('content')
<div class="background-wrapper">
    <div class="fog-overlay"></div>
    <div class="content-center">
        <div class="container">
            <h1 class="display-4 text-center text-light mb-4">Regolamento per la Distribuzione dei Drop Rari</h1>
            <div class="text-light fs-5">
                <p><strong>Obiettivo:</strong> Vogliamo essere sicuri che i premi più rari (drop viola) siano distribuiti in modo giusto durante le attività di gruppo (raid).</p>

                <h2 class="text-warning mt-4">Come Funziona la Distribuzione:</h2>
                <p><strong>Chi ottiene i premi?</strong> Il gioco assegna i premi rari in modo randomico. Tuttavia, il nostro sistema di priorità determina chi avrà effettivamente il diritto di mantenere il drop.</p>

                <h3 class="text-info mt-3">Sistema di Drop Assegnato:</h3>
                <p>
                    La priorità assoluta è data a chi ottiene il drop direttamente dal sistema. Tuttavia, se un membro sceglie di mantenere il drop, verranno scalati i punti in base al valore dell'oggetto. Nello specifico:
                </p>
                <ul>
                    <li>Gli oggetti di valore tra 900 e 1999 punti e/o che fanno parte della vostra build valgono 1 punto priorità.</li>
                    <li>Gli oggetti di valore 2000 o superiore valgono 2 punti priorità, anche se fanno parte della build.</li>
                    <li>Gli oggetti di basso valore, che non rientrano nelle categorie sopra menzionate, non aggiungono né tolgono punti priorità se trattenuti o donati.</li>
                </ul>

                <h3 class="text-info mt-3">Accumulare Punti Priorità:</h3>
                <p>
                    Ogni membro accumula punti priorità in base alla partecipazione ai raid:
                </p>
                <ul>
                    <li>Ogni 28 raid partecipati (1 mese), tutti i membri accumulano 1 punto priorità.</li>
                    <li>Questi punti si sommano nel tempo e aiutano a determinare la priorità nelle distribuzioni future.</li>
                </ul>
                <p>A parità di punti priorità l'assegnazione sarà ottenuta con un sistema randomico come il tiro del dado.</p>

                <h3 class="text-info mt-3">Tenere Traccia:</h3>
                <p>Ogni settimana aggiorniamo una lista che mostra:</p>
                <ul>
                    <li>Chi ha partecipato ai raid.</li>
                    <li>Chi ha ricevuto un premio raro.</li>
                    <li>Se i premi sono stati redistribuiti.</li>
                </ul>
                <p>Questa lista è visibile a tutti, così tutti sanno cosa succede.</p>

                <h3 class="text-info mt-3">Reclami:</h3>
                <p>
                    Se qualcuno pensa di essere stato ingiustamente escluso dai premi, può parlarne con i capi della gilda. Esamineremo la situazione per assicurarci che tutto sia corretto.
                </p>

                <h3 class="text-info mt-3">Comportamenti Scorretti:</h3>
                <p>
                    Chi cerca di ottenere premi in modo non corretto o fa il furbo potrebbe essere escluso dalla possibilità di ricevere premi in futuro.
                </p>

                <h3 class="text-info mt-3">Conclusione:</h3>
                <p>
                    Vogliamo essere giusti con tutti. Partecipando regolarmente ai raid e rispettando le regole, tutti avranno la possibilità di ricevere premi preziosi.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
