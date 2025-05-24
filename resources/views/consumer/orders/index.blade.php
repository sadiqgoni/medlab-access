<x-consumer-dashboard-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
                <p class="mt-2 text-gray-600">Track and manage all your health service orders</p>
                <div class="flex items-center mt-3 space-x-4">
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-chart-line mr-2 text-primary-500"></i>
                        <span>{{ $orders->total() }} total orders</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-clock mr-2 text-blue-500"></i>
                        <span>{{ $orders->where('status', '!=', 'completed')->count() }} active</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all duration-200 shadow-sm">
                        <i class="fas fa-download mr-2"></i>
                        Export
                        <i class="fas fa-chevron-down ml-2"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                        <div class="py-2">
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-file-pdf mr-3 text-red-500"></i>
                                Export as PDF
                            </a>
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-file-excel mr-3 text-green-500"></i>
                                Export as Excel
                            </a>
                        </div>
                    </div>
                </div>
                <a href="{{ route('consumer.orders.create') }}" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 border border-transparent rounded-lg font-semibold text-sm text-white hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200 shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    <span>New Order</span>
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="py-6" x-data="ordersPage()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Enhanced Filter Controls -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-100">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <!-- Filter Tabs -->
                    <div class="flex flex-wrap gap-2">
                        <button @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'bg-primary-500 text-white shadow-lg' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50'" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200">
                            All Orders
                            <span class="ml-2 px-2 py-0.5 rounded-full text-xs" :class="activeFilter === 'all' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600'">{{ $orders->total() }}</span>
                        </button>
                        <button @click="activeFilter = 'test'" :class="activeFilter === 'test' ? 'bg-blue-500 text-white shadow-lg' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50'" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200">
                            <i class="fas fa-vial mr-1"></i>
                            Lab Tests
                            <span class="ml-2 px-2 py-0.5 rounded-full text-xs" :class="activeFilter === 'test' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600'">{{ $orders->where('order_type', 'test')->count() }}</span>
                        </button>
                        <button @click="activeFilter = 'blood'" :class="activeFilter === 'blood' ? 'bg-red-500 text-white shadow-lg' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50'" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200">
                            <i class="fas fa-tint mr-1"></i>
                            Blood Services
                            <span class="ml-2 px-2 py-0.5 rounded-full text-xs" :class="activeFilter === 'blood' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600'">{{ $orders->where('order_type', 'blood')->count() }}</span>
                        </button>
                        <button @click="activeFilter = 'active'" :class="activeFilter === 'active' ? 'bg-orange-500 text-white shadow-lg' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50'" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200">
                            <i class="fas fa-clock mr-1"></i>
                            Active
                            <span class="ml-2 px-2 py-0.5 rounded-full text-xs" :class="activeFilter === 'active' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600'">{{ $orders->whereIn('status', ['pending', 'accepted', 'processing', 'sample_collected', 'in_transit'])->count() }}</span>
                        </button>
                    </div>
                    
                    <!-- Search and Sort Controls -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" x-model="searchQuery" placeholder="Search orders..." class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg w-full sm:w-64 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                        </div>
                        <div class="relative">
                            <select x-model="dateFilter" class="pl-4 pr-10 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none bg-white min-w-[140px]">
                                <option value="all">All Time</option>
                                <option value="today">Today</option>
                                <option value="week">Last 7 Days</option>
                                <option value="month">Last 30 Days</option>
                                <option value="quarter">Last 3 Months</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                        <div class="relative">
                            <select x-model="sortBy" class="pl-4 pr-10 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none bg-white min-w-[140px]">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="amount_high">Amount: High to Low</option>
                                <option value="amount_low">Amount: Low to High</option>
                                <option value="status">Status</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Orders Content -->
            @if($orders->isEmpty())
                <!-- Enhanced Empty State -->
                <div class="bg-white rounded-xl shadow-sm p-12 text-center border border-gray-100">
                    <div class="max-w-md mx-auto">
                        <div class="inline-flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-br from-primary-100 to-primary-200 mb-6">
                            <i class="fas fa-clipboard-list text-primary-600 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No Orders Yet</h3>
                        <p class="text-gray-600 mb-8 leading-relaxed">You haven't placed any orders yet. Start your health journey by requesting a lab test or blood service from our trusted network of facilities.</p>
                        
                        <!-- Quick Action Cards -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                            <a href="{{ route('consumer.orders.create', ['type' => 'test']) }}" class="p-4 border-2 border-dashed border-blue-200 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition-all duration-200 group">
                                <div class="flex flex-col items-center">
                                    <div class="h-12 w-12 rounded-lg bg-blue-100 group-hover:bg-blue-200 flex items-center justify-center mb-3 transition-colors">
                                        <i class="fas fa-vial text-blue-600 text-lg"></i>
                                    </div>
                                    <span class="font-medium text-gray-900 group-hover:text-blue-900">Book Lab Test</span>
                                    <span class="text-sm text-gray-500 mt-1">Home sample collection</span>
                                </div>
                            </a>
                            <a href="{{ route('consumer.orders.create', ['type' => 'blood']) }}" class="p-4 border-2 border-dashed border-red-200 rounded-lg hover:border-red-400 hover:bg-red-50 transition-all duration-200 group">
                                <div class="flex flex-col items-center">
                                    <div class="h-12 w-12 rounded-lg bg-red-100 group-hover:bg-red-200 flex items-center justify-center mb-3 transition-colors">
                                        <i class="fas fa-tint text-red-600 text-lg"></i>
                                    </div>
                                    <span class="font-medium text-gray-900 group-hover:text-red-900">Blood Services</span>
                                    <span class="text-sm text-gray-500 mt-1">Donate or request blood</span>
                                </div>
                            </a>
                        </div>
                        
                        <a href="{{ route('consumer.orders.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 border border-transparent rounded-lg font-semibold text-sm text-white hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200 shadow-lg">
                            <i class="fas fa-plus mr-2"></i>
                            <span>Place Your First Order</span>
                        </a>
                    </div>
                </div>
            @else
                <!-- Enhanced Orders Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Table Header -->
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Your Orders</h3>
                            <div class="flex items-center space-x-2 text-sm text-gray-500">
                                <span>Showing {{ $orders->firstItem() }}-{{ $orders->lastItem() }} of {{ $orders->total() }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Desktop Table View -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Order Details</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Service Type</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Facility</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th scope="col" class="relative px-6 py-4">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($orders as $order)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-lg {{ $order->order_type == 'test' ? 'bg-blue-100' : 'bg-red-100' }} flex items-center justify-center">
                                                    @if($order->order_type == 'test')
                                                        <i class="fas fa-vial text-blue-600"></i>
                                                    @else
                                                        <i class="fas fa-tint text-red-600"></i>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-gray-900">#{{ $order->id }}</div>
                                                    <div class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($order->order_type == 'test')
                                                <div class="flex items-center">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        <i class="fas fa-vial mr-1"></i>
                                                        Lab Test
                                                    </span>
                                                </div>
                                            @else
                                                <div class="flex items-center">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        <i class="fas fa-tint mr-1"></i>
                                                        Blood Service
                                                    </span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 font-medium">{{ $order->facility?->name ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($order->facility?->address ?? 'No address', 30) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
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
                                                @switch($order->status)
                                                    @case('pending')
                                                        <i class="fas fa-clock mr-1"></i>
                                                        @break
                                                    @case('accepted')
                                                    @case('processing')
                                                    @case('sample_collected')
                                                    @case('in_transit')
                                                    @case('delivered')
                                                        <i class="fas fa-spinner fa-spin mr-1"></i>
                                                        @break
                                                    @case('results_ready')
                                                        <i class="fas fa-file-medical mr-1"></i>
                                                        @break
                                                    @case('completed')
                                                        <i class="fas fa-check-circle mr-1"></i>
                                                        @break
                                                    @case('cancelled')
                                                        <i class="fas fa-times-circle mr-1"></i>
                                                        @break
                                                @endswitch
                                                {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="font-medium">{{ $order->created_at->format('M d, Y') }}</div>
                                            <div class="text-gray-500">{{ $order->created_at->format('h:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                            ₦{{ number_format($order->total_amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                <a href="{{ route('consumer.orders.show', $order) }}" class="inline-flex items-center px-3 py-1.5 bg-primary-100 text-primary-700 rounded-lg hover:bg-primary-200 transition-colors text-sm font-medium">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    View
                                                </a>
                                                @if($order->status == 'results_ready')
                                                    <a href="#" class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors text-sm font-medium">
                                                        <i class="fas fa-download mr-1"></i>
                                                        Results
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Mobile Card View -->
                    <div class="lg:hidden divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <div class="p-6 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 rounded-lg {{ $order->order_type == 'test' ? 'bg-blue-100' : 'bg-red-100' }} flex items-center justify-center">
                                            @if($order->order_type == 'test')
                                                <i class="fas fa-vial text-blue-600 text-lg"></i>
                                            @else
                                                <i class="fas fa-tint text-red-600 text-lg"></i>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-lg font-semibold text-gray-900">#{{ $order->id }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y • h:i A') }}</div>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
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
                                
                                <div class="space-y-3 mb-4">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">Service Type:</span>
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ $order->order_type == 'test' ? 'Lab Test' : 'Blood Service' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">Facility:</span>
                                        <span class="text-sm font-medium text-gray-900">{{ $order->facility?->name ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">Amount:</span>
                                        <span class="text-sm font-bold text-gray-900">₦{{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('consumer.orders.show', $order) }}" class="inline-flex items-center px-3 py-1.5 bg-primary-100 text-primary-700 rounded-lg hover:bg-primary-200 transition-colors text-sm font-medium">
                                            <i class="fas fa-eye mr-1"></i>
                                            View Details
                                        </a>
                                        @if($order->status == 'results_ready')
                                            <a href="#" class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors text-sm font-medium">
                                                <i class="fas fa-download mr-1"></i>
                                                Download Results
                                            </a>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $order->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Enhanced Pagination -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-500">
                                <span>Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                {{ $orders->links('pagination::tailwind') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function ordersPage() {
            return {
                activeFilter: 'all',
                searchQuery: '',
                dateFilter: 'all',
                sortBy: 'newest',
                
                init() {
                    // Initialize any data or event listeners
                    this.$watch('searchQuery', () => {
                        this.filterOrders();
                    });
                    
                    this.$watch('activeFilter', () => {
                        this.filterOrders();
                    });
                    
                    this.$watch('dateFilter', () => {
                        this.filterOrders();
                    });
                    
                    this.$watch('sortBy', () => {
                        this.filterOrders();
                    });
                },
                
                filterOrders() {
                    // This would typically make an AJAX request to filter orders
                    // For now, we'll just log the filters
                    console.log('Filtering orders:', {
                        filter: this.activeFilter,
                        search: this.searchQuery,
                        date: this.dateFilter,
                        sort: this.sortBy
                    });
                }
            }
        }
    </script>
</x-consumer-dashboard-layout>