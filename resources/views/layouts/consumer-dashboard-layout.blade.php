<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="DHR SPACE - Revolutionary Medical Logistics in Nigeria. Connecting labs, blood banks, and patients through sophisticated technology.">

    <title>{{ config('app.name', 'DHR SPACE') }} - @yield('title', 'Your Health, Our Priority')</title>
    
    <!-- Preload critical resources -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" as="style">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style">
    
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Configure Tailwind with enhanced color palette -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eef7ff',
                            100: '#d6ebff',
                            200: '#b5dcff',
                            300: '#83c9ff',
                            400: '#48acff',
                            500: '#1E88E5',
                            600: '#0068d6',
                            700: '#0053ae',
                            800: '#00458e',
                            900: '#003c75',
                        },
                        secondary: {
                            50: '#f4fbf4',
                            100: '#e3f5e3',
                            200: '#c7eac7',
                            300: '#9cd89c',
                            400: '#6ebe6e',
                            500: '#4CAF50',
                            600: '#358a38',
                            700: '#2b6e2e',
                            800: '#265826',
                            900: '#214a22',
                        },
                        accent: '#FF5722',
                        neutral: {
                            light: '#F5F7FA',
                            dark: '#2A3342'
                        },
                        success: '#10B981',
                        warning: '#F59E0B',
                        error: '#EF4444',
                        info: '#3B82F6'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                        'pulse-slow': 'pulse 3s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- Custom Styles -->
    <style>
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }
        
        .gradient-border {
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(45deg, #1E88E5, #4CAF50) border-box;
            border: 2px solid transparent;
        }
        
        .health-pulse {
            animation: healthPulse 2s infinite;
        }
        
        @keyframes healthPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .notification-dot {
            animation: notificationPulse 2s infinite;
        }
        
        @keyframes notificationPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-white z-50 flex items-center justify-center" style="display: none;">
        <div class="text-center">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600"></div>
            <p class="mt-4 text-gray-600">Loading...</p>
        </div>
    </div>

    <div x-data="{ 
        sidebarOpen: false, 
        notifications: {{ json_encode(session('notifications', [])) }},
        showNotifications: false,
        userMenuOpen: false
    }" class="min-h-screen">
        
        <!-- Mobile sidebar backdrop -->
        <div x-show="sidebarOpen" 
             class="fixed inset-0 z-40 bg-gray-900 bg-opacity-50 lg:hidden" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"></div>

        <!-- Enhanced Mobile sidebar -->
        <div x-show="sidebarOpen" 
             class="fixed inset-y-0 left-0 z-50 w-72 bg-white shadow-2xl lg:hidden"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full">
            
            <!-- Mobile Header -->
            <div class="flex items-center justify-between h-20 px-6 bg-gradient-to-r from-primary-600 to-primary-700">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center mr-3">
                        <i class="fas fa-heartbeat text-white text-lg"></i>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-white">DHR SPACE</span>
                        <p class="text-xs text-primary-100">Your Health Partner</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="text-white hover:text-primary-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- User Info Card -->
            <div class="p-6 bg-gradient-to-br from-primary-50 to-blue-50 border-b">
                <div class="flex items-center">
                    <div class="h-12 w-12 rounded-full bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-4">
                        <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                        <div class="flex items-center mt-1">
                            <div class="h-2 w-2 rounded-full bg-green-400 mr-2"></div>
                            <span class="text-xs text-green-600 font-medium">Active</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('consumer.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('consumer.dashboard') ? 'text-primary-700 bg-primary-50 border-r-4 border-primary-500' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-all duration-200">
                    <div class="h-8 w-8 rounded-lg {{ request()->routeIs('consumer.dashboard') ? 'bg-primary-100' : 'bg-gray-100' }} flex items-center justify-center mr-3">
                        <i class="fas fa-home {{ request()->routeIs('consumer.dashboard') ? 'text-primary-600' : 'text-gray-500' }}"></i>
                    </div>
                    <span>Dashboard</span>
                    @if(request()->routeIs('consumer.dashboard'))
                        <div class="ml-auto h-2 w-2 rounded-full bg-primary-500"></div>
                    @endif
                </a>
                
                <a href="{{ route('consumer.orders.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ (request()->routeIs('consumer.orders.index') || request()->routeIs('consumer.orders.show')) ? 'text-primary-700 bg-primary-50 border-r-4 border-primary-500' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-all duration-200">
                    <div class="h-8 w-8 rounded-lg {{ (request()->routeIs('consumer.orders.index') || request()->routeIs('consumer.orders.show')) ? 'bg-primary-100' : 'bg-gray-100' }} flex items-center justify-center mr-3">
                        <i class="fas fa-clipboard-list {{ (request()->routeIs('consumer.orders.index') || request()->routeIs('consumer.orders.show')) ? 'text-primary-600' : 'text-gray-500' }}"></i>
                    </div>
                    <span>My Orders</span>
                    @if((request()->routeIs('consumer.orders.index') || request()->routeIs('consumer.orders.show')))
                        <div class="ml-auto h-2 w-2 rounded-full bg-primary-500"></div>
                    @endif
                </a>
                
                <a href="{{ route('consumer.orders.create') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('consumer.orders.create') ? 'text-primary-700 bg-primary-50 border-r-4 border-primary-500' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-all duration-200">
                    <div class="h-8 w-8 rounded-lg {{ request()->routeIs('consumer.orders.create') ? 'bg-primary-100' : 'bg-gray-100' }} flex items-center justify-center mr-3">
                        <i class="fas fa-plus {{ request()->routeIs('consumer.orders.create') ? 'text-primary-600' : 'text-gray-500' }}"></i>
                    </div>
                    <span>New Order</span>
                    @if(request()->routeIs('consumer.orders.create'))
                        <div class="ml-auto h-2 w-2 rounded-full bg-primary-500"></div>
                    @endif
                </a>
                
                <a href="{{ route('consumer.profile.edit') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('consumer.profile.edit') ? 'text-primary-700 bg-primary-50 border-r-4 border-primary-500' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-all duration-200">
                    <div class="h-8 w-8 rounded-lg {{ request()->routeIs('consumer.profile.edit') ? 'bg-primary-100' : 'bg-gray-100' }} flex items-center justify-center mr-3">
                        <i class="fas fa-user {{ request()->routeIs('consumer.profile.edit') ? 'text-primary-600' : 'text-gray-500' }}"></i>
                    </div>
                    <span>My Profile</span>
                    @if(request()->routeIs('consumer.profile.edit'))
                        <div class="ml-auto h-2 w-2 rounded-full bg-primary-500"></div>
                    @endif
                </a>

                <!-- Quick Actions -->
                <div class="pt-6 mt-6 border-t border-gray-200">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Quick Actions</p>
                    <div class="space-y-2">
                        <a href="{{ route('consumer.orders.create', ['type' => 'test']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-colors">
                            <i class="fas fa-vial text-blue-500 mr-3"></i>
                            <span>Book Lab Test</span>
                        </a>
                        <a href="{{ route('consumer.orders.create', ['type' => 'blood']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors">
                            <i class="fas fa-tint text-red-500 mr-3"></i>
                            <span>Blood Services</span>
                        </a>
                    </div>
                </div>

                <!-- Logout -->
                <div class="pt-6 mt-6 border-t border-gray-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors">
                            <div class="h-8 w-8 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                                <i class="fas fa-sign-out-alt text-gray-500"></i>
                            </div>
                            <span>Sign Out</span>
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        <!-- Enhanced Desktop sidebar -->
        <div class="hidden lg:flex lg:flex-col lg:w-72 lg:fixed lg:inset-y-0 lg:bg-white lg:shadow-xl lg:border-r lg:border-gray-200">
            <!-- Desktop Header -->
            <div class="flex items-center h-20 px-6 bg-gradient-to-r from-primary-600 to-primary-700">
                <div class="flex items-center">
                    <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center mr-4">
                        <i class="fas fa-heartbeat text-white text-xl"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-bold text-white">DHR SPACE</span>
                        <p class="text-sm text-primary-100">Your Health Partner</p>
                    </div>
                </div>
            </div>
            
            <!-- User Info Card -->
            <div class="p-6 bg-gradient-to-br from-primary-50 to-blue-50 border-b">
                <div class="flex items-center">
                    <div class="h-14 w-14 rounded-full bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-xl shadow-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-4">
                        <p class="font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                        <div class="flex items-center mt-2">
                            <div class="h-2 w-2 rounded-full bg-green-400 mr-2"></div>
                            <span class="text-xs text-green-600 font-medium">Active Account</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('consumer.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('consumer.dashboard') ? 'text-primary-700 bg-primary-50 border-r-4 border-primary-500' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-all duration-200 group">
                    <div class="h-10 w-10 rounded-lg {{ request()->routeIs('consumer.dashboard') ? 'bg-primary-100' : 'bg-gray-100 group-hover:bg-primary-50' }} flex items-center justify-center mr-3 transition-colors">
                        <i class="fas fa-home {{ request()->routeIs('consumer.dashboard') ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-500' }}"></i>
                    </div>
                    <span>Dashboard</span>
                    @if(request()->routeIs('consumer.dashboard'))
                        <div class="ml-auto h-2 w-2 rounded-full bg-primary-500"></div>
                    @endif
                </a>
                
                <a href="{{ route('consumer.orders.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ (request()->routeIs('consumer.orders.index') || request()->routeIs('consumer.orders.show')) ? 'text-primary-700 bg-primary-50 border-r-4 border-primary-500' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-all duration-200 group">
                    <div class="h-10 w-10 rounded-lg {{ (request()->routeIs('consumer.orders.index') || request()->routeIs('consumer.orders.show')) ? 'bg-primary-100' : 'bg-gray-100 group-hover:bg-primary-50' }} flex items-center justify-center mr-3 transition-colors">
                        <i class="fas fa-clipboard-list {{ (request()->routeIs('consumer.orders.index') || request()->routeIs('consumer.orders.show')) ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-500' }}"></i>
                    </div>
                    <span>My Orders</span>
                    @if((request()->routeIs('consumer.orders.index') || request()->routeIs('consumer.orders.show')))
                        <div class="ml-auto h-2 w-2 rounded-full bg-primary-500"></div>
                    @endif
                </a>
                
                <a href="{{ route('consumer.orders.create') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('consumer.orders.create') ? 'text-primary-700 bg-primary-50 border-r-4 border-primary-500' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-all duration-200 group">
                    <div class="h-10 w-10 rounded-lg {{ request()->routeIs('consumer.orders.create') ? 'bg-primary-100' : 'bg-gray-100 group-hover:bg-primary-50' }} flex items-center justify-center mr-3 transition-colors">
                        <i class="fas fa-plus {{ request()->routeIs('consumer.orders.create') ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-500' }}"></i>
                    </div>
                    <span>New Order</span>
                    @if(request()->routeIs('consumer.orders.create'))
                        <div class="ml-auto h-2 w-2 rounded-full bg-primary-500"></div>
                    @endif
                </a>
                
                <a href="{{ route('consumer.profile.edit') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('consumer.profile.edit') ? 'text-primary-700 bg-primary-50 border-r-4 border-primary-500' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg transition-all duration-200 group">
                    <div class="h-10 w-10 rounded-lg {{ request()->routeIs('consumer.profile.edit') ? 'bg-primary-100' : 'bg-gray-100 group-hover:bg-primary-50' }} flex items-center justify-center mr-3 transition-colors">
                        <i class="fas fa-user {{ request()->routeIs('consumer.profile.edit') ? 'text-primary-600' : 'text-gray-500 group-hover:text-primary-500' }}"></i>
                    </div>
                    <span>My Profile</span>
                    @if(request()->routeIs('consumer.profile.edit'))
                        <div class="ml-auto h-2 w-2 rounded-full bg-primary-500"></div>
                    @endif
                </a>

                <!-- Quick Actions -->
                <div class="pt-6 mt-6 border-t border-gray-200">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Quick Actions</p>
                    <div class="space-y-2">
                        <a href="{{ route('consumer.orders.create', ['type' => 'test']) }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition-colors group">
                            <div class="h-8 w-8 rounded-lg bg-blue-100 group-hover:bg-blue-200 flex items-center justify-center mr-3 transition-colors">
                                <i class="fas fa-vial text-blue-500"></i>
                            </div>
                            <span>Book Lab Test</span>
                        </a>
                        <a href="{{ route('consumer.orders.create', ['type' => 'blood']) }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors group">
                            <div class="h-8 w-8 rounded-lg bg-red-100 group-hover:bg-red-200 flex items-center justify-center mr-3 transition-colors">
                                <i class="fas fa-tint text-red-500"></i>
                            </div>
                            <span>Blood Services</span>
                        </a>
                    </div>
                </div>

                <!-- Health Tips -->
                <div class="pt-6 mt-6 border-t border-gray-200">
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-lightbulb text-green-600 mr-2"></i>
                            <span class="text-sm font-semibold text-green-800">Health Tip</span>
                        </div>
                        <p class="text-xs text-green-700">Stay hydrated! Drink at least 8 glasses of water daily for optimal health.</p>
                    </div>
                </div>

                <!-- Logout -->
                <div class="pt-6 mt-6 border-t border-gray-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors group">
                            <div class="h-10 w-10 rounded-lg bg-gray-100 group-hover:bg-red-100 flex items-center justify-center mr-3 transition-colors">
                                <i class="fas fa-sign-out-alt text-gray-500 group-hover:text-red-500"></i>
                            </div>
                            <span>Sign Out</span>
                        </button>
                    </form>
                </div>
            </nav>
        </div>

        <!-- Main content -->
        <div class="lg:pl-72">
            <!-- Enhanced Top navigation for mobile -->
            <div class="sticky top-0 z-30 flex h-16 bg-white/95 backdrop-blur-sm border-b border-gray-200 lg:hidden shadow-sm">
                <button @click="sidebarOpen = true" class="px-4 text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                
                <div class="flex items-center justify-center flex-1 px-4">
                    <a href="{{ route('consumer.dashboard') }}" class="flex items-center">
                        <div class="h-8 w-8 rounded-lg bg-primary-100 flex items-center justify-center mr-2">
                            <i class="fas fa-heartbeat text-primary-600"></i>
                        </div>
                        <span class="text-lg font-bold text-gray-900">DHR SPACE</span>
                    </a>
                </div>
                
                <div class="flex items-center px-4 space-x-3">
                    <!-- Notifications -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="relative p-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 rounded-lg transition-colors">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 rounded-full flex items-center justify-center">
                                <span class="text-xs text-white font-bold">3</span>
                            </span>
                        </button>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center max-w-xs text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center text-white font-semibold shadow-lg">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </button>
                        <div x-show="open" 
                             @click.away="open = false"
                             class="absolute right-0 w-56 py-2 mt-2 origin-top-right bg-white rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('consumer.profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-user mr-3 text-gray-400"></i>
                                My Profile
                            </a>
                            <a href="{{ route('consumer.orders.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-clipboard-list mr-3 text-gray-400"></i>
                                My Orders
                            </a>
                            <div class="border-t border-gray-100 mt-2 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-3 text-gray-400"></i>
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Page header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {{ $header ?? '' }}
                </div>
            </header>

            <!-- Page content with enhanced styling -->
            <main class="min-h-screen">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-4">
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4" x-data="{ show: true }" x-show="show" x-transition>
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <button @click="show = false" class="text-green-400 hover:text-green-600">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-4">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4" x-data="{ show: true }" x-show="show" x-transition>
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <button @click="show = false" class="text-red-400 hover:text-red-600">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Enhanced loading states
        function showLoading() {
            document.getElementById('loading-overlay').style.display = 'flex';
        }
        
        function hideLoading() {
            document.getElementById('loading-overlay').style.display = 'none';
        }
        
        // Auto-hide flash messages
        setTimeout(() => {
            const alerts = document.querySelectorAll('[x-data*="show: true"]');
            alerts.forEach(alert => {
                if (alert.__x) {
                    alert.__x.$data.show = false;
                }
            });
        }, 5000);
        
        // Enhanced form submissions
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
                    }
                });
            });
        });
    </script>
</body>
</html>