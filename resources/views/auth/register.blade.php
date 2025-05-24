<x-auth-layout>
    <div class="auth-card fade-in">
        <div class="auth-header">
            <div class="flex justify-center mb-4">
                <div
                    class="relative h-16 w-16 bg-white/20 rounded-full overflow-hidden flex items-center justify-center">
                    <div class="absolute h-10 w-10 bg-white rounded-full top-2 left-2 opacity-20"></div>
                    <span class="relative text-white font-bold text-3xl">M</span>
                </div>
            </div>
            <h1>Create Your Account</h1>
            <p>Join DHR SPACE for seamless healthcare services</p>
        </div>

        <div class="auth-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                            autocomplete="name" placeholder="John Doe" />
                    </div>
                    @error('name')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            autocomplete="username" placeholder="your@email.com" />
                    </div>
                    @error('email')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <div class="input-wrapper">
                        <i class="fas fa-phone input-icon"></i>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required autocomplete="tel"
                            placeholder="+1234567890" />
                    </div>
                    @error('phone')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Address with Google Places Autocomplete -->
                <div class="form-group">
                    <label for="address">Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-map-marker-alt input-icon"></i>
                        <input id="address" type="text" name="address" value="{{ old('address') }}" required
                            placeholder="Enter street address" />
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Start typing your street address and select a suggestion for
                        accurate location.</p>
                    @error('address')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Hidden Fields for Coordinates -->
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

                <!-- Communication Preference -->
                <div class="form-group">
                    <label for="communication_preference">Preferred Communication</label>
                    <div class="input-wrapper">
                        <i class="fas fa-bell input-icon"></i>
                        <select id="communication_preference" name="communication_preference">
                            <option value="email" @selected(old('communication_preference', 'email') == 'email')>Email
                            </option>
                            <option value="sms" @selected(old('communication_preference') == 'sms')>SMS</option>
                            <option value="app" @selected(old('communication_preference') == 'app')>App Notification
                            </option>
                        </select>
                    </div>
                    @error('communication_preference')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            placeholder="••••••••" />
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
                    <label for="password_confirmation">Confirm Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            autocomplete="new-password" placeholder="••••••••" />
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
                    <i class="fas fa-user-plus btn-icon"></i>
                    Create Account
                </button>
            </form>
        </div>

        <div class="auth-footer">
            <p class="text-sm text-gray-600 mb-2">Already have an account?</p>
            <a href="{{ route('login') }}" class="auth-link">
                Sign in to your account
            </a>
        </div>
    </div>
</x-auth-layout>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addressInput = document.querySelector('#address');
        let autocomplete;

        // Initialize Google Places Autocomplete with error handling
        try {
            autocomplete = new google.maps.places.Autocomplete(addressInput, {
                componentRestrictions: { country: 'NG' },
                types: ['geocode', 'establishment'],
                fields: ['formatted_address', 'geometry', 'name', 'types']
            });

            // Update input and hidden fields when a place is selected
            autocomplete.addListener('place_changed', function () {
                const place = autocomplete.getPlace();
                if (place.geometry) {
                    addressInput.value = place.formatted_address || place.name;
                    document.querySelector('#latitude').value = place.geometry.location.lat();
                    document.querySelector('#longitude').value = place.geometry.location.lng();
                    console.log('Selected address:', place.formatted_address || place.name, 'Coordinates:', {
                        lat: place.geometry.location.lat(),
                        lng: place.geometry.location.lng(),
                        types: place.types
                    });
                    // Clear error state
                    addressInput.classList.remove('border-red-500');
                    const errorDiv = addressInput.closest('.form-group').querySelector('.form-error');
                    if (errorDiv) errorDiv.classList.remove('show');
                } else {
                    console.warn('No geometry available for address:', place.formatted_address || place.name);
                    addressInput.classList.add('border-red-500');
                }
            });
        } catch (error) {
            console.error('Failed to initialize Google Places Autocomplete:', error);
            // Allow typing even if API fails
            addressInput.removeAttribute('disabled');
            addressInput.placeholder = 'Enter address manually';
        }

        // Allow typing without restrictions
        addressInput.addEventListener('input', function () {
            addressInput.classList.remove('border-red-500');
            const errorDiv = addressInput.closest('.form-group').querySelector('.form-error');
            if (errorDiv) errorDiv.classList.remove('show');
        });

        // Validate address on form submission
        const form = document.querySelector('form');
        form.addEventListener('submit', (event) => {
            const address = addressInput.value.trim();
            if (!address) {
                event.preventDefault();
                alert('Please enter and select a valid address from the suggestions.');
                addressInput.classList.add('border-red-500');
                addressInput.focus();
                return;
            }
            // Check for overly broad addresses
            // const broadTerms = ['nigeria', 'kano', 'municipal', 'state', 'city'];
            // if (broadTerms.some(term => address.toLowerCase().includes(term)) &&
            //     !address.toLowerCase().includes('road') &&
            //     !address.toLowerCase().includes('street') &&
            //     !address.toLowerCase().includes('avenue') &&
            //     !address.toLowerCase().includes('layout') &&
            //     !address.toLowerCase().includes('estate')) {
            //     event.preventDefault();
            //     alert(`Please select a specific address, such as a street, avenue, or landmark.`);
            //     addressInput.classList.add('border-red-500');
            //     addressInput.focus();
            // }
        });
    });
</script>