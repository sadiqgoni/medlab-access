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
                <form method="POST" action="{{ route('consumer.orders.store') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" id="order_type_input" name="order_type" value="{{ old('order_type', request('type')) }}">
                    
                    <!-- Lab Test Form (shown/hidden based on selection) -->
                    <div id="test_form" class="space-y-6 hidden">
                        <h3 class="text-lg font-medium text-gray-900">Lab Test Details</h3>
                        
                        <!-- Test Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Select Tests</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="test_fbc" name="tests[]" value="fbc" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="test_fbc" class="font-medium text-gray-700">Full Blood Count</label>
                                        <p class="text-gray-500">Complete blood cell analysis</p>
                                    </div>
                                </div>
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="test_glucose" name="tests[]" value="glucose" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="test_glucose" class="font-medium text-gray-700">Blood Glucose</label>
                                        <p class="text-gray-500">Blood sugar level test</p>
                                    </div>
                                </div>
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="test_lipid" name="tests[]" value="lipid" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="test_lipid" class="font-medium text-gray-700">Lipid Profile</label>
                                        <p class="text-gray-500">Cholesterol and triglycerides</p>
                                    </div>
                                </div>
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="test_liver" name="tests[]" value="liver" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="test_liver" class="font-medium text-gray-700">Liver Function</label>
                                        <p class="text-gray-500">Liver enzyme and protein tests</p>
                                    </div>
                                </div>
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="test_malaria" name="tests[]" value="malaria" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="test_malaria" class="font-medium text-gray-700">Malaria Parasite</label>
                                        <p class="text-gray-500">Malaria parasite detection</p>
                                    </div>
                                </div>
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="test_kidney" name="tests[]" value="kidney" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="test_kidney" class="font-medium text-gray-700">Kidney Function</label>
                                        <p class="text-gray-500">Kidney health assessment</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Additional Test Notes -->
                        <div>
                            <label for="test_notes" class="block text-sm font-medium text-gray-700 mb-1">Additional Test Notes</label>
                            <textarea id="test_notes" name="test_notes" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Any specific instructions or additional tests not listed above"></textarea>
                        </div>
                    </div>
                    
                    <!-- Blood Service Form (shown/hidden based on selection) -->
                    <div id="blood_form" class="space-y-6 hidden">
                        <h3 class="text-lg font-medium text-gray-900">Blood Service Details</h3>
                        
                        <!-- Service Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="radio" id="blood_service_donate" name="blood_service" value="donate" class="peer absolute opacity-0">
                                    <label for="blood_service_donate" class="block p-4 bg-white border border-gray-200 rounded-lg cursor-pointer transition-all hover:bg-gray-50 peer-checked:border-accent peer-checked:ring-2 peer-checked:ring-accent/20">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-heart text-accent"></i>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900">Donate Blood</h4>
                                                <p class="text-xs text-gray-500">I want to donate blood</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="radio" id="blood_service_request" name="blood_service" value="request" class="peer absolute opacity-0">
                                    <label for="blood_service_request" class="block p-4 bg-white border border-gray-200 rounded-lg cursor-pointer transition-all hover:bg-gray-50 peer-checked:border-accent peer-checked:ring-2 peer-checked:ring-accent/20">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-tint text-accent"></i>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900">Request Blood</h4>
                                                <p class="text-xs text-gray-500">I need blood</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Blood Group -->
                        <div>
                            <label for="blood_group" class="block text-sm font-medium text-gray-700 mb-1">Blood Group</label>
                            <select id="blood_group" name="blood_group" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent">
                                <option value="">Select Blood Group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                        
                        <!-- Units Required (for request) -->
                        <div id="blood_units_container" class="hidden">
                            <label for="blood_units" class="block text-sm font-medium text-gray-700 mb-1">Units Required</label>
                            <select id="blood_units" name="blood_units" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent">
                                <option value="1">1 Unit</option>
                                <option value="2">2 Units</option>
                                <option value="3">3 Units</option>
                                <option value="4">4 Units</option>
                                <option value="5">5+ Units</option>
                            </select>
                        </div>
                        
                        <!-- Urgency Level (for request) -->
                        <div id="blood_urgency_container" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Urgency Level</label>
                            <div class="grid grid-cols-3 gap-3">
                                <div class="relative">
                                    <input type="radio" id="urgency_normal" name="urgency" value="normal" class="peer absolute opacity-0">
                                    <label for="urgency_normal" class="block p-2 text-center bg-white border border-gray-200 rounded-lg cursor-pointer transition-all hover:bg-gray-50 peer-checked:border-green-500 peer-checked:bg-green-50">
                                        <span class="text-sm font-medium text-gray-900">Normal</span>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="radio" id="urgency_urgent" name="urgency" value="urgent" class="peer absolute opacity-0">
                                    <label for="urgency_urgent" class="block p-2 text-center bg-white border border-gray-200 rounded-lg cursor-pointer transition-all hover:bg-gray-50 peer-checked:border-yellow-500 peer-checked:bg-yellow-50">
                                        <span class="text-sm font-medium text-gray-900">Urgent</span>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="radio" id="urgency_emergency" name="urgency" value="emergency" class="peer absolute opacity-0">
                                    <label for="urgency_emergency" class="block p-2 text-center bg-white border border-gray-200 rounded-lg cursor-pointer transition-all hover:bg-gray-50 peer-checked:border-red-500 peer-checked:bg-red-50">
                                        <span class="text-sm font-medium text-gray-900">Emergency</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Purpose (for request) -->
                        <div id="blood_purpose_container" class="hidden">
                            <label for="blood_purpose" class="block text-sm font-medium text-gray-700 mb-1">Purpose</label>
                            <textarea id="blood_purpose" name="blood_purpose" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent" placeholder="Brief description of why the blood is needed"></textarea>
                        </div>
                    </div>
                    
                    <!-- Common Fields -->
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Facility & Logistics</h3>
                        
                        <!-- Facility Selection -->
                        <div>
                            <label for="facility_id" class="block text-sm font-medium text-gray-700 mb-1">Select Facility</label>
                            <select id="facility_id" name="facility_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="">Choose a lab or blood bank</option>
                                <!-- Populate with available facilities based on location/service -->
                                <option value="1">ATBUTH Laboratory</option>
                                <option value="2">Bauchi Specialist Hospital Blood Bank</option>
                                <option value="3">General Hospital Jos Lab</option>
                            </select>
                        </div>
                        
                        <!-- Delivery Address -->
                        <div class="mt-4">
                            <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-1">Delivery Address</label>
                            <input type="text" id="delivery_address" name="delivery_address" value="{{ Auth::user()->address }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                        
                        <!-- Scheduled Time -->
                        <div class="mt-4">
                            <label for="scheduled_time" class="block text-sm font-medium text-gray-700 mb-1">Preferred Time</label>
                            <input type="datetime-local" id="scheduled_time" name="scheduled_time" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <p class="mt-1 text-xs text-gray-500">Optional: Schedule for a later date/time</p>
                        </div>
                    </div>
                    
                    <!-- Payment Section -->
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Summary</h3>
                        <!-- Add estimated cost display here -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <dl class="space-y-2">
                                <div class="flex justify-between text-sm text-gray-600">
                                    <dt>Service Cost:</dt>
                                    <dd id="service_cost">₦0.00</dd>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <dt>Delivery Fee:</dt>
                                    <dd id="delivery_fee">₦500.00</dd>
                                </div>
                                <div class="flex justify-between text-lg font-medium text-gray-900 border-t pt-2 mt-2">
                                    <dt>Total Amount:</dt>
                                    <dd id="total_amount">₦500.00</dd>
                                </div>
                            </dl>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                            <div class="flex items-center space-x-4">
                                <label for="payment_paystack" class="flex items-center border border-gray-300 rounded-lg p-3 cursor-pointer flex-1">
                                    <input type="radio" id="payment_paystack" name="payment_method" value="paystack" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300" checked>
                                    <span class="ml-3 text-sm font-medium text-gray-700">Pay with Paystack (Card/Bank)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submission -->
                    <div class="flex justify-end pt-6">
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Place Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
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
                orderTypeInput.value = selectedType;
                if (selectedType === 'test') {
                    testForm.classList.remove('hidden');
                    bloodForm.classList.add('hidden');
                } else if (selectedType === 'blood') {
                    testForm.classList.add('hidden');
                    bloodForm.classList.remove('hidden');
                } else {
                    testForm.classList.add('hidden');
                    bloodForm.classList.add('hidden');
                }
            }
            
            function toggleBloodRequestFields(selectedService) {
                if (selectedService === 'request') {
                    bloodUnitsContainer.classList.remove('hidden');
                    bloodUrgencyContainer.classList.remove('hidden');
                    bloodPurposeContainer.classList.remove('hidden');
                } else {
                    bloodUnitsContainer.classList.add('hidden');
                    bloodUrgencyContainer.classList.add('hidden');
                    bloodPurposeContainer.classList.add('hidden');
                }
            }

            // Initial setup based on old input or query param
            const initialType = orderTypeInput.value;
            if (initialType) {
                toggleForms(initialType);
                const typeRadio = document.getElementById(`order_type_${initialType}`);
                if (typeRadio) typeRadio.checked = true;
            }
            
            // Event listeners for order type selection
            orderTypeRadios.forEach(radio => {
                radio.addEventListener('change', (event) => {
                    toggleForms(event.target.value);
                });
            });
            
            // Event listeners for blood service type selection
            bloodServiceRadios.forEach(radio => {
                radio.addEventListener('change', (event) => {
                    toggleBloodRequestFields(event.target.value);
                });
            });
            
             // Initial setup for blood request fields
            const initialBloodService = document.querySelector('input[name="blood_service"]:checked');
            if (initialBloodService) {
                toggleBloodRequestFields(initialBloodService.value);
            }
            
            // TODO: Implement dynamic cost calculation
        });
    </script>
    
</x-consumer-dashboard-layout>
