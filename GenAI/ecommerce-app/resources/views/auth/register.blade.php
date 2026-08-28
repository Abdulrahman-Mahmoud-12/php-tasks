@extends('layouts.app')

@section('content')
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="width: 100%; max-width: 520px;">
        <div class="card-header text-white text-center py-4 px-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0d6efd 100%);">
            <div class="bg-primary bg-opacity-25 rounded-circle mx-auto p-3 mb-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bi bi-person-plus-fill fs-2 text-white"></i>
            </div>
            <h4 class="fw-bold mb-1 text-white">Create Your Account</h4>
            <p class="text-light opacity-75 small mb-0">Join NovaMart E-Commerce Platform</p>
        </div>

        <div class="card-body p-4 p-lg-5 bg-white">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold small text-muted">Full Name <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                        <input id="name" type="text" name="name" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus placeholder="John Doe">
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold small text-muted">Email Address <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                        <input id="email" type="email" name="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="name@example.com">
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold small text-muted">Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key"></i></span>
                        <input id="password" type="password" name="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" required placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold small text-muted">Confirm Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-shield-check"></i></span>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control border-start-0 ps-0 @error('password_confirmation') is-invalid @enderror" required placeholder="••••••••">
                        @error('password_confirmation')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm mb-3">
                    <i class="bi bi-check-circle-fill me-2"></i> Register Account
                </button>

                <div class="text-center pt-2 border-top">
                    <span class="small text-muted">Already registered?</span>
                    <a href="{{ route('login') }}" class="small fw-bold text-primary text-decoration-none ms-1">Log In Instead</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
