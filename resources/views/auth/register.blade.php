<x-guest-layout>
    <div class="text-center mb-4">
        <h4 style="font-weight: 700; letter-spacing: 0.5px;">Create Account</h4>
        <p class="text-muted small">Join us to access the dashboard</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0" style="border-color: rgba(255, 255, 255, 0.08); color: var(--text-muted);"><i class="fas fa-user"></i></span>
                <input id="name" type="text" class="form-control border-start-0 ps-0" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe">
            </div>
            @if ($errors->has('name'))
                <div class="text-danger mt-1">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0" style="border-color: rgba(255, 255, 255, 0.08); color: var(--text-muted);"><i class="fas fa-envelope"></i></span>
                <input id="email" type="email" class="form-control border-start-0 ps-0" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="name@example.com">
            </div>
            @if ($errors->has('email'))
                <div class="text-danger mt-1">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0" style="border-color: rgba(255, 255, 255, 0.08); color: var(--text-muted);"><i class="fas fa-lock"></i></span>
                <input id="password" type="password" class="form-control border-start-0 ps-0" name="password" required autocomplete="new-password" placeholder="••••••••">
            </div>
            @if ($errors->has('password'))
                <div class="text-danger mt-1">{{ $errors->first('password') }}</div>
            @endif
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0" style="border-color: rgba(255, 255, 255, 0.08); color: var(--text-muted);"><i class="fas fa-lock"></i></span>
                <input id="password_confirmation" type="password" class="form-control border-start-0 ps-0" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
            </div>
            @if ($errors->has('password_confirmation'))
                <div class="text-danger mt-1">{{ $errors->first('password_confirmation') }}</div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">
            CREATE ACCOUNT <i class="fas fa-user-plus ms-2"></i>
        </button>

        <div class="text-center mt-4">
            <span class="text-muted small">Already registered?</span>
            <a href="{{ route('login') }}" class="small fw-bold ms-1">Sign In Here</a>
        </div>
    </form>
</x-guest-layout>
