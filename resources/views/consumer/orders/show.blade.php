<x-consumer-dashboard-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <div class="flex items-center">
                    <a href="{{ route('consumer.orders.index') }}" class="mr-2 bg-primary-100 hover:bg-primary-200 rounded-full p-2 transition-colors">
                        <i class="fas fa-arrow-left text-primary-700"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-display font-bold text-gray-800">Order #{{ $order->id }}</h1>
                        <p class="mt-1 text-gray-500">Placed on {{ $order->created_at->format('F j, Y, g:i a') }}</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-3">
                @if($order->status == 'results_ready')
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-secondary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-secondary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-download mr-2"></i>
                        <span>Download Results</span>
                    </a>
                @endif
                <button class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-print mr-2"></i>
                    <span>Print Details</span>
                </button>
            </div>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                                            <span class="text-sm text-gray-700">Lipid Profile</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <i class="fas fa-tint text-accent mr-2"></i>
                                            <span class="text-sm text-gray-700">Blood Group: {{ $order->details['blood_group'] ?? 'N/A' }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-tint text-accent mr-2"></i>
                                            <span class="text-sm text-gray-700">Units: {{ $order->details['units'] ?? 'N/A' }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-tint text-accent mr-2"></i>
                                            <span class="text-sm text-gray-700">Urgency: {{ ucfirst($order->details['urgency'] ?? 'N/A') }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column: Delivery Address & Map -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Delivery Information</h3>
                        <p class="text-sm font-medium text-gray-900">{{ $order->consumer->name }}</p>
                        <p class="text-sm text-gray-600">{{ $order->delivery_address }}</p>
                        <p class="text-sm text-gray-600">{{ $order->consumer->phone }}</p>
                    </div>
                    
                    <!-- Map -->
                    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden h-64">
                        <!-- Placeholder for Mapbox Map -->
                        <div class="bg-gray-200 h-full flex items-center justify-center">
                            <p class="text-gray-500">Map Loading...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-consumer-dashboard-layout>
