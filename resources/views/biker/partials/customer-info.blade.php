{{-- Customer Information for Biker's Delivery Tasks --}}

@php
    $customer = $getRecord()->consumer;
    $orderType = $getRecord()->order_type;
@endphp

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 bg-blue-50 border-b border-blue-100 flex items-center">
        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
        </div>
        <div>
            <h3 class="font-medium text-blue-900">Customer Information</h3>
            <p class="text-sm text-blue-600">
                @if($orderType === 'test')
                    Sample pickup details
                @else
                    Blood delivery recipient
                @endif
            </p>
        </div>
    </div>
    
    <div class="p-4">
        @if($customer)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Name</h4>
                    <p class="text-gray-900 font-medium">{{ $customer->name }}</p>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Contact</h4>
                    @if($customer->phone)
                        <p class="text-gray-900">
                            <a href="tel:{{ $customer->phone }}" class="flex items-center group">
                                {{ $customer->phone }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                            </a>
                        </p>
                    @else
                        <p class="text-gray-400 italic">Not provided</p>
                    @endif
                </div>
            </div>
            
            <div class="mt-4">
                <h4 class="text-sm font-medium text-gray-500 mb-1">
                    @if($orderType === 'test')
                        Pickup Address
                    @else
                        Delivery Address
                    @endif
                </h4>
                <p class="text-gray-900">
                    @if($orderType === 'test')
                        {{ $getRecord()->pickup_address ?? $customer->address ?? 'No address provided' }}
                    @else
                        {{ $getRecord()->delivery_address ?? $customer->address ?? 'No address provided' }}
                    @endif
                </p>
                @if($orderType === 'test' && ($getRecord()->pickup_address || $customer->address))
                    <a 
                        href="https://maps.google.com/?q={{ urlencode($getRecord()->pickup_address ?? $customer->address) }}" 
                        target="_blank"
                        class="mt-2 inline-flex items-center text-sm text-blue-600 hover:text-blue-800 transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        View on Map
                    </a>
                @elseif($orderType === 'blood' && ($getRecord()->delivery_address || $customer->address))
                    <a 
                        href="https://maps.google.com/?q={{ urlencode($getRecord()->delivery_address ?? $customer->address) }}" 
                        target="_blank"
                        class="mt-2 inline-flex items-center text-sm text-blue-600 hover:text-blue-800 transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        View on Map
                    </a>
                @endif
            </div>
            
            @if($getRecord()->customer_notes)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Customer Notes</h4>
                    <div class="bg-blue-50 text-blue-800 p-3 rounded-md text-sm">
                        {{ $getRecord()->customer_notes }}
                    </div>
                </div>
            @endif
            
            @if($orderType === 'test')
                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center space-x-3">
                    <div class="p-2 bg-green-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-600">
                        For test orders, you will <strong>pick up samples FROM the customer</strong> and deliver them TO the laboratory.
                    </p>
                </div>
            @else
                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center space-x-3">
                    <div class="p-2 bg-red-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-600">
                        For blood orders, you will <strong>pick up blood FROM the facility</strong> and deliver it TO this customer.
                    </p>
                </div>
            @endif
        @else
            <div class="p-4 text-center">
                <p class="text-gray-500">Customer information not available</p>
            </div>
        @endif
    </div>
</div>