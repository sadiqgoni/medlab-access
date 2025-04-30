<x-auth-layout>
    <div class="auth-card fade-in">
        <div class="auth-header">
            <div class="flex justify-center mb-4">
                <div class="relative h-16 w-16 bg-white/20 rounded-full overflow-hidden flex items-center justify-center">
                    <div class="absolute h-10 w-10 bg-white rounded-full top-2 left-2 opacity-20"></div>
                    <span class="relative text-white font-bold text-3xl">M</span>
                </div>
            </div>
            <h1>Create Your Account</h1>
            <p>Join MedLab-Access for seamless healthcare services</p>
        </div>
        
        <div class="auth-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe" />
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
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="your@email.com" />
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
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required autocomplete="tel" placeholder="+1234567890" />
                    </div>
                    @error('phone')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Address -->
                <div class="form-group">
                    <label for="address">Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-map-marker-alt input-icon"></i>
                        <textarea id="address" name="address" rows="2" placeholder="Your full address" class="resize-none pt-3">{{ old('address') }}</textarea>
                    </div>
                    @error('address')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Government ID -->
                <div class="form-group">
                    <label for="government_id">Government ID (e.g., NIN, Voter's Card)</label>
                    <div class="input-wrapper">
                        <i class="fas fa-id-card input-icon"></i>
                        <input id="government_id" type="text" name="government_id" value="{{ old('government_id') }}" placeholder="ID number" />
                    </div>
                    @error('government_id')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Blood Group & Donor Eligibility -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="blood_group">Blood Group (Optional)</label>
                        <div class="input-wrapper">
                            <i class="fas fa-tint input-icon"></i>
                            <select id="blood_group" name="blood_group">
                                <option value="">Select Blood Group</option>
                                <option value="A+" @selected(old('blood_group') == 'A+')>A+</option>
                                <option value="A-" @selected(old('blood_group') == 'A-')>A-</option>
                                <option value="B+" @selected(old('blood_group') == 'B+')>B+</option>
                                <option value="B-" @selected(old('blood_group') == 'B-')>B-</option>
                                <option value="AB+" @selected(old('blood_group') == 'AB+')>AB+</option>
                                <option value="AB-" @selected(old('blood_group') == 'AB-')>AB-</option>
                                <option value="O+" @selected(old('blood_group') == 'O+')>O+</option>
                                <option value="O-" @selected(old('blood_group') == 'O-')>O-</option>
                            </select>
                        </div>
                        @error('blood_group')
                            <div class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="form-group flex items-center">
                        <div class="checkbox-wrapper mt-6">
                            <input id="eligible_donor" type="checkbox" name="eligible_donor" value="1" @checked(old('eligible_donor'))>
                            <label for="eligible_donor">
                                <i class="fas fa-heartbeat text-red-500 mr-1"></i>
                                Eligible to Donate Blood?
                            </label>
                        </div>
                        @error('eligible_donor')
                            <div class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Communication Preference -->
                <div class="form-group">
                    <label for="communication_preference">Preferred Communication</label>
                    <div class="input-wrapper">
                        <i class="fas fa-bell input-icon"></i>
                        <select id="communication_preference" name="communication_preference">
                            <option value="email" @selected(old('communication_preference', 'email') == 'email')>Email</option>
                            <option value="sms" @selected(old('communication_preference') == 'sms')>SMS</option>
                            <option value="app" @selected(old('communication_preference') == 'app')>App Notification</option>
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
                    <label for="password_confirmation">Confirm Password</label>
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
