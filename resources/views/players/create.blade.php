@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-light">Crea Nuovo Giocatore</h1>

    <form action="{{ route('players.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label text-light">Nome Giocatore</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="role_id" class="form-label text-light">Ruolo</label>
            <select name="role_id" id="role_id" class="form-control" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Aggiungi Giocatore</button>
    </form>
</div>
@endsection
