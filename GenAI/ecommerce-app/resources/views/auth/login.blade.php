@extends('layouts.app')

@section('content')
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="width: 100%; max-width: 480px;">
        <div class="card-header text-white text-center py-4 px-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0d6efd 100%);">
            <div class="bg-primary bg-opacity-25 rounded-circle mx-auto p-3 mb-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bi bi-person-lock fs-2 text-white"></i>
            </div>
            <h4 class="fw-bold mb-1 text-white">Welcome Back</h4>
            <p class="text-light opacity-75 small mb-0">Sign in to your NovaMart account</p>
        </div>

        <div class="card-body p-4 p-lg-5 bg-white">
            <!-- Session Status Alert -->
            @if(session('status'))
                <div class="alert alert-info border-0 rounded-3 mb-4 small">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold small text-muted">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                        <input id="email" type="email" name="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="form-label fw-semibold small text-muted mb-0">Password</label>
                        @if (Route::has('password.request'))
                            <a class="small text-primary text-decoration-none" href="{{ route('password.request') }}">Forgot password?</a>
                        @endif
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key"></i></span>
                        <input id="password" type="password" name="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" required placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-4">
                    <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                    <label for="remember_me" class="form-check-label small text-muted">Remember me on this device</label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm mb-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Log In
                </button>

                <div class="text-center pt-2 border-top">
                    <span class="small text-muted">Don't have an account yet?</span>
                    <a href="{{ route('register') }}" class="small fw-bold text-primary text-decoration-none ms-1">Create an Account</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
