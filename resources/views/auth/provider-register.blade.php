<x-auth-layout>
    <div class="auth-card fade-in">
        <div class="auth-header">
            <div class="flex justify-center mb-4">
                <div class="relative h-16 w-16 bg-white/20 rounded-full overflow-hidden flex items-center justify-center">
                    <div class="absolute h-10 w-10 bg-white rounded-full top-2 left-2 opacity-20"></div>
                    <span class="relative text-white font-bold text-3xl">M</span>
                </div>
            </div>
            <h1>Join as a Service Provider</h1>
            <p>Register your medical facility on D'HEALTH RIDES</p>
        </div>
        
        <div class="auth-body">
            <form method="POST" action="{{ route('provider.register') }}" x-data="{ currentStep: 1, totalSteps: 3 }">
                @csrf

                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium" x-text="`Step ${currentStep} of ${totalSteps}`"></span>
                        <span class="text-sm font-medium" x-text="`${Math.round((currentStep/totalSteps)*100)}%`"></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-primary-500 h-2.5 rounded-full transition-all duration-300 ease-in-out" :style="`width: ${(currentStep/totalSteps)*100}%`"></div>
                    </div>
                </div>

                <!-- Step 1: Personal Information -->
                <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Personal Information</h2>
                    
                    <!-- Name -->
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Your full name" />
                        </div>
                        @error('name')
                            <div class="form-error show">
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
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="your@email.com" />
                        </div>
                        @error('email')
                            <div class="form-error show">
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
                            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required placeholder="+234..." />
                        </div>
                        @error('phone')
                            <div class="form-error show">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Government ID -->
                    <div class="form-group">
                        <label for="government_id">Government ID (NIN, Voter's Card)</label>
                        <div class="input-wrapper">
                            <i class="fas fa-id-card input-icon"></i>
                            <input id="government_id" type="text" name="government_id" value="{{ old('government_id') }}" required placeholder="ID number" />
                        </div>
                        @error('government_id')
                            <div class="form-error show">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="button" @click="currentStep = 2" class="btn btn-primary">
                            Next: Facility Details <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 2: Facility Details -->
                <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Facility Details</h2>
                    
                    <!-- Facility Name -->
                    <div class="form-group">
                        <label for="facility_name">Facility Name</label>
                        <div class="input-wrapper">
                            <i class="fas fa-hospital input-icon"></i>
                            <input id="facility_name" type="text" name="facility_name" value="{{ old('facility_name') }}" required placeholder="e.g., CityLab Kano" />
                        </div>
                        @error('facility_name')
                            <div class="form-error show">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Facility Address -->
                    <div class="form-group">
                        <label for="facility_address">Facility Address</label>
                        <div class="input-wrapper">
                            <i class="fas fa-map-marked-alt input-icon"></i>
                            <input id="facility_address" type="text" name="facility_address" value="{{ old('facility_address') }}" required placeholder="Enter facility's street address" />
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Start typing the facility's address and select a suggestion.</p>
                        @error('facility_address')
                            <div class="form-error show">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Hidden Fields for Facility Coordinates -->
                    <input type="hidden" name="facility_latitude" id="facility_latitude" value="{{ old('facility_latitude') }}">
                    <input type="hidden" name="facility_longitude" id="facility_longitude" value="{{ old('facility_longitude') }}">

                    <!-- Facility Type -->
                    <div class="form-group">
                        <label for="facility_type">Facility Type</label>
                        <div class="input-wrapper">
                            <i class="fas fa-clinic-medical input-icon"></i>
                            <select id="facility_type" name="facility_type" required>
                                <option value="Lab" @selected(old('facility_type') == 'Lab')>Laboratory</option>
                                <option value="Hospital" @selected(old('facility_type') == 'Hospital')>Hospital</option>
                                <option value="Clinic" @selected(old('facility_type') == 'Clinic')>Clinic</option>
                                <option value="Blood Bank" @selected(old('facility_type') == 'Blood Bank')>Blood Bank</option>
                                <option value="Other" @selected(old('facility_type') == 'Other')>Other</option>
                            </select>
                        </div>
                        @error('facility_type')
                            <div class="form-error show">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Services Offered -->
                    <div class="form-group">
                        <label for="services_description">Services Offered</label>
                        <div class="input-wrapper">
                            <i class="fas fa-notes-medical input-icon"></i>
                            <textarea id="services_description" name="services_description" rows="3" required placeholder="Briefly describe the main services offered (e.g., Malaria testing, Blood typing, General diagnostics)" class="pl-10">{{ old('services_description') }}</textarea>
                        </div>
                        @error('services_description')
                            <div class="form-error show">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Facility License/Registration Number -->
                    <div class="form-group">
                        <label for="facility_license">Facility License/Registration Number</label>
                        <div class="input-wrapper">
                            <i class="fas fa-certificate input-icon"></i>
                            <input id="facility_license" type="text" name="facility_license" value="{{ old('facility_license') }}" required placeholder="Official registration number" />
                        </div>
                        @error('facility_license')
                            <div class="form-error show">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="flex justify-between mt-6">
                        <button type="button" @click="currentStep = 1" class="btn bg-gray-200 hover:bg-gray-300 text-gray-800">
                            <i class="fas fa-arrow-left mr-2"></i> Previous
                        </button>
                        <button type="button" @click="currentStep = 3" class="btn btn-primary">
                            Next: Account Settings <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Account Settings -->
                <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Account Settings</h2>
                    
                    <!-- Communication Preference -->
                    <div class="form-group">
                        <label for="communication_preference">Preferred Communication</label>
                        <div class="input-wrapper">
                            <i class="fas fa-bell input-icon"></i>
                            <select id="communication_preference" name="communication_preference" required>
                                <option value="email" @selected(old('communication_preference', 'email') == 'email')>Email</option>
                                <option value="sms" @selected(old('communication_preference') == 'sms')>SMS</option>
                                <option value="app" @selected(old('communication_preference') == 'app')>App Notification</option>
                            </select>
                        </div>
                        @error('communication_preference')
                            <div class="form-error show">
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
                            <input id="password" type="password" name="password" required placeholder="••••••••" />
                            <button type="button" class="password-toggle">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="form-error show">
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
                            <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••" />
                            <button type="button" class="password-toggle">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="form-error show">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

             

                    <div class="flex justify-between mt-6">
                        <button type="button" @click="currentStep = 2" class="btn bg-gray-200 hover:bg-gray-300 text-gray-800">
                            <i class="fas fa-arrow-left mr-2"></i> Previous
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-hospital-user mr-2"></i> Complete Registration
                        </button>
                    </div>
                </div>
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
        // Initialize Google Places Autocomplete for facility address
        initializeAddressAutocomplete('facility_address', 'facility_latitude', 'facility_longitude');
        
        function initializeAddressAutocomplete(inputId, latId, lngId) {
            const input = document.getElementById(inputId);
            if (!input) return;
            
            try {
                const autocomplete = new google.maps.places.Autocomplete(input, {
                    componentRestrictions: { country: 'NG' },
                    types: ['geocode', 'establishment'],
                    fields: ['formatted_address', 'geometry', 'name']
                });

                autocomplete.addListener('place_changed', function() {
                    const place = autocomplete.getPlace();
                    if (place.geometry) {
                        input.value = place.formatted_address || place.name;
                        document.getElementById(latId).value = place.geometry.location.lat();
                        document.getElementById(lngId).value = place.geometry.location.lng();
                        input.classList.remove('border-red-500');
                    } else {
                        input.classList.add('border-red-500');
                    }
                });
            } catch (error) {
                console.error(`Failed to initialize autocomplete for ${inputId}:`, error);
                input.placeholder = 'Enter address manually (autocomplete unavailable)';
            }
        }
        
        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            // Validate facility address
            validateAddress('facility_address', event);
            
            // Basic validation for required fields
            const requiredFields = ['name', 'email', 'phone', 'government_id', 'facility_name', 
                                   'facility_address', 'facility_license', 'password', 'password_confirmation'];
            
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field && !field.value.trim()) {
                    event.preventDefault();
                    field.classList.add('border-red-500');
                    
                    // Find the step containing this field and switch to it
                    const fieldContainer = field.closest('[x-show]');
                    if (fieldContainer) {
                        const stepMatch = fieldContainer.getAttribute('x-show').match(/currentStep === (\d+)/);
                        if (stepMatch && stepMatch[1]) {
                            const step = parseInt(stepMatch[1]);
                            window.Alpine.store('form').currentStep = step;
                        }
                    }
                }
            });
        });
        
        function validateAddress(inputId, event) {
            const input = document.getElementById(inputId);
            if (!input) return;
            
            const address = input.value.trim();
            if (!address) {
                event.preventDefault();
                alert(`Please enter a valid ${inputId.replace('_', ' ')}`);
                input.classList.add('border-red-500');
                input.focus();
                return;
            }
            
            // Check for overly broad addresses
            const broadTerms = ['nigeria', 'kano', 'municipal', 'state', 'city'];
            const specificTerms = ['road', 'street', 'avenue', 'layout', 'estate'];
            
            // if (broadTerms.some(term => address.toLowerCase().includes(term)) && 
            //     !specificTerms.some(term => address.toLowerCase().includes(term))) {
            //     event.preventDefault();
            //     alert(`Please select a specific ${inputId.replace('_', ' ')}, such as a street, avenue, or landmark.`);
            //     input.classList.add('border-red-500');
            //     input.focus();
            // }
        }
        
        // Password toggle functionality
        const passwordToggles = document.querySelectorAll('.password-toggle');
        passwordToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    });
</script>
