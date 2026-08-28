@extends('layouts.app')

@section('content')
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="width: 100%; max-width: 480px;">
        <div class="card-header text-white text-center py-4 px-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0d6efd 100%);">
            <div class="bg-primary bg-opacity-25 rounded-circle mx-auto p-3 mb-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bi bi-question-circle-fill fs-2 text-white"></i>
            </div>
            <h4 class="fw-bold mb-1 text-white">Reset Password</h4>
            <p class="text-light opacity-75 small mb-0">We will email you a password reset link</p>
        </div>

        <div class="card-body p-4 p-lg-5 bg-white">
            @if(session('status'))
                <div class="alert alert-success border-0 rounded-3 mb-4 small">
                    {{ session('status') }}
                </div>
            @endif

            <p class="text-muted small mb-4">
                Forgot your password? No problem. Enter your account email address below and we will send you a reset link.
            </p>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold small text-muted">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                        <input id="email" type="email" name="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm mb-3">
                    <i class="bi bi-send me-2"></i> Send Password Reset Link
                </button>

                <div class="text-center pt-2 border-top">
                    <a href="{{ route('login') }}" class="small fw-bold text-secondary text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i> Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
