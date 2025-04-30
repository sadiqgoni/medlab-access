@extends('layouts.app')

@section('content')
<!-- Orders List Page -->
<div class="bg-neutral-light min-h-screen pt-20 pb-12">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-2xl md:text-3xl font-display font-bold">My Orders</h1>
                    <p class="mt-1 text-primary-100">View and manage all your orders</p>
                </div>
                <div>
                    <a href="{{ route('consumer.orders.create') }}" class="liquid-button bg-accent hover:bg-accent/90 text-white px-4 py-2 rounded-full text-sm font-medium flex items-center transition-all duration-300 shadow-lg shadow-accent/20">
                        <i class="fas fa-plus-circle mr-2"></i>
                        <span>New Order</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filter Controls -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex flex-wrap gap-2">
                    <button class="px-4 py-2 rounded-full bg-primary-500 text-white text-sm font-medium">All Orders</button>
                    <button class="px-4 py-2 rounded-full bg-white border border-gray-200 text-gray-700 text-sm font-medium hover:bg-gray-50">Lab Tests</button>
                    <button class="px-4 py-2 rounded-full bg-white border border-gray-200 text-gray-700 text-sm font-medium hover:bg-gray-50">Blood Services</button>
                </div>
                <div class="flex items-center gap-2">
                    <div class="relative">
                        <input type="text" placeholder="Search orders..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-full w-full focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                    <div class="relative">
                        <select class="pl-4 pr-10 py-2 border border-gray-300 rounded-full w-full focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none">
                            <option>All Time</option>
                            <option>Last 7 Days</option>
                            <option>Last 30 Days</option>
                            <option>Last 3 Months</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Orders Table -->
        @if($orders->isEmpty())
            <div class="bg-white rounded-xl shadow-md p-8 text-center border border-gray-100">
                <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 mb-4">
                    <i class="fas fa-clipboard text-primary-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">No Orders Yet</h3>
                <p class="text-gray-500 mb-4">You haven't placed any orders yet. Start by requesting a lab test or blood service.</p>
                <a href="{{ route('consumer.orders.create') }}" class="liquid-button inline-flex items-center px-4 py-2 bg-primary-500 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-primary-600 active:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-plus-circle mr-2"></i>
                    <span>Place Your First Order</span>
                </a>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Facility</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($order->order_type == 'test')
                                            <span class="inline-flex items-center">
                                                <i class="fas fa-vial text-primary-500 mr-1"></i>
                                                Lab Test
                                            </span>
                                        @else
                                            <span class="inline-flex items-center">
                                                <i class="fas fa-tint text-accent mr-1"></i>
                                                Blood Service
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->facility?->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
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
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₦{{ number_format($order->total_amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('consumer.orders.show', $order) }}" class="text-primary-600 hover:text-primary-900 mr-3">View</a>
                                        @if($order->status == 'results_ready')
                                            <a href="#" class="text-secondary-600 hover:text-secondary-900">Download Results</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $orders->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
