    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Place New Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    
                    <form method="POST" action="{{ route('consumer.orders.store') }}" class="space-y-6">
                        @csrf

                        <!-- Order Type -->
                        <div>
                            <x-input-label for="order_type" :value="__('Select Service Type')" />
                            <select id="order_type" name="order_type" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="" disabled selected>-- Select Service --</option>
                                <option value="test" {{ old('order_type') == 'test' ? 'selected' : '' }}>eMedSample (Lab Test)</option>
                                <option value="blood" {{ old('order_type') == 'blood' ? 'selected' : '' }}>SharedBlood (Blood Request/Donation)</option>
                            </select>
                            <x-input-error :messages="$errors->get('order_type')" class="mt-2" />
                        </div>

                        <!-- Facility Selection (Simplified for now) -->
                        <div>
                            <x-input-label for="facility_id" :value="__('Select Facility (Lab/Hospital)')" />
                            <select id="facility_id" name="facility_id" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="" disabled selected>-- Select Facility --</option>
                                @foreach ($facilities as $facility)
                                    <option value="{{ $facility->id }}" {{ old('facility_id') == $facility->id ? 'selected' : '' }}>
                                        {{ $facility->name }} ({{ $facility->address }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('facility_id')" class="mt-2" />
                            <p class="mt-2 text-sm text-gray-500">Note: Facility matching/discovery will be enhanced later.</p>
                        </div>

                        <!-- Order Details (e.g., Test Type or Blood Group) -->
                        <div>
                            <x-input-label for="details" :value="__('Order Specifics')" />
                            <textarea id="details" name="details" rows="4" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Specify required lab tests (e.g., Full Blood Count, Malaria Test) or blood group needed (e.g., O+ urgently needed).">{{ old('details') }}</textarea>
                            <x-input-error :messages="$errors->get('details')" class="mt-2" />
                        </div>

                         <!-- Address (Pickup/Delivery might depend on order type - simplified) -->
                        <div>
                            <x-input-label for="delivery_address" :value="__('Delivery/Service Address')" />
                            <textarea id="delivery_address" name="delivery_address" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Enter the address where the service/delivery is needed. Your registered address will be used if left blank.">{{ old('delivery_address', Auth::user()->address) }}</textarea>
                             <x-input-error :messages="$errors->get('delivery_address')" class="mt-2" />
                        </div>
                        
                        <!-- Scheduling (Simplified) -->
                        <div>
                            <x-input-label for="pickup_scheduled_time" :value="__('Preferred Date/Time (Optional)')" />
                             <input type="datetime-local" id="pickup_scheduled_time" name="pickup_scheduled_time" value="{{ old('pickup_scheduled_time') }}" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                             <x-input-error :messages="$errors->get('pickup_scheduled_time')" class="mt-2" />
                        </div>

                        <!-- Payment Placeholder -->
                        <div class="border-t pt-4 mt-6">
                             <h3 class="text-lg font-medium">Payment (Placeholder)</h3>
                             <p class="text-gray-600">Total Amount: <span class="font-semibold">₦5,000 (Example)</span></p> 
                             <p class="text-sm text-gray-500">Paystack integration will be added here. For now, order will be placed with 'pending' payment status.</p>
                             <input type="hidden" name="total_amount" value="5000"> <!-- Example Amount -->
                             <input type="hidden" name="payment_method" value="paystack_placeholder">
                        </div>


                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Place Order') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
