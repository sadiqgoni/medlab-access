<x-consumer-dashboard-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center">
            <div class="flex-1">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">My Profile</h1>
                <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-600">Manage your personal information and preferences</p>
                <div class="flex flex-wrap items-center mt-2 sm:mt-3 space-x-2 sm:space-x-4">
                    <div class="flex items-center text-xs sm:text-sm text-green-600">
                        <i class="fas fa-shield-alt mr-1 sm:mr-2"></i>
                        <span>Secure & Private</span>
                    </div>
                    <div class="flex items-center text-xs sm:text-sm text-blue-600">
                        <i class="fas fa-sync-alt mr-1 sm:mr-2"></i>
                        <span>Auto-saved</span>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Custom Styles for Mobile Responsiveness -->
    <style>
        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        
        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        
        /* Responsive adjustments for mobile */
        @media (max-width: 640px) {
            .tab-content {
                padding: 1rem;
            }
            
            .form-section {
                margin-bottom: 1rem;
            }
        }
    </style>

    <!-- Main Content -->
    <div class="py-6" x-data="profileForm()">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <button @click="show = false" class="text-green-400 hover:text-green-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Profile Header Card -->
            <div class="bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl shadow-xl p-4 md:p-8 mb-6 md:mb-8 text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-primary-600/20 to-blue-600/20"></div>
                <div class="relative flex flex-col items-center text-center md:flex-row md:items-start md:text-left">
                    <!-- Profile Picture -->
                    <div class="relative mb-4 md:mb-0 md:mr-6">
                        <div class="h-20 w-20 md:h-32 md:w-32 rounded-full bg-white/20 flex items-center justify-center text-2xl md:text-6xl font-bold text-white shadow-2xl">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <button @click="$refs.profilePicture.click()" class="absolute bottom-0 right-0 h-6 w-6 md:h-10 md:w-10 bg-white rounded-full flex items-center justify-center text-primary-600 hover:bg-gray-100 transition-colors shadow-lg">
                            <i class="fas fa-camera text-xs md:text-base"></i>
                        </button>
                        <input type="file" x-ref="profilePicture" @change="handleProfilePictureChange" accept="image/*" class="hidden">
                    </div>
                    
                    <!-- Profile Info -->
                    <div class="flex-1 mb-4 md:mb-0">
                        <h2 class="text-xl md:text-3xl font-bold mb-1 md:mb-2">{{ Auth::user()->name }}</h2>
                        <p class="text-primary-100 text-sm md:text-lg mb-3 md:mb-4">{{ Auth::user()->email }}</p>
                        
                        <!-- Profile Stats - Mobile Optimized -->
                        <div class="grid grid-cols-3 gap-3 md:gap-6">
                            <div class="text-center">
                                <div class="text-base md:text-2xl font-bold">{{ Auth::user()->orders()->count() }}</div>
                                <div class="text-xs md:text-sm text-primary-100">Orders</div>
                            </div>
                            <div class="text-center">
                                <div class="text-base md:text-2xl font-bold">{{ Auth::user()->orders()->where('status', 'completed')->count() }}</div>
                                <div class="text-xs md:text-sm text-primary-100">Completed</div>
                            </div>
                            <div class="text-center">
                                <div class="text-base md:text-2xl font-bold">{{ Auth::user()->created_at->diffInMonths() + 1 }}</div>
                                <div class="text-xs md:text-sm text-primary-100">Months</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Health Score - Mobile Optimized -->
                    <div class="w-full md:w-auto">
                        <div class="bg-white/20 rounded-xl p-3 md:p-6 backdrop-blur-sm">
                            <div class="text-center">
                                <div class="text-xl md:text-3xl font-bold mb-1">85</div>
                                <div class="text-xs md:text-sm text-primary-100 mb-2">Health Score</div>
                                <div class="h-2 bg-white/20 rounded-full overflow-hidden">
                                    <div class="h-full bg-white rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Form Tabs -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Tab Navigation - More responsive with horizontal scroll on mobile -->
                <div class="border-b border-gray-200 overflow-x-auto scrollbar-hide">
                    <div class="min-w-max">
                        <nav class="flex px-2 md:px-6" aria-label="Tabs">
                            <button @click="activeTab = 'personal'" :class="activeTab === 'personal' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-3 md:py-4 px-3 md:px-4 border-b-2 font-medium text-xs md:text-sm transition-colors">
                                <i class="fas fa-user mr-1 md:mr-2"></i>
                                <span>Personal</span>
                            </button>
                            <button @click="activeTab = 'contact'" :class="activeTab === 'contact' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-3 md:py-4 px-3 md:px-4 border-b-2 font-medium text-xs md:text-sm transition-colors">
                                <i class="fas fa-address-book mr-1 md:mr-2"></i>
                                <span>Contact</span>
                            </button>
                            <button @click="activeTab = 'medical'" :class="activeTab === 'medical' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-3 md:py-4 px-3 md:px-4 border-b-2 font-medium text-xs md:text-sm transition-colors">
                                <i class="fas fa-heartbeat mr-1 md:mr-2"></i>
                                <span>Medical</span>
                            </button>
                            <button @click="activeTab = 'security'" :class="activeTab === 'security' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-3 md:py-4 px-3 md:px-4 border-b-2 font-medium text-xs md:text-sm transition-colors">
                                <i class="fas fa-lock mr-1 md:mr-2"></i>
                                <span>Security</span>
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="p-4 md:p-8">
                    <form method="POST" action="{{ route('consumer.profile.update') }}" @submit="handleFormSubmit" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Personal Information Tab -->
                        <div x-show="activeTab === 'personal'" x-transition>
                            <div class="mb-6 md:mb-8">
                                <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-1 md:mb-2">Personal Information</h3>
                                <p class="text-sm text-gray-600">Update your basic personal details</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                <!-- Full Name -->
                                <div class="md:col-span-2">
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-user mr-2 text-gray-400"></i>
                                        Full Name
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required 
                                           class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 py-3 px-4 text-lg"
                                           placeholder="Enter your full name">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="md:col-span-2">
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                        Email Address
                                    </label>
                                    <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required 
                                           class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 py-3 px-4 text-lg"
                                           placeholder="Enter your email address">
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Date of Birth -->
                                <div>
                                    <label for="date_of_birth" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                        Date of Birth
                                    </label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', Auth::user()->date_of_birth) }}" 
                                           class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 py-3 px-4">
                                    @error('date_of_birth')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-venus-mars mr-2 text-gray-400"></i>
                                        Gender
                                    </label>
                                    <select id="gender" name="gender" 
                                            class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 py-3 px-4">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', Auth::user()->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', Auth::user()->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', Auth::user()->gender) === 'other' ? 'selected' : '' }}>Other</option>
                                        <option value="prefer_not_to_say" {{ old('gender', Auth::user()->gender) === 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                    </select>
                                    @error('gender')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Blood Type -->
                                <div>
                                    <label for="blood_group" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-tint mr-2 text-gray-400"></i>
                                        Blood Type
                                    </label>
                                    <select id="blood_group" name="blood_group" 
                                            class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 py-3 px-4">
                                        <option value="">Select Blood Type</option>
                                        <option value="A+" {{ old('blood_group', Auth::user()->blood_group) === 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ old('blood_group', Auth::user()->blood_group) === 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('blood_group', Auth::user()->blood_group) === 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ old('blood_group', Auth::user()->blood_group) === 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="AB+" {{ old('blood_group', Auth::user()->blood_group) === 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ old('blood_group', Auth::user()->blood_group) === 'AB-' ? 'selected' : '' }}>AB-</option>
                                        <option value="O+" {{ old('blood_group', Auth::user()->blood_group) === 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ old('blood_group', Auth::user()->blood_group) === 'O-' ? 'selected' : '' }}>O-</option>
                                    </select>
                                    @error('blood_group')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Occupation -->
                                <div>
                                    <label for="occupation" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-briefcase mr-2 text-gray-400"></i>
                                        Occupation
                                    </label>
                                    <input type="text" id="occupation" name="occupation" value="{{ old('occupation', Auth::user()->occupation) }}" 
                                           class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 py-3 px-4"
                                           placeholder="Enter your occupation">
                                    @error('occupation')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Contact & Address Tab -->
                        <div x-show="activeTab === 'contact'" x-transition>
                            <div class="mb-6 md:mb-8">
                                <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-1 md:mb-2">Contact & Address Information</h3>
                                <p class="text-sm text-gray-600">Update your contact details and address for service delivery</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                <!-- Phone Number -->
                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-phone mr-2 text-gray-400"></i>
                                        Phone Number
                                    </label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" 
                                           class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 py-3 px-4"
                                           placeholder="+234 800 000 0000">
                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Emergency Contact -->
                                <div>
                                    <label for="emergency_contact" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-phone-alt mr-2 text-gray-400"></i>
                                        Emergency Contact
                                    </label>
                                    <input type="tel" id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact', Auth::user()->emergency_contact) }}" 
                                           class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 py-3 px-4"
                                           placeholder="+234 800 000 0000">
                                    @error('emergency_contact')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="md:col-span-2">
                                    <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                                        Home Address
                                    </label>
                                    <textarea id="address" name="address" rows="3" 
                                              class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 py-3 px-4"
                                              placeholder="Enter your complete home address">{{ old('address', Auth::user()->address) }}</textarea>
                                    @error('address')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Location Services -->
                            <div class="mt-6 md:mt-8 p-3 md:p-4 bg-blue-50 rounded-xl border border-blue-200">
                                <div class="flex flex-col space-y-3 sm:space-y-0 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <h4 class="text-sm md:text-base font-semibold text-blue-900">Location Services</h4>
                                        <p class="text-xs text-blue-700 mt-1 hidden sm:block">Find nearby facilities and improve delivery</p>
                                        <p class="text-xs text-blue-700 mt-1 sm:hidden">Update your location</p>
                                    </div>
                                    <button type="button" @click="getCurrentLocation" class="w-full sm:w-auto inline-flex items-center justify-center px-3 py-2 bg-blue-600 text-white text-xs md:text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-location-arrow mr-2"></i>
                                        <span>Get Location</span>
                                    </button>
                                </div>
                                <div x-show="locationStatus" class="mt-3 p-2 md:p-3 rounded-lg" :class="locationStatus.type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                                    <p class="text-xs" x-text="locationStatus.message"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Medical Information Tab -->
                        <div x-show="activeTab === 'medical'" x-transition>
                            <div class="mb-6 md:mb-8">
                                <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-1 md:mb-2">Medical Information</h3>
                                <p class="text-sm text-gray-600">Provide medical details to help us serve you better</p>
                            </div>

                            <div class="space-y-4 md:space-y-6">
                                <!-- Allergies -->
                                <div>
                                    <label for="allergies" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-exclamation-triangle mr-2 text-gray-400"></i>
                                        Known Allergies
                                    </label>
                                    <textarea id="allergies" name="allergies" rows="3" 
                                              class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 py-3 px-4"
                                              placeholder="List any known allergies (medications, foods, etc.)">{{ old('allergies', Auth::user()->allergies) }}</textarea>
                                    @error('allergies')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Current Medications -->
                                <div>
                                    <label for="current_medications" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-pills mr-2 text-gray-400"></i>
                                        Current Medications
                                    </label>
                                    <textarea id="current_medications" name="current_medications" rows="3" 
                                              class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 py-3 px-4"
                                              placeholder="List any medications you are currently taking">{{ old('current_medications', Auth::user()->current_medications) }}</textarea>
                                    @error('current_medications')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Medical Conditions -->
                                <div>
                                    <label for="medical_conditions" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-stethoscope mr-2 text-gray-400"></i>
                                        Medical Conditions
                                    </label>
                                    <textarea id="medical_conditions" name="medical_conditions" rows="3" 
                                              class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 py-3 px-4"
                                              placeholder="List any chronic conditions or medical history">{{ old('medical_conditions', Auth::user()->medical_conditions) }}</textarea>
                                    @error('medical_conditions')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Medical Preferences -->
                                <div class="bg-green-50 rounded-xl p-4 md:p-6 border border-green-200">
                                    <h4 class="text-base md:text-lg font-semibold text-green-900 mb-3 md:mb-4">Medical Preferences</h4>
                                    <div class="space-y-3 md:space-y-4">
                                        <label class="flex items-start">
                                            <input type="checkbox" name="willing_to_donate_blood" value="1" {{ old('willing_to_donate_blood', Auth::user()->willing_to_donate_blood) ? 'checked' : '' }} 
                                                   class="mt-1 rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                            <span class="ml-3 text-xs md:text-sm text-green-800">I am willing to donate blood when needed</span>
                                        </label>
                                        <label class="flex items-start">
                                            <input type="checkbox" name="emergency_contact_consent" value="1" {{ old('emergency_contact_consent', Auth::user()->emergency_contact_consent) ? 'checked' : '' }} 
                                                   class="mt-1 rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                            <span class="ml-3 text-xs md:text-sm text-green-800">Allow emergency contact in case of medical emergencies</span>
                                        </label>
                                        <label class="flex items-start">
                                            <input type="checkbox" name="health_reminders" value="1" {{ old('health_reminders', Auth::user()->health_reminders) ? 'checked' : '' }} 
                                                   class="mt-1 rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                            <span class="ml-3 text-xs md:text-sm text-green-800">Send me health tips and reminders</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security & Privacy Tab -->
                        <div x-show="activeTab === 'security'" x-transition>
                            <div class="mb-6 md:mb-8">
                                <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-1 md:mb-2">Security & Privacy Settings</h3>
                                <p class="text-sm text-gray-600">Manage your account security and privacy preferences</p>
                            </div>

                            <div class="space-y-6 md:space-y-8">
                                <!-- Change Password -->
                                <div class="bg-gray-50 rounded-xl p-4 md:p-6 border border-gray-200">
                                    <h4 class="text-base md:text-lg font-semibold text-gray-900 mb-3 md:mb-4">Change Password</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                        <div class="md:col-span-2">
                                            <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fas fa-lock mr-2 text-gray-400"></i>
                                                Current Password
                                            </label>
                                            <input type="password" id="current_password" name="current_password" 
                                                   class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 py-3 px-4"
                                                   placeholder="Enter your current password">
                                            @error('current_password')
                                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fas fa-key mr-2 text-gray-400"></i>
                                                New Password
                                            </label>
                                            <input type="password" id="password" name="password" 
                                                   class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 py-3 px-4"
                                                   placeholder="Enter new password">
                                            @error('password')
                                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fas fa-key mr-2 text-gray-400"></i>
                                                Confirm New Password
                                            </label>
                                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                                   class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 py-3 px-4"
                                                   placeholder="Confirm new password">
                                        </div>
                                    </div>
                                </div>

                                <!-- Privacy Settings -->
                                <div class="bg-purple-50 rounded-xl p-4 md:p-6 border border-purple-200">
                                    <h4 class="text-base md:text-lg font-semibold text-purple-900 mb-3 md:mb-4">Privacy Settings</h4>
                                    <div class="space-y-3 md:space-y-4">
                                        <label class="flex items-center justify-between">
                                            <span class="text-xs md:text-sm text-purple-800">Allow marketing communications</span>
                                            <input type="checkbox" name="marketing_consent" value="1" {{ old('marketing_consent', Auth::user()->marketing_consent) ? 'checked' : '' }} 
                                                   class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        </label>
                                        <label class="flex items-center justify-between">
                                            <span class="text-xs md:text-sm text-purple-800">Share data with healthcare partners</span>
                                            <input type="checkbox" name="data_sharing_consent" value="1" {{ old('data_sharing_consent', Auth::user()->data_sharing_consent) ? 'checked' : '' }} 
                                                   class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        </label>
                                        <label class="flex items-center justify-between">
                                            <span class="text-xs md:text-sm text-purple-800">Enable location tracking for better service</span>
                                            <input type="checkbox" name="location_tracking" value="1" {{ old('location_tracking', Auth::user()->location_tracking) ? 'checked' : '' }} 
                                                   class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        </label>
                                    </div>
                                </div>

                                <!-- Account Actions -->
                                <div class="bg-red-50 rounded-xl p-4 md:p-6 border border-red-200">
                                    <h4 class="text-base md:text-lg font-semibold text-red-900 mb-3 md:mb-4">Account Actions</h4>
                                    <div class="flex flex-col sm:flex-row gap-3 md:gap-4">
                                        <button type="button" @click="downloadData" class="w-full sm:w-auto inline-flex items-center justify-center px-3 md:px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-download mr-2"></i>
                                            Download My Data
                                        </button>
                                        <button type="button" @click="confirmDeleteAccount" class="w-full sm:w-auto inline-flex items-center justify-center px-3 md:px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition-colors">
                                            <i class="fas fa-trash mr-2"></i>
                                            Delete Account
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row sm:justify-end pt-6 md:pt-8 border-t border-gray-200 mt-6 md:mt-8">
                            <button type="button" @click="resetForm" class="mb-3 sm:mb-0 sm:mr-4 inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors font-medium text-sm md:text-base w-full sm:w-auto">
                                <i class="fas fa-undo mr-2"></i>
                                Reset
                            </button>
                            <button type="submit" :disabled="isSubmitting" 
                                    class="inline-flex items-center justify-center px-4 sm:px-8 py-2 sm:py-3 bg-gradient-to-r from-primary-600 to-primary-700 border border-transparent rounded-xl font-bold text-white hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:bg-gray-400 disabled:cursor-not-allowed transform hover:scale-105 transition-all duration-200 shadow-lg text-sm md:text-base w-full sm:w-auto">
                                <span x-show="isSubmitting" class="flex items-center justify-center">
                                    <div class="animate-spin rounded-full h-4 w-4 md:h-5 md:w-5 border-b-2 border-white mr-2 md:mr-3"></div>
                                    Saving...
                                </span>
                                <span x-show="!isSubmitting" class="flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i>
                                    Save Changes
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function profileForm() {
            return {
                activeTab: 'personal',
                isSubmitting: false,
                locationStatus: null,

                init() {
                    // Auto-save functionality
                    this.$watch('activeTab', () => {
                        this.locationStatus = null;
                    });
                },

                handleFormSubmit(event) {
                    this.isSubmitting = true;
                    // Form will submit normally, this just shows loading state
                },

                handleProfilePictureChange(event) {
                    const file = event.target.files[0];
                    if (file) {
                        // Handle profile picture upload
                        console.log('Profile picture selected:', file.name);
                        // You can add preview functionality here
                    }
                },

                getCurrentLocation() {
                    if (!navigator.geolocation) {
                        this.locationStatus = {
                            type: 'error',
                            message: 'Geolocation is not supported by this browser.'
                        };
                        return;
                    }

                    this.locationStatus = {
                        type: 'info',
                        message: 'Getting your location...'
                    };

                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const latitude = position.coords.latitude;
                            const longitude = position.coords.longitude;
                            
                            // Update hidden fields or make API call to save coordinates
                            this.locationStatus = {
                                type: 'success',
                                message: 'Location updated successfully!'
                            };
                            
                            // You can make an API call here to save the coordinates
                            this.saveLocation(latitude, longitude);
                        },
                        (error) => {
                            let message = 'Unable to retrieve your location.';
                            switch(error.code) {
                                case error.PERMISSION_DENIED:
                                    message = 'Location access denied by user.';
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    message = 'Location information is unavailable.';
                                    break;
                                case error.TIMEOUT:
                                    message = 'Location request timed out.';
                                    break;
                            }
                            this.locationStatus = {
                                type: 'error',
                                message: message
                            };
                        }
                    );
                },

                saveLocation(latitude, longitude) {
                    fetch('/api/update-location', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            latitude: latitude,
                            longitude: longitude
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Location saved successfully');
                    })
                    .catch(error => {
                        console.error('Error saving location:', error);
                    });
                },

                downloadData() {
                    if (confirm('Are you sure you want to download all your data? This may take a few minutes.')) {
                        window.location.href = '/api/download-user-data';
                    }
                },

                confirmDeleteAccount() {
                    if (confirm('Are you sure you want to delete your account? This action cannot be undone and all your data will be permanently removed.')) {
                        if (confirm('This is your final warning. Are you absolutely sure you want to delete your account?')) {
                            // Redirect to account deletion route
                            window.location.href = '/profile/delete-account';
                        }
                    }
                },

                resetForm() {
                    if (confirm('Are you sure you want to reset all changes? Any unsaved changes will be lost.')) {
                        location.reload();
                    }
                }
            }
        }
    </script>
</x-consumer-dashboard-layout>