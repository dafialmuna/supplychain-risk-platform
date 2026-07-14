<x-guest-layout>
    <div class="text-center mb-4">
        <h4 style="font-weight: 700; letter-spacing: 0.5px;">Welcome Back</h4>
        <p class="text-muted small">Sign in to your account to continue</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="alert alert-success mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0" style="border-color: rgba(255, 255, 255, 0.08); color: var(--text-muted);"><i class="fas fa-envelope"></i></span>
                <input id="email" type="email" class="form-control border-start-0 ps-0" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@example.com">
            </div>
            @if ($errors->has('email'))
                <div class="text-danger mt-1">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0" style="border-color: rgba(255, 255, 255, 0.08); color: var(--text-muted);"><i class="fas fa-lock"></i></span>
                <input id="password" type="password" class="form-control border-start-0 ps-0" name="password" required autocomplete="current-password" placeholder="••••••••">
            </div>
            @if ($errors->has('password'))
                <div class="text-danger mt-1">{{ $errors->first('password') }}</div>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label class="form-check-label text-muted small" for="remember_me">
                    Remember me
                </label>
            </div>
            @if (Route::has('password.request'))
                <a class="small" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">
            SIGN IN <i class="fas fa-arrow-right ms-2"></i>
        </button>

        @if (Route::has('register'))
            <div class="text-center mt-4">
                <span class="text-muted small">Don't have an account?</span>
                <a href="{{ route('register') }}" class="small fw-bold ms-1">Create Account</a>
            </div>
        @endif
    </form>
</x-guest-layout>
