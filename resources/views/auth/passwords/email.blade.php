@extends('layouts.app')

@section('content')
<div class="w-100 vh-100 d-flex align-items-center justify-content-center" 
     style="background: linear-gradient(to right, #a2c2e9, #63a4ff);">
    <div class="col-md-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white text-center rounded-top-4">
                <h4 class="mb-0"><i class="fa-solid fa-lock"></i> {{ __('Reset Password') }}</h4>
            </div>

            <div class="card-body p-4 bg-white rounded-bottom-4">
                @if (session('status'))
                    <div class="alert alert-success text-center" role="alert">
                        <i class="fa-solid fa-circle-check"></i> {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">
                            <i class="fa-solid fa-envelope"></i> {{ __('Email Address') }}
                        </label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus 
                               placeholder="Enter your email">
                        
                        @error('email')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fa-solid fa-paper-plane"></i> {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-footer text-center text-muted">
                <small><i class="fa-solid fa-circle-info"></i> Check your email for reset instructions</small>
            </div>
        </div>
    </div>
</div>
@endsection
