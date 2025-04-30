@extends('layouts.app')

@section('content')
<!-- Create Order Page -->
<div class="bg-neutral-light min-h-screen pt-20 pb-12">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center">
                        <a href="{{ route('consumer.dashboard') }}" class="mr-2 bg-white/10 hover:bg-white/20 rounded-full p-2 transition-colors">
                            <i class="fas fa-arrow-left text-white"></i>
                        </a>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-display font-bold">Place New Order</h1>
                            <p class="mt-1 text-primary-100">Request lab tests or blood services</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Order Type Selection -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
                <h2 class="text-xl font-medium text-gray-900 mb-6">Select Service Type</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- eMedSample Option -->
                    <div class="relative">
                        <input type="radio" id="order_type_test" name="order_type" value="test" class="peer absolute opacity-0">
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
                        <input type="radio" id="order_type_blood" name="order_type" value="blood" class="peer absolute opacity-0">
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
                    <div id="test_form" class="space-y-6">
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
                        <div id="blood_units_container">
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
                        <div id="blood_urgency_container">
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
                        <div id="blood_purpose_container">
                            <label for="blood_purpose" class="block text-sm font-medium text-gray-700 mb-1">Purpose</label>
                            <textarea id="blood_purpose" name="blood_purpose" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent" placeholder="Brief description of why the blood is needed"></textarea>
                        </div>
                    </div>
                    
                    <!-- Common Fields -->
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Facility & Logistics</h3>
                        
                        <!-- Facility Selection -->
                        <div class="mb-4">
                            <label for="facility_id" class="block text-sm font-medium text-gray-700 mb-1">Select Facility</label>
                            <select id="facility_id" name="facility_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="" disabled selected>-- Select Facility --</option>
                                @foreach ($facilities as $facility)
                                    <option value="{{ $facility->id }}" {{ old('facility_id') == $facility->id ? 'selected' : '' }}>
                                        {{ $facility->name }} ({{ $facility->address }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Address -->
                        <div class="mb-4">
                            <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-1">Delivery/Service Address</label>
                            <textarea id="delivery_address" name="delivery_address" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Enter the address where the service/delivery is needed">{{ old('delivery_address', Auth::user()->address) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Your registered address will be used if left blank.</p>
                        </div>
                        
                        <!-- Scheduling -->
                        <div class="mb-4">
                            <label for="pickup_scheduled_time" class="block text-sm font-medium text-gray-700 mb-1">Preferred Date/Time (Optional)</label>
                            <input type="datetime-local" id="pickup_scheduled_time" name="pickup_scheduled_time" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                    </div>
                    
                    <!-- Payment Section -->
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Details</h3>
                        
                        <!-- Order Summary -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Order Summary</h4>
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Service Fee</span>
                                    <span class="text-gray-900">₦4,500.00</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Logistics Fee</span>
                                    <span class="text-gray-900">₦500.00</span>
                                </div>
                                <div class="border-t border-gray-200 my-2"></div>
                                <div class="flex justify-between text-sm font-medium">
                                    <span class="text-gray-900">Total Amount</span>
                                    <span class="text-gray-900">₦5,000.00</span>
                                </div>
                            </div>
                            <input type="hidden" name="total_amount" value="5000">
                        </div>
                        
                        <!-- Payment Method -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="relative">
                                    <input type="radio" id="payment_card" name="payment_method" value="card" class="peer absolute opacity-0" checked>
                                    <label for="payment_card" class="block p-4 bg-white border border-gray-200 rounded-lg cursor-pointer transition-all hover:bg-gray-50 peer-checked:border-primary-500 peer-checked:ring-2 peer-checked:ring-primary-500/20">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-credit-card text-primary-500"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">Card Payment</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="radio" id="payment_transfer" name="payment_method" value="transfer" class="peer absolute opacity-0">
                                    <label for="payment_transfer" class="block p-4 bg-white border border-gray-200 rounded-lg cursor-pointer transition-all hover:bg-gray-50 peer-checked:border-primary-500 peer-checked:ring-2 peer-checked:ring-primary-500/20">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-university text-primary-500"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">Bank Transfer</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="radio" id="payment_cash" name="payment_method" value="cash" class="peer absolute opacity-0">
                                    <label for="payment_cash" class="block p-4 bg-white border border-gray-200 rounded-lg cursor-pointer transition-all hover:bg-gray-50 peer-checked:border-primary-500 peer-checked:ring-2 peer-checked:ring-primary-500/20">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-money-bill-wave text-primary-500"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-900">Cash on Delivery</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Secure payments powered by Paystack</p>
                        </div>
                        
                        <!-- Terms & Conditions -->
                        <div class="mb-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" name="terms" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500" required>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="font-medium text-gray-700">I agree to the terms and conditions</label>
                                    <p class="text-gray-500">By placing this order, you agree to our <a href="#" class="text-primary-600 hover:text-primary-500">Terms of Service</a> and <a href="#" class="text-primary-600 hover:text-primary-500">Privacy Policy</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-gray-200 flex justify-end">
                        <button type="submit" class="liquid-button inline-flex items-center px-6 py-3 bg-primary-500 border border-transparent rounded-full shadow-lg shadow-primary-500/20 text-base font-medium text-white hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <span>Place Order</span>
                            <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Custom JS for Order Form -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const orderTypeRadios = document.querySelectorAll('input[name="order_type"]');
        const orderTypeInput = document.getElementById('order_type_input');
        const testForm = document.getElementById('test_form');
        const bloodForm = document.getElementById('blood_form');
        const bloodServiceRadios = document.querySelectorAll('input[name="blood_service"]');
        const bloodUnitsContainer = document.getElementById('blood_units_container');
        const bloodUrgencyContainer = document.getElementById('blood_urgency_container');
        const bloodPurposeContainer = document.getElementById('blood_purpose_container');
        
        // Set initial state based on URL parameter or previous selection
        const initialType = orderTypeInput.value;
        if (initialType === 'test') {
            document.getElementById('order_type_test').checked = true;
            testForm.classList.remove('hidden');
            bloodForm.classList.add('hidden');
        } else if (initialType === 'blood') {
            document.getElementById('order_type_blood').checked = true;
            bloodForm.classList.remove('hidden');
            testForm.classList.add('hidden');
        }
        
        // Handle order type change
        orderTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                orderTypeInput.value = this.value;
                
                if (this.value === 'test') {
                    testForm.classList.remove('hidden');
                    bloodForm.classList.add('hidden');
                } else if (this.value === 'blood') {
                    bloodForm.classList.remove('hidden');
                    testForm.classList.add('hidden');
                }
            });
        });
        
        // Handle blood service type change
        bloodServiceRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'donate') {
                    bloodUnitsContainer.classList.add('hidden');
                    bloodUrgencyContainer.classList.add('hidden');
                    bloodPurposeContainer.classList.add('hidden');
                } else if (this.value === 'request') {
                    bloodUnitsContainer.classList.remove('hidden');
                    bloodUrgencyContainer.classList.remove('hidden');
                    bloodPurposeContainer.classList.remove('hidden');
                }
            });
        });
        
        // Set default blood service type
        if (document.getElementById('blood_service_request')) {
            document.getElementById('blood_service_request').checked = true;
            bloodUnitsContainer.classList.remove('hidden');
            bloodUrgencyContainer.classList.remove('hidden');
            bloodPurposeContainer.classList.remove('hidden');
        }
    });
</script>
@endsection
