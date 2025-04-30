<x-auth-layout>
    <div class="auth-card fade-in">
        <div class="auth-header">
            <div class="flex justify-center mb-4">
                <div class="relative h-16 w-16 bg-white/20 rounded-full overflow-hidden flex items-center justify-center">
                    <div class="absolute h-10 w-10 bg-white rounded-full top-2 left-2 opacity-20"></div>
                    <span class="relative text-white font-bold text-3xl">M</span>
                </div>
            </div>
            <h1>Forgot Password</h1>
            <p>Enter your email to reset your password</p>
        </div>
        
        <div class="auth-body">
            <!-- Session Status -->
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 mb-6 flex items-center">
                    <i class="fas fa-check-circle mr-2 text-green-500"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <div class="mb-6 text-sm text-gray-600">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="your@email.com" />
                    </div>
                    @error('email')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-paper-plane btn-icon"></i>
                    Email Password Reset Link
                </button>
            </form>
        </div>
        
        <div class="auth-footer">
            <a href="{{ route('login') }}" class="auth-link">
                <i class="fas fa-arrow-left mr-1"></i> Back to login
            </a>
        </div>
    </div>
</x-auth-layout>
