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
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Order Type Selection -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
                <h2 class="text-xl font-medium text-gray-900 mb-6">Select Service Type</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- eMedSample Option -->
                    <div class="relative">
                        <input type="radio" id="order_type_test" name="order_type_selection" value="test" class="peer absolute opacity-0">
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
                        <input type="radio" id="order_type_blood" name="order_type_selection" value="blood" class="peer absolute opacity-0">
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
                <form method="POST" action="{{ route('consumer.orders.store') }}" class="space-y-6" x-data="orderForm()">
                    @csrf
                    <input type="hidden" id="order_type_input" name="order_type" x-model="orderType">
                    
                    <!-- Common Fields First -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Select Facility & Service</h3>
                        
                        <!-- Facility Selection -->
                        <div class="mb-4">
                            <label for="facility_id" class="block text-sm font-medium text-gray-700 mb-1">Select Facility</label>
                            <select id="facility_id" name="facility_id" required 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                    x-model="selectedFacility" @change="fetchServices">
                                <option value="">Choose a lab or blood bank...</option>
                                @foreach($facilities as $facility)
                                    <option value="{{ $facility->id }}" {{ old('facility_id') == $facility->id ? 'selected' : '' }}>
                                        {{ $facility->name }} 
                                        @if($facility->address) - {{ Str::limit($facility->address, 50) }} @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('facility_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Service Selection (Dynamic) -->
                        <div x-show="selectedFacility && availableServices.length > 0" x-transition>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Select Service(s)</label>
                            <div class="space-y-3 max-h-60 overflow-y-auto border rounded-md p-3 bg-gray-50">
                                <template x-for="service in filteredServices" :key="service.id">
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <!-- Use service.id as the value, handle single/multiple selection logic if needed -->
                                            <input :id="'service_' + service.id" name="services[]" :value="service.id" type="checkbox" 
                                                   @change="updateCost()" 
                                                   class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label :for="'service_' + service.id" class="font-medium text-gray-700" x-text="service.name"></label>
                                            <p class="text-gray-500" x-text="service.description ? service.description + ' (' + formatCurrency(service.price) + ')' : formatCurrency(service.price)"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                             @error('services') <!-- Updated error key -->
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
                    
                    <!-- Lab Test Notes (Only show if a test service is selected) -->
                    <div id="test_notes_container" x-show="hasSelectedTestService" x-transition>
                         <h3 class="text-lg font-medium text-gray-900">Additional Test Notes</h3>
                         <div>
                            <label for="test_notes" class="block text-sm font-medium text-gray-700 mb-1 sr-only">Additional Test Notes</label>
                            <textarea id="test_notes" name="test_notes" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Any specific instructions or additional tests not listed above">{{ old('test_notes') }}</textarea>
                             @error('test_notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Blood Service Details (Only show if a blood service is selected) -->
                     <div id="blood_details_container" x-show="hasSelectedBloodService" x-transition class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Blood Service Details</h3>
                         <!-- Blood Group -->
                        <div>
                            <label for="blood_group" class="block text-sm font-medium text-gray-700 mb-1">Your Blood Group (if known/donating)</label>
                            <select id="blood_group" name="blood_group" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent">
                                <option value="">Select Blood Group</option>
                                <!-- Options -->
                                 <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                             @error('blood_group')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fields shown only for Blood Request -->
                        <div x-show="selectedServiceType === 'blood_request'" x-transition class="space-y-6">
                             <!-- Units Required -->
                            <div id="blood_units_container">
                                <label for="blood_units" class="block text-sm font-medium text-gray-700 mb-1">Units Required</label>
                                <select id="blood_units" name="blood_units" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent">
                                    <option value="1" {{ old('blood_units') == '1' ? 'selected' : '' }}>1 Unit</option>
                                    <option value="2" {{ old('blood_units') == '2' ? 'selected' : '' }}>2 Units</option>
                                    <option value="3" {{ old('blood_units') == '3' ? 'selected' : '' }}>3 Units</option>
                                    <option value="4" {{ old('blood_units') == '4' ? 'selected' : '' }}>4 Units</option>
                                    <option value="5" {{ old('blood_units') == '5' ? 'selected' : '' }}>5+ Units</option>
                                </select>
                                @error('blood_units')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Urgency Level -->
                             <div id="blood_urgency_container">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Urgency Level</label>
                                <div class="grid grid-cols-3 gap-3">
                                    <!-- Urgency Radios -->
                                     <div class="relative">
                                        <input type="radio" id="urgency_normal" name="urgency" value="normal" class="peer absolute opacity-0" {{ old('urgency', 'normal') == 'normal' ? 'checked' : '' }}>
                                        <label for="urgency_normal" class="block p-2 text-center bg-white border border-gray-200 rounded-lg cursor-pointer transition-all hover:bg-gray-50 peer-checked:border-green-500 peer-checked:bg-green-50">
                                            <span class="text-sm font-medium text-gray-900">Normal</span>
                                        </label>
                                    </div>
                                    <div class="relative">
                                        <input type="radio" id="urgency_urgent" name="urgency" value="urgent" class="peer absolute opacity-0" {{ old('urgency') == 'urgent' ? 'checked' : '' }}>
                                        <label for="urgency_urgent" class="block p-2 text-center bg-white border border-gray-200 rounded-lg cursor-pointer transition-all hover:bg-gray-50 peer-checked:border-yellow-500 peer-checked:bg-yellow-50">
                                            <span class="text-sm font-medium text-gray-900">Urgent</span>
                                        </label>
                                    </div>
                                    <div class="relative">
                                        <input type="radio" id="urgency_emergency" name="urgency" value="emergency" class="peer absolute opacity-0" {{ old('urgency') == 'emergency' ? 'checked' : '' }}>
                                        <label for="urgency_emergency" class="block p-2 text-center bg-white border border-gray-200 rounded-lg cursor-pointer transition-all hover:bg-gray-50 peer-checked:border-red-500 peer-checked:bg-red-50">
                                            <span class="text-sm font-medium text-gray-900">Emergency</span>
                                        </label>
                                    </div>
                                </div>
                                @error('urgency')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Purpose -->
                            <div id="blood_purpose_container">
                                <label for="blood_purpose" class="block text-sm font-medium text-gray-700 mb-1">Purpose</label>
                                <textarea id="blood_purpose" name="blood_purpose" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent" placeholder="Brief description of why the blood is needed">{{ old('blood_purpose') }}</textarea>
                                @error('blood_purpose')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                   

                    <!-- Logistics Fields -->
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Logistics</h3>
                        
                        <!-- Delivery Address -->
                        <div class="mt-4">
                            <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-1">Delivery Address</label>
                            <input type="text" id="delivery_address" name="delivery_address" value="{{ old('delivery_address', Auth::user()->address) }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                             @error('delivery_address')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Scheduled Time -->
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
                                <label for="payment_paystack" class="flex items-center border border-gray-300 rounded-lg p-3 cursor-pointer flex-1 peer-checked:border-primary-500">
                                    <input type="radio" id="payment_paystack" name="payment_method" value="paystack" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300" checked>
                                    <span class="ml-3 text-sm font-medium text-gray-700">Pay with Paystack (Card/Bank)</span>
                                </label>
                                <label for="payment_cash" class="flex items-center border border-gray-300 rounded-lg p-3 cursor-pointer flex-1 peer-checked:border-primary-500">
                                    <input type="radio" id="payment_cash" name="payment_method" value="cash" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300">
                                    <span class="ml-3 text-sm font-medium text-gray-700">Pay with Cash (on Delivery/Service)</span>
                                </label>
                            </div>
                            @error('payment_method')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Submission -->
                    <div class="flex justify-end pt-6">
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Place Order (<span x-text="formatCurrency(totalAmount)"></span>)
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function orderForm() {
            return {
                orderType: null, // Will be set based on selected service type
                selectedFacility: '{{ old("facility_id") }}' || '',
                availableServices: [],
                selectedServices: [], // Store IDs of selected services
                loadingServices: false,
                serviceCost: 0,
                deliveryFee: 0, // Delivery fee depends on service type
                totalAmount: 0,
                
                init() {
                    if (this.selectedFacility) {
                        this.fetchServices();
                    }
                },

                get filteredServices() {
                    // Determine the overall order type based on selected services
                    let containsTest = false;
                    let containsBlood = false;
                    this.selectedServiceType = null; // Reset

                    const selectedServiceObjects = this.availableServices.filter(s => this.selectedServices.includes(s.id.toString()));
                    
                    selectedServiceObjects.forEach(s => {
                        if (s.type === 'test') containsTest = true;
                        if (s.type === 'blood_request' || s.type === 'blood_donation') containsBlood = true;
                    });

                    if (containsTest && containsBlood) {
                        // Handle mixed order? For now, let's assume one type per order
                        // Maybe prioritize based on first selected? Or show error?
                        // We'll implicitly set based on first selected service for now
                        if (selectedServiceObjects.length > 0) {
                             this.orderType = selectedServiceObjects[0].type === 'test' ? 'test' : 'blood';
                             this.selectedServiceType = selectedServiceObjects[0].type; 
                        }
                       
                    } else if (containsTest) {
                        this.orderType = 'test';
                        this.selectedServiceType = 'test'; 
                    } else if (containsBlood) {
                        this.orderType = 'blood';
                         // Determine specific blood type (request/donate) if needed for UI
                         if (selectedServiceObjects.length > 0) {
                            this.selectedServiceType = selectedServiceObjects[0].type;
                        }
                    } else {
                        this.orderType = null;
                        this.selectedServiceType = null;
                    }
                    
                    // Return all available services - filtering happens in the template if needed
                     return this.availableServices;
                },
                
                get hasSelectedTestService() {
                    return this.selectedServices.some(id => {
                        const service = this.availableServices.find(s => s.id.toString() === id);
                        return service && service.type === 'test';
                    });
                },

                get hasSelectedBloodService() {
                     return this.selectedServices.some(id => {
                        const service = this.availableServices.find(s => s.id.toString() === id);
                        return service && (service.type === 'blood_request' || service.type === 'blood_donation');
                    });
                },

                fetchServices() {
                    if (!this.selectedFacility) {
                        this.availableServices = [];
                        this.selectedServices = [];
                        this.updateCost();
                        return;
                    }
                    this.loadingServices = true;
                    this.availableServices = []; // Clear previous services
                    this.selectedServices = [];
                    console.log(`Fetching services for facility ID: ${this.selectedFacility}`); // Log: Facility ID
                    
                    // Construct the URL correctly 
                    const url = `/api/facilities/${this.selectedFacility}/services`; 
                    console.log(`API URL: ${url}`); // Log: URL
                    
                    fetch(url, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest', // Important for Laravel API routes
                            // Add CSRF token if your API route requires it within the web middleware group
                            // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                        }
                    })
                        .then(response => {
                            console.log('API Response Status:', response.status); // Log: Status
                            if (!response.ok) {
                                console.error('API response error:', response);
                                throw new Error(`Network response was not ok (${response.status})`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Received data:', data); // Log: Received Data
                            this.availableServices = Array.isArray(data) ? data : []; // Ensure it's an array
                            console.log('Assigned availableServices:', this.availableServices); // Log: Assigned Data
                            this.updateCost(); // Recalculate cost after fetching
                        })
                        .catch(error => {
                            console.error('Error fetching services:', error);
                            this.availableServices = []; // Clear services on error
                            this.updateCost(); 
                        })
                        .finally(() => {
                            this.loadingServices = false;
                        });
                },

                updateCost() {
                    let currentServiceCost = 0;
                    const baseDelivery = 500;
                    this.deliveryFee = 0; // Reset delivery fee
                    let requiresDelivery = false;

                    // Re-query selected service checkboxes directly inside updateCost
                    const selectedCheckboxes = document.querySelectorAll('input[name="services[]"]:checked');
                    this.selectedServices = Array.from(selectedCheckboxes).map(cb => cb.value);

                    this.selectedServices.forEach(serviceId => {
                        const service = this.availableServices.find(s => s.id.toString() === serviceId);
                        if (service) {
                            currentServiceCost += parseFloat(service.price);
                            // Assume tests and blood requests require delivery, donations might not
                            if (service.type === 'test' || service.type === 'blood_request') {
                                requiresDelivery = true;
                            }
                        }
                    });
                    
                    if(requiresDelivery) {
                        this.deliveryFee = baseDelivery;
                    }

                    this.serviceCost = currentServiceCost;
                    this.totalAmount = this.serviceCost + this.deliveryFee;
                },
                
                formatCurrency(amount) {
                    // Handle potential non-numeric values gracefully
                    const numAmount = parseFloat(amount);
                    if (isNaN(numAmount)) {
                        return '₦--.--'; // Or some placeholder
                    }
                    return '₦' + numAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            }
        }

        // Link the Alpine.js data function to the form section
        document.addEventListener('alpine:init', () => {
            Alpine.data('orderForm', orderForm);
        });

        // Existing logic for showing/hiding form sections based on radio buttons
        document.addEventListener('DOMContentLoaded', function() {
            const orderTypeRadios = document.querySelectorAll('input[name="order_type_selection"]');
            const orderTypeInput = document.getElementById('order_type_input');
            const testForm = document.getElementById('test_form');
            const bloodForm = document.getElementById('blood_form');
            
            const bloodServiceRadios = document.querySelectorAll('input[name="blood_service"]');
            const bloodUnitsContainer = document.getElementById('blood_units_container');
            const bloodUrgencyContainer = document.getElementById('blood_urgency_container');
            const bloodPurposeContainer = document.getElementById('blood_purpose_container');

            function toggleForms(selectedType) {
                // This function is now handled by Alpine x-model and $watch
                // Keeping it for potential future use if Alpine is removed
                /*
                orderTypeInput.value = selectedType;
                if (selectedType === 'test') {
                    testForm.style.display = 'block';
                    bloodForm.style.display = 'none';
                } else if (selectedType === 'blood') {
                    testForm.style.display = 'none';
                    bloodForm.style.display = 'block';
                } else {
                    testForm.style.display = 'none';
                    bloodForm.style.display = 'none';
                }
                */
            }
            
            function toggleBloodRequestFields(selectedService) {
                 // This function is now handled by Alpine x-show
                 /*
                if (selectedService === 'request') {
                    bloodUnitsContainer.style.display = 'block';
                    bloodUrgencyContainer.style.display = 'block';
                    bloodPurposeContainer.style.display = 'block';
                } else {
                    bloodUnitsContainer.style.display = 'none';
                    bloodUrgencyContainer.style.display = 'none';
                    bloodPurposeContainer.style.display = 'none';
                }
                */
            }

            // Event listeners for order type selection
            orderTypeRadios.forEach(radio => {
                radio.addEventListener('change', (event) => {
                    // Handled by Alpine x-model and $watch
                });
            });
            
            // Event listeners for blood service type selection
            bloodServiceRadios.forEach(radio => {
                radio.addEventListener('change', (event) => {
                   // Handled by Alpine x-model and $watch
                });
            });
        });
    </script>
    
</x-consumer-dashboard-layout>
