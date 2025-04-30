
<x-consumer-dashboard-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('consumer.orders.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Order
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-lg shadow-lg mb-6">
                <div class="px-6 py-8 md:flex md:items-center md:justify-between">
                    <div class="max-w-xl">
                        <h2 class="text-2xl font-bold text-white sm:text-3xl">Welcome back, {{ Auth::user()->name }}!</h2>
                        <p class="mt-2 text-white text-opacity-90">
                            Access medical services and manage your health needs with ease.
                        </p>
                    </div>
                    <div class="mt-6 md:mt-0">
                        <div class="h-16 w-16 rounded-full bg-white/20 flex items-center justify-center">
                            <span class="text-white text-3xl font-bold">M</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-6">
                <!-- Total Orders -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-primary-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Orders</dt>
                                    <dd>
                                        <div class="text-lg font-semibold text-gray-900">{{ $totalOrders }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('consumer.orders.index') }}" class="font-medium text-primary-700 hover:text-primary-900">
                                View all orders
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Active Orders -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Active Orders</dt>
                                    <dd>
                                        <div class="text-lg font-semibold text-gray-900">{{ $activeOrders }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('consumer.orders.index') }}" class="font-medium text-primary-700 hover:text-primary-900">
                                View active orders
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Completed Orders -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Completed Orders</dt>
                                    <dd>
                                        <div class="text-lg font-semibold text-gray-900">{{ $completedOrders }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('consumer.orders.index') }}" class="font-medium text-primary-700 hover:text-primary-900">
                                View completed orders
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Results Ready -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Results Ready</dt>
                                    <dd>
                                        <div class="text-lg font-semibold text-gray-900">{{ $resultsReadyOrders }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('consumer.orders.index') }}" class="font-medium text-primary-700 hover:text-primary-900">
                                View results
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-5 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Recent Orders</h3>
                        <a href="{{ route('consumer.orders.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500">
                            View all
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    @if(count($recentOrders) > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentOrders as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($order->order_type == 'test')
                                                <span class="inline-flex items-center">
                                                    <svg class="h-4 w-4 text-primary-500 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.769 2.156 18 4.828 18h10.343c2.673 0 4.012-3.231 2.122-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.563-.187a1.993 1.993 0 00-.114-.035l1.063-1.063A3 3 0 009 8.172z" clip-rule="evenodd" />
                                                    </svg>
                                                    Lab Test
                                                </span>
                                            @else
                                                <span class="inline-flex items-center">
                                                    <svg class="h-4 w-4 text-red-500 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                                    </svg>
                                                    Blood Service
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
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
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('consumer.orders.show', $order) }}" class="text-primary-600 hover:text-primary-900">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="py-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No orders yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new order.</p>
                            <div class="mt-6">
                                <a href="{{ route('consumer.orders.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    New Order
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Services Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- eMedSample Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="md:flex">
                        <div class="md:w-1/3 bg-gradient-to-br from-primary-500 to-primary-700 text-white p-6 flex flex-col justify-between">
                            <div>
                                <div class="h-14 w-14 rounded-full bg-white/20 flex items-center justify-center mb-4">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold mb-2">eMedSample</h3>
                                <p class="text-primary-100 text-sm">Laboratory testing services with home sample collection</p>
                            </div>
                            <div class="mt-6">
                                <span class="text-xs uppercase tracking-wider font-semibold bg-white/20 rounded-full px-3 py-1">Lab Tests</span>
                            </div>
                        </div>
                        <div class="md:w-2/3 p-6">
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-800 mb-2">Available Tests</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="bg-gray-50 rounded-lg p-3 text-sm flex items-center">
                                        <svg class="h-4 w-4 text-primary-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Full Blood Count
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 text-sm flex items-center">
                                        <svg class="h-4 w-4 text-primary-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Blood Glucose
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 text-sm flex items-center">
                                        <svg class="h-4 w-4 text-primary-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Lipid Profile
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 text-sm flex items-center">
                                        <svg class="h-4 w-4 text-primary-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Liver Function
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('consumer.orders.create', ['type' => 'test']) }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Order Lab Test
                            </a>
                        </div>
                    </div>
                </div>

                <!-- SharedBlood Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="md:flex">
                        <div class="md:w-1/3 bg-gradient-to-br from-red-500 to-red-700 text-white p-6 flex flex-col justify-between">
                            <div>
                                <div class="h-14 w-14 rounded-full bg-white/20 flex items-center justify-center mb-4">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold mb-2">SharedBlood</h3>
                                <p class="text-red-100 text-sm">Blood donation and request services</p>
                            </div>
                            <div class="mt-6">
                                <span class="text-xs uppercase tracking-wider font-semibold bg-white/20 rounded-full px-3 py-1">Blood Services</span>
                            </div>
                        </div>
                        <div class="md:w-2/3 p-6">
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-800 mb-2">Available Services</h4>
                                <div class="grid grid-cols-1 gap-2">
                                    <div class="bg-gray-50 rounded-lg p-3 text-sm flex items-center">
                                        <svg class="h-4 w-4 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Donate Blood
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 text-sm flex items-center">
                                        <svg class="h-4 w-4 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Request Blood
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('consumer.orders.create', ['type' => 'blood']) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Blood Services
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Health Tips & Resources -->
            <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
                <div class="px-5 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Health Tips & Resources</h3>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center mb-3">
                                <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h4 class="text-md font-medium text-gray-900 mb-1">Preparing for Lab Tests</h4>
                            <p class="text-sm text-gray-500 mb-3">Learn how to properly prepare for different types of laboratory tests.</p>
                            <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-500">Read more</a>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center mb-3">
                                <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <h4 class="text-md font-medium text-gray-900 mb-1">Blood Donation Benefits</h4>
                            <p class="text-sm text-gray-500 mb-3">Discover the health benefits of regular blood donation and how it helps others.</p>
                            <a href="#" class="text-sm font-medium text-red-600 hover:text-red-500">Read more</a>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center mb-3">
                                <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <h4 class="text-md font-medium text-gray-900 mb-1">Understanding Test Results</h4>
                            <p class="text-sm text-gray-500 mb-3">Learn how to interpret common laboratory test results and what they mean.</p>
                            <a href="#" class="text-sm font-medium text-green-600 hover:text-green-500">Read more</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Appointments -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Upcoming Appointments</h3>
                        <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-500">
                            View all
                        </a>
                    </div>
                </div>
                <div class="p-5">
                    @if(isset($appointments) && count($appointments) > 0)
                        <div class="space-y-4">
                            @foreach($appointments as $appointment)
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center">
                                        <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $appointment->title }}</h4>
                                        <div class="flex items-center mt-1">
                                            <svg class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-xs text-gray-500">{{ $appointment->scheduled_at->format('M d, Y - h:i A') }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            Details
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No upcoming appointments</h3>
                            <p class="mt-1 text-sm text-gray-500">Schedule an appointment for sample collection or blood donation.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-consumer-dashboard-layout>