<x-consumer-dashboard-layout>
    <x-slot name="header">
        <h1 class="text-2xl md:text-3xl font-display font-bold text-gray-800">My Profile</h1>
    </x-slot>

    <div class="py-8" x-data="{ activeTab: 'profile' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Profile Header Card -->
            <div class="bg-white shadow rounded-lg mb-8 overflow-hidden">
                <div class="md:flex items-center">
                    <div class="md:w-1/4 p-6 bg-gradient-to-r from-primary-50 to-primary-100 flex flex-col items-center justify-center">
                         <!-- Profile Picture Placeholder -->
                        <div class="w-24 h-24 rounded-full bg-primary-500 flex items-center justify-center text-white text-3xl font-semibold mb-3 relative group">
                            {{ substr(Auth::user()->name, 0, 1) }}
                            <button class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="fas fa-camera text-white"></i>
                                <span class="sr-only">Change picture</span>
                            </button>
                        </div>
                        <button class="text-xs text-primary-600 hover:underline">Change Picture</button>
                    </div>
                    <div class="p-6 flex-1">
                        <h2 class="text-xl font-bold text-gray-900">{{ Auth::user()->name }}</h2>
                        <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                        <p class="text-sm text-gray-500 mt-1">Member since {{ Auth::user()->created_at->format('M Y') }}</p>
                        <!-- Add more relevant info like last login if needed -->
                    </div>
                    <div class="p-6 border-t md:border-t-0 md:border-l">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Account Status</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            Active
                        </span>
                        <!-- Add other badges if needed -->
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="mb-6 border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button @click="activeTab = 'profile'" 
                            :class="{ 'border-primary-500 text-primary-600': activeTab === 'profile', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'profile' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Edit Profile
                    </button>
                    <button @click="activeTab = 'password'" 
                            :class="{ 'border-primary-500 text-primary-600': activeTab === 'password', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'password' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Update Password
                    </button>
                    <button @click="activeTab = 'settings'" 
                            :class="{ 'border-primary-500 text-primary-600': activeTab === 'settings', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'settings' }"
                            class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Account Settings
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div>
                <!-- Profile Information Tab -->
                <div x-show="activeTab === 'profile'">
                    <form method="POST" action="{{ route('consumer.profile.update') }}" class="bg-white shadow rounded-lg p-6 md:p-8 space-y-6">
                        @csrf
                        @method('PATCH')

                        <h3 class="text-lg font-medium text-gray-900 border-b pb-3">Personal Information</h3>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 bg-gray-50 text-gray-500" readonly>
                            <p class="mt-1 text-xs text-gray-500">Email cannot be changed.</p>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone) }}" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="+234XXXXXXXXXX">
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea name="address" id="address" rows="3" required 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('address', auth()->user()->address) }}</textarea>
                            @error('address')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end pt-6 border-t border-gray-200">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Update Password Tab -->
                <div x-show="activeTab === 'password'" style="display: none;">
                     <div class="bg-white shadow rounded-lg p-6 md:p-8">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-3 mb-6">Update Password</h3>
                        <p class="text-sm text-gray-600">Ensure your account is using a long, random password to stay secure.</p>
                        <!-- Password update form goes here -->
                         <form class="space-y-6">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                <input type="password" name="current_password" id="current_password" required 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                             <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                                <input type="password" name="new_password" id="new_password" required 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                             <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" required 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                             <div class="flex justify-end pt-6 border-t border-gray-200">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                 <!-- Account Settings Tab -->
                <div x-show="activeTab === 'settings'" style="display: none;">
                    <div class="space-y-8">
                         <!-- Communication Preferences -->
                        <div class="bg-white shadow rounded-lg p-6 md:p-8">
                             <h3 class="text-lg font-medium text-gray-900 border-b pb-3 mb-6">Communication Preferences</h3>
                             <form>
                                <fieldset class="space-y-3">
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="comm_email" name="communication_preference[]" type="checkbox" value="email" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500" {{ in_array('email', old('communication_preference', auth()->user()->communication_preferences ?? [])) ? 'checked' : '' }}>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="comm_email" class="font-medium text-gray-700">Email Notifications</label>
                                            <p class="text-gray-500">Receive order updates, results, and promotions via email.</p>
                                        </div>
                                    </div>
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="comm_sms" name="communication_preference[]" type="checkbox" value="sms" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500" {{ in_array('sms', old('communication_preference', auth()->user()->communication_preferences ?? [])) ? 'checked' : '' }}>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="comm_sms" class="font-medium text-gray-700">SMS Notifications</label>
                                            <p class="text-gray-500">Receive critical order updates via SMS (charges may apply).</p>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="flex justify-end pt-6 border-t border-gray-200 mt-6">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Save Preferences
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Delete Account Section -->
                        <div class="bg-white shadow rounded-lg p-6 md:p-8">
                            <h3 class="text-lg font-medium text-red-600 border-b border-red-200 pb-3 mb-6">Delete Account</h3>
                            <p class="text-sm text-gray-600 mb-4">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
                            <div class="text-right">
                                <button type="button" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Delete Account
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-consumer-dashboard-layout>
