<x-consumer-dashboard-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('consumer.dashboard') }}" class="mr-2 bg-primary-100 hover:bg-primary-200 rounded-full p-2 transition-colors">
                <i class="fas fa-arrow-left text-primary-700"></i>
            </a>
            <div>
                <h1 class="text-2xl md:text-3xl font-display font-bold text-gray-800">Place New Order</h1>
                <p class="mt-1 text-gray-500">Request lab tests or blood services</p>
            </div>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="py-6" x-data="orderForm()">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Order Type Selection -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
                <h2 class="text-xl font-medium text-gray-900 mb-6">Select Service Type</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- eMedSample Option -->
                    <div class="relative">
                        <input type="radio" id="order_type_test" name="order_type_selection" value="test" class="peer absolute opacity-0" x-model="orderType" @change="fetchNearbyFacilities">
                        <label for="order_type_test" class="block p-6 bg-white border-2 border-gray-200 rounded-xl cursor-pointer transition-all hover:bg-gray-50 peer-checked:border-primary-500 peer-checked:ring-2 peer-checked:ring-primary-500/20">
                            <div class="flex items-center">
                                <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center mr-4">
                                    <i class="fas fa-vial text-primary-500 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">eMedSample</h3>
                                    <p class="text-sm text-gray-500">Laboratory testing services</p>
                                </div>
                            </div>
                        </label>
                        <div class="absolute top-4 right-4 h-6 w-6 rounded-full bg-primary-500 text-white flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                    </div>
                    
                    <!-- SharedBlood Option -->
                    <div class="relative">
                        <input type="radio" id="order_type_blood" name="order_type_selection" value="blood" class="peer absolute opacity-0" x-model="orderType" @change="fetchNearbyFacilities">
                        <label for="order_type_blood" class="block p-6 bg-white border-2 border-gray-200 rounded-xl cursor-pointer transition-all hover:bg-gray-50 peer-checked:border-accent peer-checked:ring-2 peer-checked:ring-accent/20">
                            <div class="flex items-center">
                                <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center mr-4">
                                    <i class="fas fa-tint text-accent text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">SharedBlood</h3>
                                    <p class="text-sm text-gray-500">Blood donation & requests</p>
                                </div>
                            </div>
                        </label>
                        <div class="absolute top-4 right-4 h-6 w-6 rounded-full bg-accent text-white flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity">
                            <i class="fas fa-check text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Form -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                <form id="order-form" method="POST" action="{{ route('consumer.orders.store') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" id="order_type_input" name="order_type" x-model="orderType">
                    
                    <!-- Common Fields First -->
                    <div x-show="orderType" x-transition>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Select Nearby Facility & Service</h3>
                        
                        <!-- Facility Selection (Dynamic based on Nearby) -->
                        <div class="mb-4">
                            <label for="facility_id" class="block text-sm font-medium text-gray-700 mb-1">Select Facility</label>
                            <select id="facility_id" name="facility_id" required 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 disabled:bg-gray-100"
                                    x-model="selectedFacility" @change="fetchServices" :disabled="loadingFacilities || nearbyFacilities.length === 0">
                                <option value="" x-show="!loadingFacilities">-- Choose a nearby facility --</option>
                                <option value="" x-show="loadingFacilities" disabled>Loading nearby facilities...</option>
                                <template x-for="facility in nearbyFacilities" :key="facility.id">
                                    <option :value="facility.id" x-text="`${facility.name} (${facility.distance.toFixed(1)} km) - ${facility.address.substring(0, 40)}...`"></option>
                                </template>
                            </select>
                            <div x-show="!loadingFacilities && orderType && nearbyFacilities.length === 0">
                                <p class="mt-2 text-sm text-yellow-700">No approved facilities found offering <span x-text="orderType === 'test' ? 'lab services' : 'blood services'"></span> near your location. Please check your profile address or try again later.</p>
                            </div>
                             <div x-show="loadingFacilities">
                                <p class="text-sm text-gray-500 mt-2 flex items-center"><svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Finding nearby facilities...</p>
                            </div>
                            @error('facility_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Service Selection (Dynamic) -->
                        <div x-show="selectedFacility && availableServices.length > 0" x-transition>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Select Service(s)</label>
                            <div class="space-y-3 max-h-60 overflow-y-auto border rounded-md p-3 bg-gray-50">
                                <template x-for="service in availableServices" :key="service.id">
                                    <div class="relative flex items-start p-3 rounded hover:bg-gray-100 transition-colors mb-2">
                                        <div class="flex items-center h-5 mr-3">
                                            <input :id="'service_' + service.id" name="services[]" :value="service.id" type="checkbox" 
                                                   x-model="selectedServices" 
                                                   class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                        </div>
                                        <div class="flex-grow">
                                            <div class="flex justify-between items-start">
                                                <label :for="'service_' + service.id" class="font-medium text-gray-900 block" x-text="service.name"></label>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                                      :class="{
                                                        'bg-green-100 text-green-800': service.availability_status === 'available', 
                                                        'bg-yellow-100 text-yellow-800': service.availability_status === 'limited',
                                                        'bg-red-100 text-red-800': service.availability_status === 'unavailable'
                                                      }">
                                                    <span x-text="service.category === 'SharedBlood' 
                                                        ? service.availability_status 
                                                        : service.turnaround_time || 'No turnaround time specified'"></span>
                                                </span>
                                            </div>
                                            <div class="flex justify-between">
                                                <div>
                                                    <p class="text-gray-500" x-text="formatCurrency(service.price)"></p>
                                                    <p x-show="service.requirements" class="text-sm text-gray-500 italic mt-1">
                                                        <span class="font-medium">Requirements:</span> 
                                                        <span x-text="service.requirements"></span>
                                                    </p>
                                                    <p x-show="service.notes" class="text-sm text-gray-500 mt-1">
                                                        <span x-text="service.notes"></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                             @error('services')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                         <div x-show="selectedFacility && availableServices.length === 0 && !loadingServices">
                             <p class="text-sm text-gray-500 mt-2">No services found for this facility.</p>
                        </div>
                        <div x-show="loadingServices">
                             <p class="text-sm text-gray-500 mt-2 flex items-center"><svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Loading services...</p>
                        </div>
                    </div>
                    
                
                
                    
                    <!-- Logistics Fields -->
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Logistics</h3>
                        <div class="mt-4">
                            <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-1">Pickup/Delivery Address</label>
                            <input type="text" id="delivery_address" name="delivery_address" value="{{ old('delivery_address', Auth::user()->address) }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                             @error('delivery_address')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mt-4">
                            <label for="scheduled_time" class="block text-sm font-medium text-gray-700 mb-1">Preferred Time</label>
                            <input type="datetime-local" id="scheduled_time" name="scheduled_time" value="{{ old('scheduled_time') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <p class="mt-1 text-xs text-gray-500">Optional: Schedule for a later date/time</p>
                             @error('scheduled_time')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Payment Section -->
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Summary</h3>
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <dl class="space-y-2">
                                <div class="flex justify-between text-sm text-gray-600">
                                    <dt>Service Cost:</dt>
                                    <dd x-text="formatCurrency(serviceCost)"></dd>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <dt>Delivery Fee:</dt>
                                    <dd x-text="formatCurrency(deliveryFee)"></dd>
                                </div>
                                <div class="flex justify-between text-lg font-medium text-gray-900 border-t pt-2 mt-2">
                                    <dt>Total Amount:</dt>
                                    <dd x-text="formatCurrency(totalAmount)"></dd>
                                </div>
                            </dl>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                            <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                <label for="payment_card" class="flex items-center border border-gray-300 rounded-lg p-3 cursor-pointer flex-1 peer-checked:border-primary-500">
                                    <input type="radio" id="payment_card" name="payment_method" value="card" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300" x-model="paymentMethod" checked>
                                    <span class="ml-3 text-sm font-medium text-gray-700">Pay with Card</span>
                                </label>
                                <label for="payment_bank" class="flex items-center border border-gray-300 rounded-lg p-3 cursor-pointer flex-1 peer-checked:border-primary-500">
                                    <input type="radio" id="payment_bank" name="payment_method" value="bank" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300" x-model="paymentMethod">
                                    <span class="ml-3 text-sm font-medium text-gray-700">Pay with Bank Transfer</span>
                                </label>
                                <label for="payment_cash" class="flex items-center border border-gray-300 rounded-lg p-3 cursor-pointer flex-1 peer-checked:border-primary-500">
                                    <input type="radio" id="payment_cash" name="payment_method" value="cash" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300" x-model="paymentMethod">
                                    <span class="ml-3 text-sm font-medium text-gray-700">Cash on Delivery</span>
                                </label>
                            </div>
                            @error('payment_method')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Card Payment Fields -->
                        <div x-show="paymentMethod === 'card'" x-transition class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Enter Card Details</h4>
                            <div class="space-y-4">
                                <div>
                                    <label for="card_number" class="block text-sm font-medium text-gray-700">Card Number</label>
                                    <input type="text" id="card_number" name="card_number" x-model="cardDetails.number" @input="validateCardNumber" placeholder="1234 5678 9012 3456" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                    <p x-show="cardErrors.number" class="mt-1 text-sm text-red-600" x-text="cardErrors.number"></p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="card_expiry" class="block text-sm font-medium text-gray-700">Expiry Date (MM/YY)</label>
                                        <input type="text" id="card_expiry" name="card_expiry" x-model="cardDetails.expiry" @input="validateCardExpiry" placeholder="MM/YY" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        <p x-show="cardErrors.expiry" class="mt-1 text-sm text-red-600" x-text="cardErrors.expiry"></p>
                                    </div>
                                    <div>
                                        <label for="card_cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                                        <input type="text" id="card_cvv" name="card_cvv" x-model="cardDetails.cvv" @input="validateCardCvv" placeholder="123" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        <p x-show="cardErrors.cvv" class="mt-1 text-sm text-red-600" x-text="cardErrors.cvv"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bank Transfer Fields -->
                        <div x-show="paymentMethod === 'bank'" x-transition class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Bank Transfer Details</h4>
                            <div x-show="!waitingForTransfer" class="space-y-4">
                                <p class="text-sm text-gray-600">Please transfer the total amount to the following bank account:</p>
                                <div class="bg-white p-4 rounded-md border border-gray-200">
                                    <p><strong>Bank:</strong> GTB Bank</p>
                                    <p><strong>Account Name:</strong> DHR SPACE</p>
                                    <p><strong>Account Number:</strong> 1234567890</p>
                                    <p><strong>Amount:</strong> <span x-text="formatCurrency(totalAmount)"></span></p>
                                </div>
                                <button type="button" @click="initiateBankTransfer" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    I Have Initiated the Transfer
                                </button>
                            </div>
                            <div x-show="waitingForTransfer" class="flex items-center space-x-3">
                                <svg class="animate-spin h-5 w-5 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p class="text-sm text-gray-600">Waiting for your confirmation...</p>
                                <button type="button" @click="confirmBankTransfer" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    I Have Paid
                                </button>
                            </div>
                        </div>

                        <!-- Cash on Delivery Info -->
                        <div x-show="paymentMethod === 'cash'" x-transition class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">You will pay <span x-text="formatCurrency(totalAmount)"></span> in cash upon delivery or service completion.</p>
                        </div>
                    </div>
                    
                    <!-- Submission -->
                    <div class="flex justify-end pt-6">
                        <button type="submit" :disabled="isPaymentProcessing || !isPaymentValid" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:bg-gray-400 disabled:cursor-not-allowed">
                            <span x-show="isPaymentProcessing" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                            <span x-show="!isPaymentProcessing">Place Order (<span x-text="formatCurrency(totalAmount)"></span>)</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function orderForm() {
            return {
                orderType: null, // User selects 'test' or 'blood'
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
                errors: {},
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
                isPaymentValid: true, // Add this missing property
    
                init() {
                    // Initialize with any existing value from old input if form was submitted with errors
                    this.orderType = @json(old('order_type')) || null;
                    this.errors = @json($errors->toArray());
                    
                    // Don't fetch services initially, wait for facility selection
                    // If old facility ID exists, we might need to re-fetch nearby first to populate the list
                    // For simplicity, let's require user interaction first.
                    this.updateCost(); // Initialize cost calculation
                    this.$watch('selectedServices', () => this.updateCost());
                    this.$watch('paymentMethod', () => this.resetPaymentState());
                    
                    // Watch orderType to clear dependent selections
                    this.$watch('orderType', () => {
                        this.selectedFacility = '';
                        this.availableServices = [];
                        this.selectedServices = [];
                        this.nearbyFacilities = []; // Clear previous nearby list
                        
                        // If orderType is set, fetch nearby facilities
                        if (this.orderType) {
                            this.fetchNearbyFacilities();
                        }
                    });
                    
                    // Initialize payment validity check
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

                // Validate card payment fields
                validateCardPayment() {
                    this.validateCardNumber();
                    this.validateCardExpiry();
                    this.validateCardCvv();
                    
                    this.isPaymentValid = !this.cardErrors.number && !this.cardErrors.expiry && !this.cardErrors.cvv;
                },

                // ... keep existing methods ...
                fetchNearbyFacilities() {
                    if (!this.orderType || this.userLatitude === null || this.userLongitude === null) {
                        if (this.userLatitude === null || this.userLongitude === null) {
                            console.warn('User location not available. Cannot fetch nearby facilities.');
                            // Optionally, show a message to the user to update their profile address.
                        }
                        this.nearbyFacilities = [];
                        return;
                    }

                    this.loadingFacilities = true;
                    this.nearbyFacilities = [];
                    this.selectedFacility = ''; // Reset selected facility

                    // Construct the API URL with query parameters
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
                    this.selectedServices = []; // Reset selected services when facility changes
                    // Use the correct API endpoint for facility services
                    const url = `/api/facilities/${this.selectedFacility}/services`; 
                    fetch(url, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(response => {
                            if (!response.ok) { throw new Error(`Network response was not ok (${response.status})`); }
                            return response.json();
                        })
                        .then(data => {
                            // Filter services based on the initially selected orderType and availability
                            this.availableServices = Array.isArray(data) ? data.filter(service => {
                                // Match the service type with the selected order type
                                if (service.type !== this.orderType || !service.is_active) {
                                    return false;
                                }
                                
                                // For blood services, only show available ones
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
                            this.updateCost(); // Update cost after services are loaded/reset
                        });
                },

                // ... existing methods (get selectedServiceObjects, requiredAttributes, updateCost, formatCurrency, payment logic, etc.) ...
                // Ensure updateCost is called appropriately when selections change
                get selectedServiceObjects() {
                    const selectedIds = this.selectedServices.map(id => id.toString());
                    return this.availableServices.filter(s => selectedIds.includes(s.id.toString()));
                },
    
                get requiredAttributes() {
                    let attributes = {};
                    this.selectedServiceObjects.forEach(service => {
                        (service.attributes || []).forEach(attr => {
                            if (!attributes[attr.name]) {
                                attributes[attr.name] = { ...attr };
                            }
                        });
                    });
                    return Object.values(attributes);
                },
    
                get hasSelectedTestService() {
                    // Check based on the *currently available* services for the selected facility
                    return this.availableServices.some(service => service.type === 'test') && this.selectedServices.length > 0;
                },
    
                get hasSelectedBloodService() {
                    // Check based on the *currently available* services for the selected facility
                    return this.availableServices.some(service => service.type === 'blood') && this.selectedServices.length > 0;
                },

                updateCost() {
                    let currentServiceCost = 0;
                    const baseDelivery = 500;
                    this.deliveryFee = 0;
                    let requiresDelivery = false;
    
                    this.selectedServiceObjects.forEach(service => {
                        if (service && service.price) {
                            currentServiceCost += parseFloat(service.price);
                            // Delivery required for any paid service (test or blood request)
                            if (parseFloat(service.price) > 0) { 
                                requiresDelivery = true;
                            }
                        }
                    });
    
                    // Apply delivery fee if any selected service requires it
                    if (requiresDelivery) {
                        this.deliveryFee = baseDelivery;
                    }
    
                    this.serviceCost = currentServiceCost;
                    this.totalAmount = this.serviceCost + this.deliveryFee;
                },

                formatCurrency(amount) {
                    const numAmount = parseFloat(amount);
                    if (isNaN(numAmount)) { return '₦--.--'; }
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
                    
                    // Get the form and submit it
                    const form = document.getElementById('order-form');
                    if (form) {
                        form.submit();
                    } else {
                        console.error("Order form not found!");
                        this.isPaymentProcessing = false;
                    }
                    
                  
                    console.log('Bank transfer confirmed by user. Submitting order form...');
                }
            }
        }
    
        document.addEventListener('alpine:init', () => {
            Alpine.data('orderForm', orderForm);
        });
     
    </script>
    
</x-consumer-dashboard-layout>