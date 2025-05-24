<x-auth-layout>
    <div class="auth-card fade-in">
        <div class="auth-header">
            <div class="flex justify-center mb-4">
                <div class="relative h-16 w-16 bg-white/20 rounded-full overflow-hidden flex items-center justify-center">
                    <div class="absolute h-10 w-10 bg-white rounded-full top-2 left-2 opacity-20"></div>
                    <span class="relative text-white font-bold text-3xl">DHR</span>
                </div>
            </div>
            <h1>Registration Complete!</h1>
            <p>Your application has been received</p>
        </div>
        
        <div class="auth-body text-center">
            <div class="mb-8 flex justify-center">
                <div class="h-24 w-24 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-500 text-5xl"></i>
                </div>
            </div>
            
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Thank You, {{ $name ?? 'Provider' }}!</h2>
            <p class="text-lg text-gray-600 mb-6">
                Your facility "{{ $facility_name ?? 'Your Facility' }}" has been registered successfully.
            </p>
            
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 text-left">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Our team will review your application. This typically takes 1-2 business days.
                            We will notify you by email once your account is approved.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="space-y-4">
                <p class="text-gray-600">
                    <i class="fas fa-envelope mr-2 text-primary-500"></i>
                    A confirmation email has been sent with further instructions.
                </p>
                <p class="text-gray-600">
                    <i class="fas fa-clock mr-2 text-primary-500"></i>
                    Account status: <span class="font-medium text-yellow-600">Pending Approval</span>
                </p>
            </div>
            
            <div class="mt-8 space-y-4">
                {{-- <a href="{{ route('login') }}" class="btn btn-primary btn-block">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Sign In
                </a> --}}
                <a href="{{ url('/') }}" class="btn btn-primary btn-block">
                    <i class="fas fa-home mr-2"></i>
                    Back to Home
                </a>
                {{-- <a href="{{ url('/') }}" class="btn bg-gray-200 hover:bg-gray-300 text-gray-700 btn-block">
                    <i class="fas fa-home mr-2"></i>
                    Back to Home
                </a> --}}
            </div>
        </div>
        
        <div class="auth-footer">
            <p class="text-sm text-gray-600 mb-2">Need assistance?</p>
            <a href="mailto:support@DHR SPACE.com" class="auth-link">
                Contact our support team
            </a>
        </div>
    </div>
</x-auth-layout>
