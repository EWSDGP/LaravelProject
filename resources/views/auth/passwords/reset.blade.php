@extends('layouts.app')

@section('content')
<div class="container-fluid" style="background: linear-gradient(to right, #63a4ff, #a2c2e9); min-height: 100vh;">
    <div class="row justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h4 class="mb-0"><i class="fa-solid fa-lock"></i> {{ __('Reset Password') }}</h4>
                </div>

                <div class="card-body p-4 bg-white rounded-bottom-4">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">
                                <i class="fa-solid fa-envelope"></i> {{ __('Email Address') }}
                            </label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus 
                                   placeholder="Enter your email">
                            
                            @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">
                                <i class="fa-solid fa-key"></i> {{ __('Password') }}
                            </label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="new-password" placeholder="New password"
                                   pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$" 
                                   title="Password must be at least 8 characters long, include at least one letter, one number, and one special character.">

                            <div id="passwordHelp" class="form-text">
                                <i class="fa-solid fa-info-circle"></i> Password must be at least 8 characters long, contain at least one letter, one number, and one special character.
                            </div>

                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label fw-bold">
                                <i class="fa-solid fa-check-circle"></i> {{ __('Confirm Password') }}
                            </label>
                            <input id="password-confirm" type="password" class="form-control" 
                                   name="password_confirmation" required autocomplete="new-password" placeholder="Confirm new password">
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa-solid fa-paper-plane"></i> {{ __('Reset Password') }}
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center text-muted">
                    <small><i class="fa-solid fa-circle-info"></i> Make sure to use a strong password</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
   
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    
    .card-header, .card-footer {
        border-radius: 10px 10px 0 0;
    }

    .card-footer {
        font-size: 0.875rem;
        color: #6c757d;
    }

    
    .container-fluid {
        background: linear-gradient(to right, #63a4ff, #a2c2e9);
        min-height: 100vh;
    }
</style>
@endsection
