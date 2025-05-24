<x-auth-layout>
    <div class="auth-card fade-in">
        <div class="auth-header">
            <div class="flex justify-center mb-4">
                <div class="relative h-16 w-16 bg-white/20 rounded-full overflow-hidden flex items-center justify-center">
                    <div class="absolute h-10 w-10 bg-white rounded-full top-2 left-2 opacity-20"></div>
                    <span class="relative text-white font-bold text-3xl">DHR</span>
                </div>
            </div>
            <h1>Confirm Password</h1>
            <p>Please confirm your password to continue</p>
        </div>
        
        <div class="auth-body">
            <div class="mb-6 text-sm text-gray-600">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
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

                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-check-circle btn-icon"></i>
                    {{ __('Confirm') }}
                </button>
            </form>
        </div>
    </div>
</x-auth-layout>
