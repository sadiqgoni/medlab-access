<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Address')" />
            <textarea id="address" name="address" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('address') }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Government ID -->
        <div class="mt-4">
            <x-input-label for="government_id" :value="__('Government ID (e.g., NIN, Voter\'s Card)')" />
            <x-text-input id="government_id" class="block mt-1 w-full" type="text" name="government_id" :value="old('government_id')" />
            <x-input-error :messages="$errors->get('government_id')" class="mt-2" />
        </div>

        <!-- Blood Group & Donor Eligibility -->
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="blood_group" :value="__('Blood Group (Optional)')" />
                <select id="blood_group" name="blood_group" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">Select...</option>
                    <option value="A+" @selected(old('blood_group') == 'A+')>A+</option>
                    <option value="A-" @selected(old('blood_group') == 'A-')>A-</option>
                    <option value="B+" @selected(old('blood_group') == 'B+')>B+</option>
                    <option value="B-" @selected(old('blood_group') == 'B-')>B-</option>
                    <option value="AB+" @selected(old('blood_group') == 'AB+')>AB+</option>
                    <option value="AB-" @selected(old('blood_group') == 'AB-')>AB-</option>
                    <option value="O+" @selected(old('blood_group') == 'O+')>O+</option>
                    <option value="O-" @selected(old('blood_group') == 'O-')>O-</option>
                </select>
                <x-input-error :messages="$errors->get('blood_group')" class="mt-2" />
            </div>
            <div class="flex items-center justify-start mt-6 md:mt-0">
                <label for="eligible_donor" class="inline-flex items-center">
                    <input id="eligible_donor" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="eligible_donor" value="1" @checked(old('eligible_donor'))>
                    <span class="ms-2 text-sm text-gray-600">{{ __('Eligible to Donate Blood?') }}</span>
                </label>
                 <x-input-error :messages="$errors->get('eligible_donor')" class="mt-2" />
            </div>
        </div>

        <!-- Communication Preference -->
        <div class="mt-4">
            <x-input-label for="communication_preference" :value="__('Preferred Communication')" />
            <select id="communication_preference" name="communication_preference" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="email" @selected(old('communication_preference', 'email') == 'email')>Email</option>
                <option value="sms" @selected(old('communication_preference') == 'sms')>SMS</option>
                <option value="app" @selected(old('communication_preference') == 'app')>App Notification</option>
            </select>
            <x-input-error :messages="$errors->get('communication_preference')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password"
                            class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
