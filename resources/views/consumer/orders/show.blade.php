@extends('layouts.app')

@section('content')
<!-- Order Details Page -->
<div class="bg-neutral-light min-h-screen pt-20 pb-12">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center">
                        <a href="{{ route('consumer.orders.index') }}" class="mr-2 bg-white/10 hover:bg-white/20 rounded-full p-2 transition-colors">
                            <i class="fas fa-arrow-left text-white"></i>
                        </a>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-display font-bold">Order #{{ $order->id }}</h1>
                            <p class="mt-1 text-primary-100">Placed on {{ $order->created_at->format('F j, Y, g:i a') }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    @if($order->status == 'results_ready')
                        <a href="#" class="liquid-button bg-secondary-500 hover:bg-secondary-600 text-white px-4 py-2 rounded-full text-sm font-medium flex items-center transition-all duration-300 shadow-lg shadow-secondary-500/20">
                            <i class="fas fa-download mr-2"></i>
                            <span>Download Results</span>
                        </a>
                    @endif
                    <button class="liquid-button bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-full text-sm font-medium flex items-center transition-all duration-300">
                        <i class="fas fa-print mr-2"></i>
                        <span>Print Details</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Order Status -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center">
                    <div class="mr-4">
                        @if($order->order_type == 'test')
                            <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center">
                                <i class="fas fa-vial text-primary-500 text-xl"></i>
                            </div>
                        @else
                            <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center">
                                <i class="fas fa-tint text-accent text-xl"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-xl font-medium text-gray-900">
                            {{ $order->order_type == 'test' ? 'Lab Test Order' : 'Blood Service Order' }}
                        </h2>
                        <p class="text-gray-500">{{ $order->facility?->name ?? 'N/A' }}</p>
                    </div>
                </div>
                <div>
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        @switch($order->status)
                            @case('pending') bg-yellow-100 text-yellow-800 @break
                            @case('accepted')
                            @case('processing')
                            @case('sample_collected')
                            @case('in_transit')
                            @case('delivered') bg-blue-100 text-blue-800 @break
                            @case('results_ready') bg-purple-100 text-purple-800 @break
                            @case('completed') bg-green-100 text-green-800 @break
                            @case('cancelled') bg-red-100 text-red-800 @break
                            @default bg-gray-100 text-gray-800 @break
                        @endswitch
                    ">
                        {{ ucwords(str_replace('_', ' ', $order->status)) }}
                    </span>
                </div>
            </div>
            
            <!-- Order Timeline -->
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Order Timeline</h3>
                <div class="relative">
                    <!-- Progress Bar -->
                    <div class="absolute left-5 ml-px top-5 h-full w-0.5 bg-gray-200"></div>
                    
                    <!-- Timeline Items -->
                    <div class="space-y-8">
                        <!-- Order Placed -->
                        <div class="relative flex items-start">
                            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center z-10">
                                <i class="fas fa-check text-green-500"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Order Placed</h4>
                                <p class="text-xs text-gray-500">{{ $order->created_at->format('F j, Y, g:i a') }}</p>
                                <p class="mt-1 text-sm text-gray-600">Your order has been received and is being processed.</p>
                            </div>
                        </div>
                        
                        <!-- Order Accepted -->
                        <div class="relative flex items-start">
                            <div class="h-10 w-10 rounded-full {{ $order->status == 'pending' ? 'bg-gray-100' : 'bg-green-100' }} flex items-center justify-center z-10">
                                <i class="fas {{ $order->status == 'pending' ? 'fa-clock text-gray-400' : 'fa-check text-green-500' }}"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Order Accepted</h4>
                                <p class="text-xs text-gray-500">{{ $order->status != 'pending' ? 'March 15, 2023, 10:30 am' : 'Pending' }}</p>
                                <p class="mt-1 text-sm text-gray-600">{{ $order->status != 'pending' ? 'Your order has been accepted by the facility.' : 'Waiting for facility to accept your order.' }}</p>
                            </div>
                        </div>
                        
                        <!-- Sample Collection / Blood Processing -->
                        <div class="relative flex items-start">
                            <div class="h-10 w-10 rounded-full {{ in_array($order->status, ['pending', 'accepted']) ? 'bg-gray-100' : 'bg-green-100' }} flex items-center justify-center z-10">
                                <i class="fas {{ in_array($order->status, ['pending', 'accepted']) ? 'fa-clock text-gray-400' : 'fa-check text-green-500' }}"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">
                                    {{ $order->order_type == 'test' ? 'Sample Collection' : 'Blood Processing' }}
                                </h4>
                                <p class="text-xs text-gray-500">{{ in_array($order->status, ['pending', 'accepted']) ? 'Pending' : 'March 15, 2023, 11:45 am' }}</p>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ in_array($order->status, ['pending', 'accepted']) ? 
                                        ($order->order_type == 'test' ? 'Waiting for sample collection.' : 'Waiting for blood processing.') : 
                                        ($order->order_type == 'test' ? 'Your sample has been collected.' : 'Your blood request is being processed.') }}
                                </p>
                            </div>
                        </div>
                        
                        <!-- Testing / Delivery -->
                        <div class="relative flex items-start">
                            <div class="h-10 w-10 rounded-full {{ in_array($order->status, ['pending', 'accepted', 'processing', 'sample_collected']) ? 'bg-gray-100' : 'bg-green-100' }} flex items-center justify-center z-10">
                                <i class="fas {{ in_array($order->status, ['pending', 'accepted', 'processing', 'sample_collected']) ? 'fa-clock text-gray-400' : 'fa-check text-green-500' }}"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">
                                    {{ $order->order_type == 'test' ? 'Testing in Progress' : 'Delivery in Progress' }}
                                </h4>
                                <p class="text-xs text-gray-500">{{ in_array($order->status, ['pending', 'accepted', 'processing', 'sample_collected']) ? 'Pending' : 'March 15, 2023, 2:30 pm' }}</p>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ in_array($order->status, ['pending', 'accepted', 'processing', 'sample_collected']) ? 
                                        ($order->order_type == 'test' ? 'Your sample will be tested soon.' : 'Your blood will be delivered soon.') : 
                                        ($order->order_type == 'test' ? 'Your sample is being tested.' : 'Your blood is being delivered.') }}
                                </p>
                            </div>
                        </div>
                        
                        <!-- Results / Completion -->
                        <div class="relative flex items-start">
                            <div class="h-10 w-10 rounded-full {{ in_array($order->status, ['pending', 'accepted', 'processing', 'sample_collected', 'in_transit', 'delivered']) ? 'bg-gray-100' : 'bg-green-100' }} flex items-center justify-center z-10">
                                <i class="fas {{ in_array($order->status, ['pending', 'accepted', 'processing', 'sample_collected', 'in_transit', 'delivered']) ? 'fa-clock text-gray-400' : 'fa-check text-green-500' }}"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">
                                    {{ $order->order_type == 'test' ? 'Results Ready' : 'Delivery Completed' }}
                                </h4>
                                <p class="text-xs text-gray-500">{{ in_array($order->status, ['pending', 'accepted', 'processing', 'sample_collected', 'in_transit', 'delivered']) ? 'Pending' : 'March 16, 2023, 9:15 am' }}</p>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ in_array($order->status, ['pending', 'accepted', 'processing', 'sample_collected', 'in_transit', 'delivered']) ? 
                                        ($order->order_type == 'test' ? 'Your results will be available soon.' : 'Your delivery will be completed soon.') : 
                                        ($order->order_type == 'test' ? 'Your test results are ready.' : 'Your blood has been delivered successfully.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Order Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Order Information -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Order Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Order Details -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-4">Order Details</h4>
                            <dl class="space-y-3">
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Order ID</dt>
                                    <dd class="text-sm text-gray-900 font-medium">#{{ $order->id }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Order Type</dt>
                                    <dd class="text-sm text-gray-900">{{ ucfirst($order->order_type) }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Date Placed</dt>
                                    <dd class="text-sm text-gray-900">{{ $order->created_at->format('F j, Y, g:i a') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Facility</dt>
                                    <dd class="text-sm text-gray-900">{{ $order->facility?->name ?? 'N/A' }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Assigned Biker</dt>
                                    <dd class="text-sm text-gray-900">{{ $order->biker?->name ?? 'Not Assigned Yet' }}</dd>
                                </div>
                            </dl>
                        </div>
                        
                        <!-- Payment Information -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-4">Payment Information</h4>
                            <dl class="space-y-3">
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Total Amount</dt>
                                    <dd class="text-sm text-gray-900 font-medium">₦{{ number_format($order->total_amount, 2) }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Payment Status</dt>
                                    <dd class="text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Payment Method</dt>
                                    <dd class="text-sm text-gray-900">{{ ucfirst($order->payment_method ?? 'Paystack') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Transaction ID</dt>
                                    <dd class="text-sm text-gray-900">{{ $order->transaction_id ?? 'TXN'.rand(1000000, 9999999) }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    
                    <!-- Order Specifics -->
                    <div class="mt-8">
                        <h4 class="text-sm font-medium text-gray-900 mb-4">Order Specifics</h4>
                        <div class="bg-gray-50 rounded-lg p-4">
                            @if($order->order_type == 'test')
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-primary-500 mr-2"></i>
                                        <span class="text-sm text-gray-700">Full Blood Count</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-primary-500 mr-2"></i>
                                        <span class="text-sm text-gray-700">Blood Glucose Test</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-primary-500 mr-2"></i>
                                        <span class="text-sm text-gray-700">Malaria Parasite Test</span>
                                    </div>
                                </div>
                            @else
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-tint text-accent mr-2"></i>
                                        <span class="text-sm text-gray-700">Blood Type: O+</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-tint text-accent mr-2"></i>
                                        <span class="text-sm text-gray-700">Quantity: 1 Unit</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-tint text-accent mr-2"></i>
                                        <span class="text-sm text-gray-700">Purpose: Medical Procedure</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Address Information -->
                    <div class="mt-8">
                        <h4 class="text-sm font-medium text-gray-900 mb-4">Address Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h5 class="text-xs font-medium text-gray-500 uppercase mb-2">Delivery/Service Address</h5>
                                <p class="text-sm text-gray-700">{{ $order->delivery_address }}</p>
                            </div>
                            <div>
                                <h5 class="text-xs font-medium text-gray-500 uppercase mb-2">Pickup Address</h5>
                                <p class="text-sm text-gray-700">{{ $order->pickup_address ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Map & Support -->
            <div class="lg:col-span-1">
                <!-- Tracking Map -->
                @if(in_array($order->status, ['accepted', 'processing', 'sample_collected', 'in_transit']))
                    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Live Tracking</h3>
                        <div class="bg-gray-100 rounded-lg h-64 mb-4 flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-map-marker-alt text-primary-500 text-2xl mb-2"></i>
                                <p class="text-sm text-gray-500">Live tracking map will appear here</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500">Estimated Arrival</p>
                                <p class="text-sm font-medium text-gray-900">15-20 minutes</p>
                            </div>
                            <button class="text-primary-600 hover:text-primary-900 text-sm font-medium flex items-center">
                                <i class="fas fa-sync-alt mr-1"></i>
                                <span>Refresh</span>
                            </button>
                        </div>
                    </div>
                @endif
                
                <!-- Results Section -->
                @if($order->status == 'results_ready' && $order->order_type == 'test')
                    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Test Results</h3>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4 flex items-center">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-green-800">Results are ready</p>
                                <p class="text-xs text-green-600">Available for download</p>
                            </div>
                        </div>
                        <a href="#" class="liquid-button w-full bg-secondary-500 hover:bg-secondary-600 text-white px-4 py-3 rounded-lg text-sm font-medium flex items-center justify-center transition-all duration-300 shadow-lg shadow-secondary-500/20">
                            <i class="fas fa-download mr-2"></i>
                            <span>Download Results (PDF)</span>
                        </a>
                    </div>
                @endif
                
                <!-- Support Section -->
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Need Help?</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-phone-alt text-primary-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Call Support</p>
                                <p class="text-sm text-gray-500">+234-XXX-XXX-XXXX</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-comment-alt text-primary-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Live Chat</p>
                                <p class="text-sm text-gray-500">Available 24/7</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-envelope text-primary-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Email Us</p>
                                <p class="text-sm text-gray-500">support@medlabaccess.ng</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-3 rounded-lg text-sm font-medium flex items-center justify-center transition-all duration-300">
                            <i class="fas fa-question-circle mr-2"></i>
                            <span>Report an Issue</span>
                        </button>
                    </div>
                </div>
                
                <!-- Related Orders -->
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Related Orders</h3>
                    <div class="space-y-4">
                        <p class="text-sm text-gray-500">No related orders found.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
