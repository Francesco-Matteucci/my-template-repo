@extends('layouts.app')

@section('content')
<div class="fog-overlay position-absolute w-100 h-100"></div>
<div class="background-wrapper position-relative">

    <!-- Overlay di nebbia per aggiungere l'effetto sovrapposto al video -->

    <!-- Contenuto centrale -->
    <div class="content-center position-relative text-center">
        <div class="fc-home container">
            <h1 class="display-4 text-light title-glow animate__animated animate__fadeInDown">Forgia Celeste</h1>
<p class="lead text-light animate__animated animate__fadeInUp">Benvenuto nella piattaforma di gestione per gli eventi della gilda!</p>
<div class="fc-logo text-center mt-5">
    <img src="{{ asset('img/logo-fc.png') }}" alt="Logo FC" class="img-fluid animate__animated animate__zoomIn">
</div>
        </div>
    </div>
</div>
@endsection
