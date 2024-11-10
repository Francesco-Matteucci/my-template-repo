@extends('layouts.app')

@section('content')
<div class="background-wrapper">
    <div class="fog-overlay"></div>
    <div class="content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card bg-dark text-light border-0 shadow-lg rounded-3">
                        <div class="card-header text-center border-0 bg-transparent">
                            <h3>{{ __('Entra nella Forgia') }}</h3>
                            <p class="mb-0">Accedi con la tua mail</p>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                  <!-- Campo nome -->
                                  <div class="mb-4">
                                    <label for="name" class="form-label">{{ __('Nome') }}</label>
                                    <input id="name" type="text" class="form-control bg-dark text-light @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Campo password -->
                                <div class="mb-4">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control bg-dark text-light @error('password') is-invalid @enderror" name="password" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Bottone per il login -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-block">{{ __('Entra') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
