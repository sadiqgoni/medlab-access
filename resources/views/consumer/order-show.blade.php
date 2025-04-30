    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Details') }} #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6">

                    <div>
                        <a href="{{ route('consumer.orders.index') }}" class="text-sm text-indigo-600 hover:underline mb-4 inline-block">&larr; Back to Order History</a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div>
                            <h3 class="text-lg font-medium mb-2">Order Summary</h3>
                            <dl class="divide-y divide-gray-200">
                                <div class="py-3 flex justify-between text-sm">
                                    <dt class="text-gray-500">Order ID</dt>
                                    <dd class="text-gray-900">#{{ $order->id }}</dd>
                                </div>
                                <div class="py-3 flex justify-between text-sm">
                                    <dt class="text-gray-500">Date Placed</dt>
                                    <dd class="text-gray-900">{{ $order->created_at->format('F j, Y, g:i a') }}</dd>
                                </div>
                                <div class="py-3 flex justify-between text-sm">
                                    <dt class="text-gray-500">Order Type</dt>
                                    <dd class="text-gray-900">{{ ucfirst($order->order_type) }}</dd>
                                </div>
                                <div class="py-3 flex justify-between text-sm">
                                    <dt class="text-gray-500">Facility</dt>
                                    <dd class="text-gray-900">{{ $order->facility?->name ?? 'N/A' }}</dd>
                                </div>
                                <div class="py-3 flex justify-between text-sm">
                                    <dt class="text-gray-500">Status</dt>
                                    <dd class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
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
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Right Column -->
                        <div>
                            <h3 class="text-lg font-medium mb-2">Payment & Logistics</h3>
                             <dl class="divide-y divide-gray-200">
                                <div class="py-3 flex justify-between text-sm">
                                    <dt class="text-gray-500">Total Amount</dt>
                                    <dd class="text-gray-900 font-medium">₦{{ number_format($order->total_amount, 2) }}</dd>
                                </div>
                                <div class="py-3 flex justify-between text-sm">
                                    <dt class="text-gray-500">Payment Status</dt>
                                    <dd class="text-gray-900">{{ ucfirst($order->payment_status) }}</dd>
                                </div>
                                <div class="py-3 flex justify-between text-sm">
                                    <dt class="text-gray-500">Assigned Biker</dt>
                                    <dd class="text-gray-900">{{ $order->biker?->name ?? 'Not Assigned Yet' }}</dd>
                                </div>
                                <div class="py-3 flex justify-between text-sm">
                                    <dt class="text-gray-500">Delivery/Service Address</dt>
                                    <dd class="text-gray-900 text-right">{{ $order->delivery_address }}</dd>
                                </div>
                                 <div class="py-3 flex justify-between text-sm">
                                    <dt class="text-gray-500">Pickup Address</dt>
                                    <dd class="text-gray-900 text-right">{{ $order->pickup_address ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Order Details JSON -->
                    <div class="pt-6 border-t">
                        <h3 class="text-lg font-medium mb-2">Order Specifics</h3>
                        <pre class="bg-gray-100 p-4 rounded text-sm overflow-x-auto">{{ json_encode($order->details, JSON_PRETTY_PRINT) }}</pre>
                    </div>

                    <!-- TODO: Add tracking map if status allows -->
                    <!-- TODO: Add button to download results if status allows -->

                </div>
            </div>
        </div>
    </div>
