@extends('layouts.app')

@section('content')
<div class="background-wrapper">
    <div class="fog-overlay"></div>
    <div class="content-center">
<div class="fc-home container text-center">
    <h1 class="display-4 text-light">Forgia Celeste</h1>
    <p class="lead text-light">Benvenuto nella piattaforma di gestione per gli eventi della gilda!</p>
    <div class="fc-logo text-center mt-5">
        <img src="{{ asset('img/logo-fc.png') }}" alt="Logo FC" class="img-fluid">
    </div>
</div>
</div>
</div>
@endsection
