<x-consumer-dashboard-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Place New Order</h1>
                <p class="mt-2 text-gray-600">Request lab tests or blood services from our trusted network</p>
                <div class="flex items-center mt-3 space-x-4">
                    <div class="flex items-center text-sm text-green-600">
                        <i class="fas fa-shield-alt mr-2"></i>
                        <span>Secure & Confidential</span>
                    </div>
                    <div class="flex items-center text-sm text-blue-600">
                        <i class="fas fa-clock mr-2"></i>
                        <span>24/7 Support</span>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="py-6" x-data="orderForm()">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Progress Indicator -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-600 text-white text-sm font-semibold">1</div>
                        <span class="ml-3 text-sm font-medium text-primary-600">Service Selection</span>
                    </div>
                    <div class="flex-1 mx-4 h-1 bg-gray-200 rounded">
                        <div class="h-1 bg-primary-600 rounded" :style="`width: ${orderType ? '33%' : '0%'}`"></div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full" :class="selectedFacility ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-500'">2</div>
                        <span class="ml-3 text-sm font-medium" :class="selectedFacility ? 'text-primary-600' : 'text-gray-500'">Facility & Services</span>
                    </div>
                    <div class="flex-1 mx-4 h-1 bg-gray-200 rounded">
                        <div class="h-1 bg-primary-600 rounded" :style="`width: ${selectedServices.length > 0 ? '66%' : '0%'}`"></div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full" :class="selectedServices.length > 0 ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-500'">3</div>
                        <span class="ml-3 text-sm font-medium" :class="selectedServices.length > 0 ? 'text-primary-600' : 'text-gray-500'">Payment & Delivery</span>
                    </div>
                </div>
            </div>

            <!-- Service Type Selection -->
            <div class="bg-white rounded-xl shadow-sm p-8 mb-8 border border-gray-100">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">Choose Your Health Service</h2>
                    <p class="text-gray-600">Select the type of medical service you need</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <!-- eMedSample Option -->
                    <div class="relative group">
                        <input type="radio" id="order_type_test" name="order_type_selection" value="test" class="peer absolute opacity-0" x-model="orderType" @change="fetchNearbyFacilities">
                        <label for="order_type_test" class="block p-8 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-2xl cursor-pointer transition-all duration-300 hover:from-blue-100 hover:to-blue-200 hover:border-blue-300 peer-checked:from-blue-500 peer-checked:to-blue-600 peer-checked:border-blue-500 peer-checked:text-white group-hover:scale-105 transform">
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-white/20 mb-6 group-hover:bg-white/30 transition-colors">
                                    <i class="fas fa-vial text-3xl" :class="orderType === 'test' ? 'text-white' : 'text-blue-600'"></i>
                                </div>
                                <h3 class="text-2xl font-bold mb-3" :class="orderType === 'test' ? 'text-white' : 'text-gray-900'">eMedSample</h3>
                                <p class="text-lg mb-4" :class="orderType === 'test' ? 'text-blue-100' : 'text-gray-600'">Laboratory Testing Services</p>
                                <div class="space-y-2 text-sm" :class="orderType === 'test' ? 'text-blue-100' : 'text-gray-500'">
                                    <div class="flex items-center justify-center">
                                        <i class="fas fa-check mr-2"></i>
                                        <span>Home sample collection</span>
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <i class="fas fa-check mr-2"></i>
                                        <span>Fast & accurate results</span>
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <i class="fas fa-check mr-2"></i>
                                        <span>Digital reports</span>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <div class="absolute top-4 right-4 h-8 w-8 rounded-full bg-blue-500 text-white flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity duration-300">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                    </div>
                    
                    <!-- SharedBlood Option -->
                    <div class="relative group">
                        <input type="radio" id="order_type_blood" name="order_type_selection" value="blood" class="peer absolute opacity-0" x-model="orderType" @change="fetchNearbyFacilities">
                        <label for="order_type_blood" class="block p-8 bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-200 rounded-2xl cursor-pointer transition-all duration-300 hover:from-red-100 hover:to-red-200 hover:border-red-300 peer-checked:from-red-500 peer-checked:to-red-600 peer-checked:border-red-500 peer-checked:text-white group-hover:scale-105 transform">
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center h-16 w-16 rounded-2xl bg-white/20 mb-6 group-hover:bg-white/30 transition-colors">
                                    <i class="fas fa-tint text-3xl" :class="orderType === 'blood' ? 'text-white' : 'text-red-600'"></i>
                                </div>
                                <h3 class="text-2xl font-bold mb-3" :class="orderType === 'blood' ? 'text-white' : 'text-gray-900'">SharedBlood</h3>
                                <p class="text-lg mb-4" :class="orderType === 'blood' ? 'text-red-100' : 'text-gray-600'">Blood Donation & Requests</p>
                                <div class="space-y-2 text-sm" :class="orderType === 'blood' ? 'text-red-100' : 'text-gray-500'">
                                    <div class="flex items-center justify-center">
                                        <i class="fas fa-check mr-2"></i>
                                        <span>Safe blood donation</span>
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <i class="fas fa-check mr-2"></i>
                                        <span>Emergency blood requests</span>
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <i class="fas fa-check mr-2"></i>
                                        <span>Community impact</span>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <div class="absolute top-4 right-4 h-8 w-8 rounded-full bg-red-500 text-white flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity duration-300">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100" x-show="orderType" x-transition>
                <form id="order-form" method="POST" action="{{ route('consumer.orders.store') }}" class="p-8 space-y-8">
                    @csrf
                    <input type="hidden" id="order_type_input" name="order_type" x-model="orderType">
                    
                    <!-- Facility & Service Selection -->
                    <div>
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-primary-100 mr-4">
                                <i class="fas fa-hospital text-primary-600"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Select Facility & Services</h3>
                                <p class="text-gray-600">Choose from nearby approved facilities</p>
                            </div>
                        </div>
                        
                        <!-- Facility Selection -->
                        <div class="mb-6">
                            <label for="facility_id" class="block text-sm font-semibold text-gray-700 mb-3">Choose Nearby Facility</label>
                            <div class="relative">
                                <select id="facility_id" name="facility_id" required 
                                        class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 disabled:bg-gray-100 text-lg py-4 pl-4 pr-12"
                                        x-model="selectedFacility" @change="fetchServices" :disabled="loadingFacilities || nearbyFacilities.length === 0">
                                    <option value="" x-show="!loadingFacilities">-- Choose a nearby facility --</option>
                                    <option value="" x-show="loadingFacilities" disabled>🔍 Finding nearby facilities...</option>
                                    <template x-for="facility in nearbyFacilities" :key="facility.id">
                                        <option :value="facility.id" x-text="`${facility.name} (${facility.distance.toFixed(1)} km away)`"></option>
                                    </template>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                            
                            <!-- Loading State -->
                            <div x-show="loadingFacilities" class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <div class="flex items-center">
                                    <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-primary-600 mr-3"></div>
                                    <span class="text-sm text-blue-700">Finding nearby facilities offering <span x-text="orderType === 'test' ? 'lab services' : 'blood services'"></span>...</span>
                                </div>
                            </div>
                            
                            <!-- No Facilities Found -->
                            <div x-show="!loadingFacilities && orderType && nearbyFacilities.length === 0" class="mt-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-triangle text-yellow-600 mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium text-yellow-800">No facilities found in your area</p>
                                        <p class="text-sm text-yellow-700 mt-1">Please check your profile address or contact support for assistance.</p>
                                    </div>
                                </div>
                            </div>
                            
                            @error('facility_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Service Selection -->
                        <div x-show="selectedFacility && availableServices.length > 0" x-transition>
                            <label class="block text-sm font-semibold text-gray-700 mb-4">Select Service(s)</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <template x-for="service in availableServices" :key="service.id">
                                    <div class="relative">
                                        <input :id="'service_' + service.id" name="services[]" :value="service.id" type="checkbox" 
                                               x-model="selectedServices" 
                                               class="peer absolute opacity-0">
                                        <label :for="'service_' + service.id" class="block p-6 bg-white border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200 hover:border-primary-300 hover:bg-primary-50 peer-checked:border-primary-500 peer-checked:bg-primary-50">
                                            <div class="flex justify-between items-start mb-3">
                                                <h4 class="font-semibold text-gray-900" x-text="service.name"></h4>
                                                <div class="flex items-center">
                                                    <span class="text-lg font-bold text-primary-600" x-text="formatCurrency(service.price)"></span>
                                                    <div class="ml-3 h-5 w-5 rounded-full border-2 border-gray-300 peer-checked:border-primary-500 peer-checked:bg-primary-500 flex items-center justify-center">
                                                        <i class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="space-y-2">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-sm text-gray-500">Turnaround Time:</span>
                                                    <span class="text-sm font-medium text-gray-700" x-text="service.turnaround_time || 'Same day'"></span>
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-sm text-gray-500">Availability:</span>
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" 
                                                          :class="{
                                                            'bg-green-100 text-green-800': service.availability_status === 'available', 
                                                            'bg-yellow-100 text-yellow-800': service.availability_status === 'limited',
                                                            'bg-red-100 text-red-800': service.availability_status === 'unavailable'
                                                          }" x-text="service.availability_status"></span>
                                                </div>
                                            </div>
                                            
                                            <div x-show="service.requirements" class="mt-3 pt-3 border-t border-gray-200">
                                                <p class="text-xs text-gray-600">
                                                    <span class="font-medium">Requirements:</span> 
                                                    <span x-text="service.requirements"></span>
                                                </p>
                                            </div>
                                            
                                            <div x-show="service.notes" class="mt-2">
                                                <p class="text-xs text-gray-600" x-text="service.notes"></p>
                                            </div>
                                        </label>
                                        <div class="absolute top-4 right-4 h-6 w-6 rounded-full bg-primary-500 text-white flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity">
                                            <i class="fas fa-check text-xs"></i>
                                        </div>
                                    </div>
                                </template>
                            </div>
                             @error('services')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Loading Services -->
                        <div x-show="loadingServices" class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex items-center">
                                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-primary-600 mr-3"></div>
                                <span class="text-sm text-blue-700">Loading available services...</span>
                            </div>
                        </div>
                        
                        <!-- No Services -->
                        <div x-show="selectedFacility && availableServices.length === 0 && !loadingServices" class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="text-center">
                                <i class="fas fa-info-circle text-gray-400 text-2xl mb-2"></i>
                                <p class="text-sm text-gray-600">No services available for this facility.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Delivery Information -->
                    <div x-show="selectedServices.length > 0" x-transition>
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-100 mr-4">
                                <i class="fas fa-map-marker-alt text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Delivery & Logistics</h3>
                                <p class="text-gray-600">Specify pickup/delivery details</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="delivery_address" class="block text-sm font-semibold text-gray-700 mb-2">Pickup/Delivery Address</label>
                                <div class="relative">
                                    <input type="text" id="delivery_address" name="delivery_address" value="{{ old('delivery_address', Auth::user()->address) }}" required 
                                           class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 pl-12 py-4">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </div>
                                </div>
                                @error('delivery_address')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="scheduled_time" class="block text-sm font-semibold text-gray-700 mb-2">Preferred Time</label>
                                <div class="relative">
                                    <input type="datetime-local" id="scheduled_time" name="scheduled_time" value="{{ old('scheduled_time') }}" 
                                           class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 pl-12 py-4">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-clock text-gray-400"></i>
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Optional: Schedule for a later date/time</p>
                                @error('scheduled_time')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Section -->
                    <div x-show="selectedServices.length > 0" x-transition>
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-purple-100 mr-4">
                                <i class="fas fa-credit-card text-purple-600"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Payment & Summary</h3>
                                <p class="text-gray-600">Review your order and payment details</p>
                            </div>
                        </div>
                        
                        <!-- Order Summary -->
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 mb-6 border border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Service Cost:</span>
                                    <span class="font-medium text-gray-900" x-text="formatCurrency(serviceCost)"></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Delivery Fee:</span>
                                    <span class="font-medium text-gray-900" x-text="formatCurrency(deliveryFee)"></span>
                                </div>
                                <div class="border-t border-gray-300 pt-3">
                                    <div class="flex justify-between">
                                        <span class="text-lg font-bold text-gray-900">Total Amount:</span>
                                        <span class="text-2xl font-bold text-primary-600" x-text="formatCurrency(totalAmount)"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Method Selection -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-4">Payment Method</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <label for="payment_card" class="relative">
                                    <input type="radio" id="payment_card" name="payment_method" value="card" class="peer absolute opacity-0" x-model="paymentMethod" checked>
                                    <div class="flex items-center justify-center p-6 border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200 hover:border-primary-300 hover:bg-primary-50 peer-checked:border-primary-500 peer-checked:bg-primary-50">
                                        <div class="text-center">
                                            <i class="fas fa-credit-card text-2xl text-gray-600 mb-3"></i>
                                            <p class="font-medium text-gray-900">Pay with Card</p>
                                            <p class="text-xs text-gray-500 mt-1">Secure payment</p>
                                        </div>
                                    </div>
                                    <div class="absolute top-3 right-3 h-6 w-6 rounded-full bg-primary-500 text-white flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity">
                                        <i class="fas fa-check text-xs"></i>
                                    </div>
                                </label>
                                
                                <label for="payment_bank" class="relative">
                                    <input type="radio" id="payment_bank" name="payment_method" value="bank" class="peer absolute opacity-0" x-model="paymentMethod">
                                    <div class="flex items-center justify-center p-6 border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200 hover:border-primary-300 hover:bg-primary-50 peer-checked:border-primary-500 peer-checked:bg-primary-50">
                                        <div class="text-center">
                                            <i class="fas fa-university text-2xl text-gray-600 mb-3"></i>
                                            <p class="font-medium text-gray-900">Bank Transfer</p>
                                            <p class="text-xs text-gray-500 mt-1">Direct transfer</p>
                                        </div>
                                    </div>
                                    <div class="absolute top-3 right-3 h-6 w-6 rounded-full bg-primary-500 text-white flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity">
                                        <i class="fas fa-check text-xs"></i>
                                    </div>
                                </label>
                                
                                <label for="payment_cash" class="relative">
                                    <input type="radio" id="payment_cash" name="payment_method" value="cash" class="peer absolute opacity-0" x-model="paymentMethod">
                                    <div class="flex items-center justify-center p-6 border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200 hover:border-primary-300 hover:bg-primary-50 peer-checked:border-primary-500 peer-checked:bg-primary-50">
                                        <div class="text-center">
                                            <i class="fas fa-money-bill-wave text-2xl text-gray-600 mb-3"></i>
                                            <p class="font-medium text-gray-900">Cash on Delivery</p>
                                            <p class="text-xs text-gray-500 mt-1">Pay when delivered</p>
                                        </div>
                                    </div>
                                    <div class="absolute top-3 right-3 h-6 w-6 rounded-full bg-primary-500 text-white flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity">
                                        <i class="fas fa-check text-xs"></i>
                                    </div>
                                </label>
                            </div>
                            @error('payment_method')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Card Payment Fields -->
                        <div x-show="paymentMethod === 'card'" x-transition class="mb-6 p-6 bg-blue-50 rounded-xl border border-blue-200">
                            <h4 class="text-sm font-semibold text-blue-900 mb-4 flex items-center">
                                <i class="fas fa-lock mr-2"></i>
                                Secure Card Payment
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label for="card_number" class="block text-sm font-medium text-gray-700 mb-2">Card Number</label>
                                    <input type="text" id="card_number" name="card_number" x-model="cardDetails.number" @input="validateCardNumber" placeholder="1234 5678 9012 3456" 
                                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                                    <p x-show="cardErrors.number" class="mt-1 text-sm text-red-600" x-text="cardErrors.number"></p>
                                </div>
                                <div>
                                    <label for="card_expiry" class="block text-sm font-medium text-gray-700 mb-2">Expiry Date</label>
                                    <input type="text" id="card_expiry" name="card_expiry" x-model="cardDetails.expiry" @input="validateCardExpiry" placeholder="MM/YY" 
                                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                                    <p x-show="cardErrors.expiry" class="mt-1 text-sm text-red-600" x-text="cardErrors.expiry"></p>
                                </div>
                                <div>
                                    <label for="card_cvv" class="block text-sm font-medium text-gray-700 mb-2">CVV</label>
                                    <input type="text" id="card_cvv" name="card_cvv" x-model="cardDetails.cvv" @input="validateCardCvv" placeholder="123" 
                                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 py-3">
                                    <p x-show="cardErrors.cvv" class="mt-1 text-sm text-red-600" x-text="cardErrors.cvv"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Transfer Fields -->
                        <div x-show="paymentMethod === 'bank'" x-transition class="mb-6 p-6 bg-green-50 rounded-xl border border-green-200">
                            <h4 class="text-sm font-semibold text-green-900 mb-4 flex items-center">
                                <i class="fas fa-university mr-2"></i>
                                Bank Transfer Details
                            </h4>
                            <div x-show="!waitingForTransfer">
                                <p class="text-sm text-green-800 mb-4">Please transfer the total amount to the following bank account:</p>
                                <div class="bg-white p-4 rounded-lg border border-green-200 mb-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="font-medium text-gray-700">Bank:</span>
                                            <span class="text-gray-900">GTB Bank</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-700">Account Name:</span>
                                            <span class="text-gray-900">DHR SPACE</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-700">Account Number:</span>
                                            <span class="text-gray-900 font-mono">1234567890</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-700">Amount:</span>
                                            <span class="text-gray-900 font-bold" x-text="formatCurrency(totalAmount)"></span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" @click="initiateBankTransfer" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    <i class="fas fa-check mr-2"></i>
                                    I Have Initiated the Transfer
                                </button>
                            </div>
                            <div x-show="waitingForTransfer" class="flex items-center justify-between p-4 bg-white rounded-lg border border-green-200">
                                <div class="flex items-center">
                                    <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-green-600 mr-3"></div>
                                    <span class="text-sm text-green-800">Waiting for your confirmation...</span>
                                </div>
                                <button type="button" @click="confirmBankTransfer" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    <i class="fas fa-check mr-2"></i>
                                    I Have Paid
                                </button>
                            </div>
                        </div>

                        <!-- Cash on Delivery Info -->
                        <div x-show="paymentMethod === 'cash'" x-transition class="mb-6 p-6 bg-orange-50 rounded-xl border border-orange-200">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle text-orange-600 mr-3"></i>
                                <div>
                                    <h4 class="text-sm font-semibold text-orange-900">Cash on Delivery</h4>
                                    <p class="text-sm text-orange-800 mt-1">You will pay <span class="font-bold" x-text="formatCurrency(totalAmount)"></span> in cash upon delivery or service completion.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div x-show="selectedServices.length > 0" x-transition class="flex justify-end pt-8 border-t border-gray-200">
                        <button type="submit" :disabled="isPaymentProcessing || !isPaymentValid" 
                                class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary-600 to-primary-700 border border-transparent rounded-xl font-bold text-lg text-white hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:bg-gray-400 disabled:cursor-not-allowed transform hover:scale-105 transition-all duration-200 shadow-lg">
                            <span x-show="isPaymentProcessing" class="flex items-center">
                                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white mr-3"></div>
                                Processing...
                            </span>
                            <span x-show="!isPaymentProcessing" class="flex items-center">
                                <i class="fas fa-shopping-cart mr-3"></i>
                                Place Order (<span x-text="formatCurrency(totalAmount)"></span>)
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function orderForm() {
            return {
                orderType: @json(old('order_type')) || null,
                userLatitude: {{ Auth::user()->latitude ?? 'null' }},
                userLongitude: {{ Auth::user()->longitude ?? 'null' }},
                nearbyFacilities: [],
                loadingFacilities: false,
                selectedFacility: '{{ old("facility_id") }}' || '',
                availableServices: [],
                selectedServices: @json(old('services', [])) || [],
                loadingServices: false,
                serviceCost: 0,
                deliveryFee: 0,
                totalAmount: 0,
                paymentMethod: 'card',
                cardDetails: {
                    number: '',
                    expiry: '',
                    cvv: ''
                },
                cardErrors: {
                    number: '',
                    expiry: '',
                    cvv: ''
                },
                waitingForTransfer: false,
                isPaymentProcessing: false,
                isPaymentValid: true,

                init() {
                    this.updateCost();
                    this.$watch('selectedServices', () => this.updateCost());
                    this.$watch('paymentMethod', () => this.resetPaymentState());
                    
                    this.$watch('orderType', () => {
                        this.selectedFacility = '';
                        this.availableServices = [];
                        this.selectedServices = [];
                        this.nearbyFacilities = [];
                        
                        if (this.orderType) {
                            this.fetchNearbyFacilities();
                        }
                    });
                    
                    this.$watch('cardDetails', () => {
                        if (this.paymentMethod === 'card') {
                            this.validateCardPayment();
                        }
                    }, { deep: true });
                    
                    this.$watch('paymentMethod', () => {
                        this.isPaymentValid = this.paymentMethod !== 'card' || 
                            (!this.cardErrors.number && !this.cardErrors.expiry && !this.cardErrors.cvv);
                    });
                },

                validateCardPayment() {
                    this.validateCardNumber();
                    this.validateCardExpiry();
                    this.validateCardCvv();
                    
                    this.isPaymentValid = !this.cardErrors.number && !this.cardErrors.expiry && !this.cardErrors.cvv;
                },

                fetchNearbyFacilities() {
                    if (!this.orderType || this.userLatitude === null || this.userLongitude === null) {
                        this.nearbyFacilities = [];
                        return;
                    }

                    this.loadingFacilities = true;
                    this.nearbyFacilities = [];
                    this.selectedFacility = '';

                    const url = `/api/nearby-facilities?latitude=${this.userLatitude}&longitude=${this.userLongitude}&order_type=${this.orderType}&radius=10`;
                    
                    fetch(url, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(response => {
                            if (!response.ok) { throw new Error(`Network response was not ok (${response.status})`); }
                            return response.json();
                        })
                        .then(data => {
                            this.nearbyFacilities = Array.isArray(data) ? data : [];
                        })
                        .catch(error => {
                            console.error('Error fetching nearby facilities:', error);
                            this.nearbyFacilities = [];
                        })
                        .finally(() => { this.loadingFacilities = false; });
                },

                fetchServices() {
                    if (!this.selectedFacility) {
                        this.availableServices = [];
                        this.selectedServices = [];
                        this.updateCost();
                        return;
                    }
                    this.loadingServices = true;
                    this.availableServices = [];
                    this.selectedServices = [];
                    
                    const url = `/api/facilities/${this.selectedFacility}/services`;
                    fetch(url, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(response => {
                            if (!response.ok) { throw new Error(`Network response was not ok (${response.status})`); }
                            return response.json();
                        })
                        .then(data => {
                            this.availableServices = Array.isArray(data) ? data.filter(service => {
                                if (service.type !== this.orderType || !service.is_active) {
                                    return false;
                                }
                                
                                if (service.category === 'SharedBlood' && service.availability_status === 'unavailable') {
                                    return false;
                                }
                                
                                return true;
                            }) : [];
                        })
                        .catch(error => {
                            console.error('Error fetching services:', error);
                            this.availableServices = [];
                        })
                        .finally(() => { 
                            this.loadingServices = false; 
                            this.updateCost();
                        });
                },

                get selectedServiceObjects() {
                    const selectedIds = this.selectedServices.map(id => id.toString());
                    return this.availableServices.filter(s => selectedIds.includes(s.id.toString()));
                },

                updateCost() {
                    let currentServiceCost = 0;
                    const baseDelivery = 500;
                    this.deliveryFee = 0;
                    let requiresDelivery = false;

                    this.selectedServiceObjects.forEach(service => {
                        if (service && service.price) {
                            currentServiceCost += parseFloat(service.price);
                            if (parseFloat(service.price) > 0) { 
                                requiresDelivery = true;
                            }
                        }
                    });

                    if (requiresDelivery) {
                        this.deliveryFee = baseDelivery;
                    }

                    this.serviceCost = currentServiceCost;
                    this.totalAmount = this.serviceCost + this.deliveryFee;
                },

                formatCurrency(amount) {
                    const numAmount = parseFloat(amount);
                    if (isNaN(numAmount)) { return '₦0.00'; }
                    return '₦' + numAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },

                resetPaymentState() {
                    this.cardDetails = { number: '', expiry: '', cvv: '' };
                    this.cardErrors = { number: '', expiry: '', cvv: '' };
                    this.waitingForTransfer = false;
                    this.isPaymentProcessing = false;
                },

                validateCardNumber() {
                    const number = this.cardDetails.number.replace(/\s/g, '');
                    if (!number) {
                        this.cardErrors.number = 'Card number is required';
                    } else if (!/^\d{16}$/.test(number)) {
                        this.cardErrors.number = 'Card number must be 16 digits';
                    } else {
                        this.cardErrors.number = '';
                    }
                },

                validateCardExpiry() {
                    const expiry = this.cardDetails.expiry;
                    if (!expiry) {
                        this.cardErrors.expiry = 'Expiry date is required';
                    } else if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry)) {
                        this.cardErrors.expiry = 'Invalid format (MM/YY)';
                    } else {
                        const [month, year] = expiry.split('/').map(Number);
                        const currentYear = new Date().getFullYear() % 100;
                        const currentMonth = new Date().getMonth() + 1;
                        if (year < currentYear || (year === currentYear && month < currentMonth)) {
                            this.cardErrors.expiry = 'Card is expired';
                        } else {
                            this.cardErrors.expiry = '';
                        }
                    }
                },

                validateCardCvv() {
                    const cvv = this.cardDetails.cvv;
                    if (!cvv) {
                        this.cardErrors.cvv = 'CVV is required';
                    } else if (!/^\d{3}$/.test(cvv)) {
                        this.cardErrors.cvv = 'CVV must be 3 digits';
                    } else {
                        this.cardErrors.cvv = '';
                    }
                },

                initiateBankTransfer() {
                    this.waitingForTransfer = true;
                },

                confirmBankTransfer() {
                    this.isPaymentProcessing = true;
                    
                    const form = document.getElementById('order-form');
                    if (form) {
                        form.submit();
                    } else {
                        console.error("Order form not found!");
                        this.isPaymentProcessing = false;
                    }
                }
            }
        }
    </script>
</x-consumer-dashboard-layout>