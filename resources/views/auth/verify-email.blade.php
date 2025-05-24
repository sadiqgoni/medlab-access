<x-auth-layout>
    <div class="auth-card fade-in">
        <div class="auth-header">
            <div class="flex justify-center mb-4">
                <div class="relative h-16 w-16 bg-white/20 rounded-full overflow-hidden flex items-center justify-center">
                    <div class="absolute h-10 w-10 bg-white rounded-full top-2 left-2 opacity-20"></div>
                    <span class="relative text-white font-bold text-3xl">DHR</span>
                </div>
            </div>
            <h1>Verify Email</h1>
            <p>Please verify your email address to continue</p>
        </div>
        
        <div class="auth-body">
            <div class="mb-6 text-sm text-gray-600">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 mb-6 flex items-center">
                    <i class="fas fa-check-circle mr-2 text-green-500"></i>
                    <span>{{ __('A new verification link has been sent to the email address you provided during registration.') }}</span>
                </div>
            @endif

            <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4 sm:items-center sm:justify-between mt-6">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary w-full">
                        <i class="fas fa-paper-plane btn-icon"></i>
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="auth-link w-full text-center block mt-4 sm:mt-0">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-auth-layout>
