<x-consumer-dashboard-layout>
    <x-slot name="header">
        <div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0">
            <div class="flex-1 min-w-0">
                <h2 class="font-bold text-xl sm:text-2xl text-gray-900 leading-tight">
                    Good {{ now()->format('H') < 12 ? 'morning' : (now()->format('H') < 17 ? 'afternoon' : 'evening') }}, {{ Auth::user()->name }}!
                </h2>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">Here's what's happening with your health today</p>
            </div>
            <div class="flex flex-col space-y-2 sm:flex-row sm:items-center sm:space-y-0 sm:space-x-3">
                <!-- Quick Actions -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Quick Actions
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                        <div class="py-2">
                            <a href="{{ route('consumer.orders.create', ['type' => 'test']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-3 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                                Book Lab Test
                            </a>
                            <a href="{{ route('consumer.orders.create', ['type' => 'blood']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                Blood Services
                            </a>
                            <a href="{{ route('consumer.profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Update Profile
                            </a>
                        </div>
                    </div>
                </div>
                <a href="{{ route('consumer.orders.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 border border-transparent rounded-lg font-semibold text-sm text-white hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Order
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Health Status Banner -->
            <div class="bg-gradient-to-br from-primary-50 via-primary-100 to-blue-50 rounded-2xl shadow-sm mb-8 overflow-hidden relative">
                <div class="absolute inset-0 bg-gradient-to-r from-primary-600/10 to-blue-600/10"></div>
                <div class="relative px-8 py-6 md:flex md:items-center md:justify-between">
                    <div class="max-w-2xl">
                        <div class="flex items-center mb-3">
                            <div class="h-12 w-12 rounded-full bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center mr-4 shadow-lg">
                                <span class="text-white text-xl font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Your Health Dashboard</h2>
                                <p class="text-gray-600">Stay on top of your health with our comprehensive medical services</p>
                            </div>
                        </div>
                        
                        @if($activeOrders > 0)
                            <div class="flex items-center mt-4 p-3 bg-white/70 rounded-lg backdrop-blur-sm">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">
                                        You have {{ $activeOrders }} active {{ Str::plural('order', $activeOrders) }} in progress
                                    </p>
                                    <p class="text-xs text-gray-600">Track your orders for real-time updates</p>
                                </div>
                                <div class="ml-auto">
                                    <a href="{{ route('consumer.orders.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-700">
                                        View Orders →
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-6 md:mt-0 md:ml-8">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-4 bg-white/70 rounded-xl backdrop-blur-sm">
                                <div class="text-2xl font-bold text-primary-600">{{ $totalOrders }}</div>
                                <div class="text-xs text-gray-600 uppercase tracking-wide">Total Orders</div>
                            </div>
                            <div class="text-center p-4 bg-white/70 rounded-xl backdrop-blur-sm">
                                <div class="text-2xl font-bold text-green-600">{{ $completedOrders }}</div>
                                <div class="text-xs text-gray-600 uppercase tracking-wide">Completed</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                <!-- Active Orders -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-50 rounded-xl p-3">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Active Orders</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">{{ $activeOrders }}</div>
                                        @if($activeOrders > 0)
                                            <div class="ml-2 flex items-baseline text-sm font-semibold text-blue-600">
                                                <svg class="self-center flex-shrink-0 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="sr-only">In progress</span>
                                            </div>
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3">
                        <div class="text-sm">
                            <a href="{{ route('consumer.orders.index') }}" class="font-medium text-blue-700 hover:text-blue-900 transition-colors">
                                Track progress →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Results Ready -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-50 rounded-xl p-3">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-4 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Results Ready</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">{{ $resultsReadyOrders }}</div>
                                        @if($resultsReadyOrders > 0)
                                            <div class="ml-2 flex items-baseline text-sm font-semibold text-purple-600">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    New
                                                </span>
                                            </div>
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3">
                        <div class="text-sm">
                            <a href="{{ route('consumer.orders.index') }}" class="font-medium text-purple-700 hover:text-purple-900 transition-colors">
                                Download results →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Completed Orders -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-50 rounded-xl p-3">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Completed</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">{{ $completedOrders }}</div>
                                        <div class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                            <svg class="self-center flex-shrink-0 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3">
                        <div class="text-sm">
                            <a href="{{ route('consumer.orders.index') }}" class="font-medium text-green-700 hover:text-green-900 transition-colors">
                                View history →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Health Score -->
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-orange-50 rounded-xl p-3">
                                <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <div class="ml-4 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Health Score</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">85</div>
                                        <div class="ml-2 flex items-baseline text-sm font-semibold text-orange-600">
                                            <span class="text-xs">/100</span>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3">
                        <div class="text-sm">
                            <a href="#" class="font-medium text-orange-700 hover:text-orange-900 transition-colors">
                                View insights →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & Services -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Recent Orders -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-sm rounded-xl border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                                <a href="{{ route('consumer.orders.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors">
                                    View all →
                                </a>
                            </div>
                        </div>
                        <div class="overflow-hidden">
                            @if(count($recentOrders) > 0)
                                <div class="divide-y divide-gray-100">
                                    @foreach($recentOrders as $order)
                                        <div class="p-6 hover:bg-gray-50 transition-colors">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0">
                                                        @if($order->order_type == 'test')
                                                            <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                                                <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                                                </svg>
                                                            </div>
                                                        @else
                                                            <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                                                                <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="flex items-center">
                                                            <p class="text-sm font-medium text-gray-900">Order #{{ $order->id }}</p>
                                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
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
                                                        <p class="text-sm text-gray-500">
                                                            {{ $order->order_type == 'test' ? 'Lab Test' : 'Blood Service' }} • 
                                                            {{ $order->created_at->format('M d, Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center">
                                                    <a href="{{ route('consumer.orders.show', $order) }}" class="text-primary-600 hover:text-primary-900 text-sm font-medium">
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                    <h3 class="mt-4 text-lg font-medium text-gray-900">No recent activity</h3>
                                    <p class="mt-2 text-sm text-gray-500">Start your health journey by placing your first order.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('consumer.orders.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Place Your First Order
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Services -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-sm rounded-xl border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Quick Services</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <a href="{{ route('consumer.orders.create', ['type' => 'test']) }}" class="block p-4 rounded-lg border-2 border-dashed border-gray-200 hover:border-primary-300 hover:bg-primary-50 transition-all duration-200 group">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-lg bg-primary-100 group-hover:bg-primary-200 flex items-center justify-center transition-colors">
                                            <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900 group-hover:text-primary-900">Lab Tests</p>
                                        <p class="text-xs text-gray-500">Home sample collection</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('consumer.orders.create', ['type' => 'blood']) }}" class="block p-4 rounded-lg border-2 border-dashed border-gray-200 hover:border-red-300 hover:bg-red-50 transition-all duration-200 group">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-lg bg-red-100 group-hover:bg-red-200 flex items-center justify-center transition-colors">
                                            <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900 group-hover:text-red-900">Blood Services</p>
                                        <p class="text-xs text-gray-500">Donate or request blood</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('consumer.profile.edit') }}" class="block p-4 rounded-lg border-2 border-dashed border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition-all duration-200 group">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-lg bg-gray-100 group-hover:bg-gray-200 flex items-center justify-center transition-colors">
                                            <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900 group-hover:text-gray-900">Update Profile</p>
                                        <p class="text-xs text-gray-500">Manage your information</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- eMedSample Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/10 to-primary-600/10"></div>
                        <div class="relative p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-xl bg-primary-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-xl font-semibold text-gray-900">eMedSample</h3>
                                        <p class="text-sm text-gray-600">Laboratory testing services</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                    Lab Tests
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3 mb-6">
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-sm text-gray-700">Full Blood Count</span>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-sm text-gray-700">Blood Glucose</span>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-sm text-gray-700">Lipid Profile</span>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-sm text-gray-700">Liver Function</span>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="{{ route('consumer.orders.create', ['type' => 'test']) }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 bg-primary-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Book Lab Test
                            </a>
                        </div>
                    </div>
                </div>

                <!-- SharedBlood Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-red-500/10 to-red-600/10"></div>
                        <div class="relative p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-xl bg-red-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-xl font-semibold text-gray-900">SharedBlood</h3>
                                        <p class="text-sm text-gray-600">Blood donation & requests</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Blood Services
                                </span>
                            </div>
                            
                            <div class="space-y-3 mb-6">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-900">Donate Blood</span>
                                        </div>
                                        <span class="text-xs text-gray-500">Save lives</span>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-900">Request Blood</span>
                                        </div>
                                        <span class="text-xs text-gray-500">Emergency</span>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="{{ route('consumer.orders.create', ['type' => 'blood']) }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 bg-red-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                Blood Services
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Health Insights & Tips -->
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Health Insights & Tips</h3>
                        <button class="text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors">
                            View All Tips →
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="group cursor-pointer">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 group-hover:from-blue-100 group-hover:to-blue-200 transition-all duration-200">
                                <div class="h-12 w-12 rounded-xl bg-blue-500 flex items-center justify-center mb-4">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Preparing for Lab Tests</h4>
                                <p class="text-sm text-gray-600 mb-4">Learn how to properly prepare for different types of laboratory tests to ensure accurate results.</p>
                                <div class="flex items-center text-sm font-medium text-blue-600 group-hover:text-blue-700">
                                    Read More
                                    <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="group cursor-pointer">
                            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 group-hover:from-red-100 group-hover:to-red-200 transition-all duration-200">
                                <div class="h-12 w-12 rounded-xl bg-red-500 flex items-center justify-center mb-4">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Blood Donation Benefits</h4>
                                <p class="text-sm text-gray-600 mb-4">Discover the health benefits of regular blood donation and how it helps save lives in your community.</p>
                                <div class="flex items-center text-sm font-medium text-red-600 group-hover:text-red-700">
                                    Read More
                                    <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="group cursor-pointer">
                            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 group-hover:from-green-100 group-hover:to-green-200 transition-all duration-200">
                                <div class="h-12 w-12 rounded-xl bg-green-500 flex items-center justify-center mb-4">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Understanding Test Results</h4>
                                <p class="text-sm text-gray-600 mb-4">Learn how to interpret common laboratory test results and what they mean for your health.</p>
                                <div class="flex items-center text-sm font-medium text-green-600 group-hover:text-green-700">
                                    Read More
                                    <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Appointments -->
            <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Upcoming Appointments</h3>
                        <button class="text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors">
                            Schedule New →
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    @if(isset($appointments) && count($appointments) > 0)
                        <div class="space-y-4">
                            @foreach($appointments as $appointment)
                                <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                    <div class="flex-shrink-0 h-12 w-12 rounded-xl bg-primary-100 flex items-center justify-center">
                                        <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h4 class="text-sm font-semibold text-gray-900">{{ $appointment->title }}</h4>
                                        <div class="flex items-center mt-1">
                                            <svg class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-xs text-gray-500">{{ $appointment->scheduled_at->format('M d, Y - h:i A') }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <button class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No upcoming appointments</h3>
                            <p class="mt-2 text-sm text-gray-500">Schedule an appointment for sample collection or blood donation to get started.</p>
                            <div class="mt-6">
                                <button class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Schedule Appointment
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-consumer-dashboard-layout>