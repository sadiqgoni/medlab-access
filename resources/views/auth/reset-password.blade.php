<x-auth-layout>
    <div class="auth-card fade-in">
        <div class="auth-header">
            <div class="flex justify-center mb-4">
                <div class="relative h-16 w-16 bg-white/20 rounded-full overflow-hidden flex items-center justify-center">
                    <div class="absolute h-10 w-10 bg-white rounded-full top-2 left-2 opacity-20"></div>
                    <span class="relative text-white font-bold text-3xl">DHR</span>
                </div>
            </div>
            <h1>Reset Password</h1>
            <p>Create a new password for your account</p>
        </div>
        
        <div class="auth-body">
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" readonly />
                    </div>
                    @error('email')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">New Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                        <button type="button" class="password-toggle">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                        <button type="button" class="password-toggle">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-key btn-icon"></i>
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</x-auth-layout>
