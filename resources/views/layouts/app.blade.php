<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DHR SPACE - Revolutionary Medical Logistics Platform in Nigeria | Seamless Lab Tests and Blood Donations">
    <title>DHR SPACE - Advanced Medical Logistics Platform</title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link
    href="https://api.mapbox.com/mapbox-gl-js/v2.6.0/mapbox-gl.css"
    rel="stylesheet"
/>
<script src="https://api.mapbox.com/mapbox-gl-js/v2.6.0/mapbox-gl.js"></script>
    <!-- Configure Tailwind with our color palette -->
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
                        }
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        display: ['Montserrat', 'sans-serif']
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                        'lab-pattern': "url('/images/lab-pattern.svg')",
                    },
                    keyframes: {
                        'float': {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        'pulse-ring': {
                            '0%': { transform: 'scale(0.5)', opacity: '0' },
                            '50%': { opacity: '0.5' },
                            '100%': { transform: 'scale(1.5)', opacity: '0' },
                        },
                        'morph': {
                            '0%': { borderRadius: '60% 40% 30% 70% / 60% 30% 70% 40%' },
                            '50%': { borderRadius: '30% 60% 70% 40% / 50% 60% 30% 60%' },
                            '100%': { borderRadius: '60% 40% 30% 70% / 60% 30% 70% 40%' },
                        },
                        'shimmer': {
                            '0%': { backgroundPosition: '-1000px 0' },
                            '100%': { backgroundPosition: '1000px 0' },
                        },
                        'scroll-x': {
                            '0%': { transform: 'translateX(0)' },
                            '100%': { transform: 'translateX(-100%)' },
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-slow': 'float 8s ease-in-out infinite',
                        'float-fast': 'float 4s ease-in-out infinite',
                        'pulse-ring': 'pulse-ring 1.5s cubic-bezier(0.215, 0.61, 0.355, 1) infinite',
                        'morph': 'morph 15s linear infinite alternate',
                        'shimmer': 'shimmer 2s infinite linear',
                        'scroll-x': 'scroll-x 30s linear infinite',
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- GSAP Animation Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Lottie Player for advanced animations -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    
    <!-- Three.js for 3D elements -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/animations.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(30, 136, 229, 0.7);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(30, 136, 229, 1);
        }
    </style>
</head>
<body class="bg-white text-neutral-dark">
    <!-- Navigation -->
    <nav id="navbar" class="fixed w-full bg-white/90 backdrop-blur-md z-50 transition-all duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="group flex items-center gap-2 transition-all duration-300">
                        <img src="{{ asset('images/dhrlogo.jpg') }}" alt="DHR SPACE Logo" class="h-10 w-auto group-hover:scale-110 transition-transform">
                        <span class="text-primary-600 font-display font-bold text-xl group-hover:text-primary-500 transition-colors hidden sm:inline">
                            DHR<span class="text-secondary-500"> SPACE</span>
                        </span>
                    </a>
                </div>
                
                <!-- Mobile menu button -->
                <div class="flex md:hidden">
                    <button type="button" id="mobile-menu-button" class="text-neutral-dark hover:text-primary-500 focus:outline-none relative overflow-hidden transition-all duration-300 ease-out">
                        <span class="sr-only">Open main menu</span>
                        <div class="w-8 h-8 flex items-center justify-center transform transition-all duration-300">
                            <span class="hamburger-line"></span>
                        </div>
                    </button>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex md:items-center md:space-x-8">
                    <a href="#home" class="hover-link text-neutral-dark hover:text-primary-500 px-3 py-2 text-sm font-medium transition-colors duration-300">Home</a>
                    <a href="#services" class="hover-link text-neutral-dark hover:text-primary-500 px-3 py-2 text-sm font-medium transition-colors duration-300">Services</a>
                    <a href="#how-it-works" class="hover-link text-neutral-dark hover:text-primary-500 px-3 py-2 text-sm font-medium transition-colors duration-300">How It Works</a>
                    <a href="#contact" class="hover-link text-neutral-dark hover:text-primary-500 px-3 py-2 text-sm font-medium transition-colors duration-300">Contact</a>
                    
                    @guest
                        <a href="{{ route('login') }}" class="hover-link text-neutral-dark hover:text-primary-500 px-3 py-2 text-sm font-medium transition-colors duration-300">Login</a>
                        <a href="{{ route('register') }}" class="magnetic-btn group relative bg-primary-500 text-white px-7 py-3 rounded-full text-sm font-medium transition-all duration-300 hover:bg-primary-600 hover:shadow-lg hover:shadow-primary-500/20 overflow-hidden">
                            <span class="relative z-10 font-medium">Register</span>
                            <span class="absolute top-0 left-0 w-full h-full bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                        </a>
                    @else
                        <div class="relative group">
                            <button class="flex items-center hover-link text-neutral-dark hover:text-primary-500 px-3 py-2 text-sm font-medium transition-colors duration-300">
                                <span>{{ Auth::user()->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-10 hidden group-hover:block">
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('filament.admin.pages.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50">Admin Dashboard</a>
                                @elseif(Auth::user()->role === 'provider')
                                    <a href="{{ route('filament.provider.pages.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50">Provider Dashboard</a>
                                @elseif(Auth::user()->role === 'biker')
                                    <a href="{{ route('filament.biker.pages.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50">Biker Dashboard</a>
                                @elseif(Auth::user()->role === 'consumer')
                                    <a href="{{ route('consumer.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50">My Dashboard</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-primary-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
            
            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="md:hidden hidden transform transition-all duration-500 ease-in-out -translate-y-10 opacity-0 h-0">
                <div class="px-2 pt-2 pb-3 space-y-3 sm:px-3">
                    <a href="#home" class="block px-3 py-2 text-base font-medium text-neutral-dark hover:text-primary-500 transition-colors duration-300 micro-interaction">Home</a>
                    <a href="#services" class="block px-3 py-2 text-base font-medium text-neutral-dark hover:text-primary-500 transition-colors duration-300 micro-interaction">Services</a>
                    <a href="#how-it-works" class="block px-3 py-2 text-base font-medium text-neutral-dark hover:text-primary-500 transition-colors duration-300 micro-interaction">How It Works</a>
                    <a href="#contact" class="block px-3 py-2 text-base font-medium text-neutral-dark hover:text-primary-500 transition-colors duration-300 micro-interaction">Contact</a>
                    
                    @guest
                        <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-neutral-dark hover:text-primary-500 transition-colors duration-300 micro-interaction">Login</a>
                        <a href="{{ route('register') }}" class="block mt-4 bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-full text-sm font-medium text-center transition-all duration-300 hover:shadow-lg hover:shadow-primary-500/20">Register</a>
                    @else
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('filament.admin.pages.dashboard') }}" class="block px-3 py-2 text-base font-medium text-neutral-dark hover:text-primary-500 transition-colors duration-300 micro-interaction">Admin Dashboard</a>
                        @elseif(Auth::user()->role === 'provider')
                            <a href="{{ route('filament.provider.pages.dashboard') }}" class="block px-3 py-2 text-base font-medium text-neutral-dark hover:text-primary-500 transition-colors duration-300 micro-interaction">Provider Dashboard</a>
                        @elseif(Auth::user()->role === 'biker')
                            <a href="{{ route('filament.biker.pages.dashboard') }}" class="block px-3 py-2 text-base font-medium text-neutral-dark hover:text-primary-500 transition-colors duration-300 micro-interaction">Biker Dashboard</a>
                        @elseif(Auth::user()->role === 'consumer')
                            <a href="{{ route('consumer.dashboard') }}" class="block px-3 py-2 text-base font-medium text-neutral-dark hover:text-primary-500 transition-colors duration-300 micro-interaction">My Dashboard</a>
                        @endif
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block mt-4 bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-full text-sm font-medium text-center transition-all duration-300 hover:shadow-lg hover:shadow-red-500/20 w-full">Logout</button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="relative bg-neutral-dark text-white pt-20 pb-12 overflow-hidden">
        <!-- DNA Animation -->
        <div class="dna-container">
            <div class="dna-helix">
                <div class="strand strand-1">
                    @for ($i = 0; $i < 20; $i++)
                        <span style="top: {{ $i * 30 }}px; transform: rotateZ({{ $i * 18 }}deg)"></span>
                    @endfor
                </div>
                <div class="strand strand-2">
                    @for ($i = 0; $i < 20; $i++)
                        <span style="top: {{ $i * 30 }}px; transform: rotateZ({{ $i * 18 }}deg)"></span>
                    @endfor
                </div>
                @for ($i = 0; $i < 20; $i++)
                    <div class="connector" style="top: {{ $i * 30 + 4 }}px; transform: rotateZ({{ $i * 18 }}deg)"></div>
                @endfor
            </div>
        </div>
        
        <!-- Morphing background -->
        <div class="morphing-bg" style="top: 50%; left: 80%; opacity: 0.05;"></div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div data-aos="fade-right" data-aos-delay="100">
                    <div class="group flex items-center gap-2 mb-4">
                        <img src="{{ asset('images/dhrlogo.jpg') }}" alt="DHR SPACE Logo" class="h-10 w-auto">
                        <span class="text-white font-display font-bold text-xl">
                            D' Health<span class="text-secondary-500"> Rides</span>
                        </span>
                    </div>
                    <p class="text-gray-300 mb-6">Revolutionizing Nigeria's medical logistics through cutting-edge technology and innovative solutions.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="group w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-primary-500 transition-all duration-300">
                            <i class="fab fa-twitter text-gray-300 group-hover:text-white transition-colors"></i>
                        </a>
                        <a href="#" class="group w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-primary-500 transition-all duration-300">
                            <i class="fab fa-facebook-f text-gray-300 group-hover:text-white transition-colors"></i>
                        </a>
                        <a href="#" class="group w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-primary-500 transition-all duration-300">
                            <i class="fab fa-instagram text-gray-300 group-hover:text-white transition-colors"></i>
                        </a>
                        <a href="#" class="group w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-primary-500 transition-all duration-300">
                            <i class="fab fa-linkedin-in text-gray-300 group-hover:text-white transition-colors"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div data-aos="fade-right" data-aos-delay="200">
                    <h3 class="text-lg font-display font-semibold mb-6 relative inline-block">
                        Quick Links
                        <span class="absolute -bottom-2 left-0 w-12 h-1 bg-secondary-500"></span>
                    </h3>
                    <ul class="space-y-3">
                        <li><a href="#home" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center group">
                            <span class="w-2 h-2 bg-secondary-500 rounded-full mr-2 opacity-0 group-hover:opacity-100 transform scale-0 group-hover:scale-100 transition-all duration-300"></span>Home</a>
                        </li>
                        <li><a href="#services" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center group">
                            <span class="w-2 h-2 bg-secondary-500 rounded-full mr-2 opacity-0 group-hover:opacity-100 transform scale-0 group-hover:scale-100 transition-all duration-300"></span>Services</a>
                        </li>
                        <li><a href="#how-it-works" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center group">
                            <span class="w-2 h-2 bg-secondary-500 rounded-full mr-2 opacity-0 group-hover:opacity-100 transform scale-0 group-hover:scale-100 transition-all duration-300"></span>How It Works</a>
                        </li>
                        <li><a href="#contact" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center group">
                            <span class="w-2 h-2 bg-secondary-500 rounded-full mr-2 opacity-0 group-hover:opacity-100 transform scale-0 group-hover:scale-100 transition-all duration-300"></span>Contact</a>
                        </li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center group">
                            <span class="w-2 h-2 bg-secondary-500 rounded-full mr-2 opacity-0 group-hover:opacity-100 transform scale-0 group-hover:scale-100 transition-all duration-300"></span>Privacy Policy</a>
                        </li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div data-aos="fade-right" data-aos-delay="300">
                    <h3 class="text-lg font-display font-semibold mb-6 relative inline-block">
                        Contact Us
                        <span class="absolute -bottom-2 left-0 w-12 h-1 bg-secondary-500"></span>
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex items-start group">
                            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mr-3 group-hover:bg-primary-500 transition-colors duration-300">
                                <i class="fas fa-envelope text-gray-300 group-hover:text-white transition-colors"></i>
                            </div>
                            <div>
                                <p class="text-white font-medium">Email</p>
                                <a href="mailto:info@dhealthrides.ng" class="text-gray-300 hover:text-white transition-colors">info@dhealthrides.ng</a>
                            </div>
                        </li>
                        <li class="flex items-start group">
                            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mr-3 group-hover:bg-primary-500 transition-colors duration-300">
                                <i class="fas fa-phone text-gray-300 group-hover:text-white transition-colors"></i>
                            </div>
                            <div>
                                <p class="text-white font-medium">Phone</p>
                                <a href="tel:+2348000000000" class="text-gray-300 hover:text-white transition-colors">+234-XXX-XXX-XXXX</a>
                            </div>
                        </li>
                        <li class="flex items-start group">
                            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mr-3 group-hover:bg-primary-500 transition-colors duration-300">
                                <i class="fas fa-map-marker-alt text-gray-300 group-hover:text-white transition-colors"></i>
                            </div>
                            <div>
                                <p class="text-white font-medium">Address</p>
                                <span class="text-gray-300">Bauchi, Nigeria</span>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <!-- Newsletter -->
                <div data-aos="fade-right" data-aos-delay="400">
                    <h3 class="text-lg font-display font-semibold mb-6 relative inline-block">
                        Stay Updated
                        <span class="absolute -bottom-2 left-0 w-12 h-1 bg-secondary-500"></span>
                    </h3>
                    <p class="text-gray-300 mb-6">Subscribe to our newsletter for the latest updates on medical logistics innovations.</p>
                    <form class="relative">
                        <input type="email" placeholder="Your email address" class="w-full pl-5 pr-32 py-4 rounded-full text-neutral-dark focus:outline-none focus:ring-2 focus:ring-primary-500 transition-all duration-300">
                        <button type="submit" class="absolute right-1 top-1 bottom-1 px-6 bg-primary-500 hover:bg-primary-600 text-white rounded-full text-sm font-medium transition-colors duration-300">Subscribe</button>
                    </form>
                    <p class="text-gray-400 text-sm mt-4">We respect your privacy. No spam, ever.</p>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-12 pt-8 text-center">
                <p class="text-gray-400">© {{ date('Y') }} DHR SPACE. All rights reserved.</p>
                <p class="text-gray-500 text-sm mt-2">Transforming medical logistics in Nigeria through innovation.</p>
            </div>
        </div>
    </footer>

    <!-- Custom JS -->
    <script src="{{ asset('js/animations.js') }}"></script>
    
    <!-- JavaScript for interactions -->
    <script>
        // Mobile menu toggle with animation
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        let menuOpen = false;
        
        if (mobileMenuButton) {
            // Create hamburger icon with CSS
            const buttonSpan = document.createElement('span');
            buttonSpan.className = 'relative block w-6 h-0.5 bg-neutral-dark rounded transition-all duration-300';
            mobileMenuButton.querySelector('.hamburger-line').appendChild(buttonSpan);
            
            // Create before pseudo-element
            const beforeSpan = document.createElement('span');
            beforeSpan.className = 'absolute block w-6 h-0.5 bg-neutral-dark rounded transition-all duration-300 -mt-2';
            mobileMenuButton.querySelector('.hamburger-line').appendChild(beforeSpan);
            
            // Create after pseudo-element
            const afterSpan = document.createElement('span');
            afterSpan.className = 'absolute block w-6 h-0.5 bg-neutral-dark rounded transition-all duration-300 mt-2';
            mobileMenuButton.querySelector('.hamburger-line').appendChild(afterSpan);
            
            mobileMenuButton.addEventListener('click', () => {
                menuOpen = !menuOpen;
                
                if (menuOpen) {
                    mobileMenu.classList.remove('hidden', '-translate-y-10', 'opacity-0', 'h-0');
                    mobileMenu.classList.add('translate-y-0', 'opacity-100');
                    
                    // Animate hamburger to X
                    buttonSpan.classList.add('bg-transparent');
                    beforeSpan.classList.add('rotate-45', 'translate-y-2', 'bg-primary-500');
                    afterSpan.classList.add('-rotate-45', '-translate-y-2', 'bg-primary-500');
                } else {
                    mobileMenu.classList.remove('translate-y-0', 'opacity-100');
                    mobileMenu.classList.add('-translate-y-10', 'opacity-0');
                    
                    // Reset hamburger
                    buttonSpan.classList.remove('bg-transparent');
                    beforeSpan.classList.remove('rotate-45', 'translate-y-2', 'bg-primary-500');
                    afterSpan.classList.remove('-rotate-45', '-translate-y-2', 'bg-primary-500');
                    
                    // Hide menu after animation completes
                    setTimeout(() => {
                        mobileMenu.classList.add('hidden', 'h-0');
                    }, 500);
                }
            });
        }
        
        // Navbar styling on scroll
        const navbar = document.getElementById('navbar');
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-md', 'py-1');
                navbar.classList.remove('py-2');
            } else {
                navbar.classList.remove('shadow-md', 'py-1');
                navbar.classList.add('py-2');
            }
        });
        
        // Magnetic buttons
        document.addEventListener('DOMContentLoaded', function() {
            const magneticBtns = document.querySelectorAll('.magnetic-btn');
            
            magneticBtns.forEach(btn => {
                btn.addEventListener('mousemove', function(e) {
                    const btnRect = this.getBoundingClientRect();
                    const btnX = e.clientX - btnRect.left;
                    const btnY = e.clientY - btnRect.top;
                    
                    const xc = btnRect.width / 2;
                    const yc = btnRect.height / 2;
                    
                    const dx = btnX - xc;
                    const dy = btnY - yc;
                    
                    this.style.transform = `perspective(500px) rotateY(${dx / 20}deg) rotateX(${-dy / 20}deg) translateZ(10px)`;
                });
                
                btn.addEventListener('mouseleave', function() {
                    this.style.transform = 'perspective(500px) rotateY(0) rotateX(0) translateZ(0)';
                });
            });
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    // Close mobile menu if open
                    if (menuOpen) {
                        menuOpen = false;
                        mobileMenu.classList.remove('translate-y-0', 'opacity-100');
                        mobileMenu.classList.add('-translate-y-10', 'opacity-0', 'hidden', 'h-0');
                        
                        // Reset hamburger
                        const buttonSpan = mobileMenuButton.querySelector('.hamburger-line span');
                        const beforeSpan = mobileMenuButton.querySelector('.hamburger-line span:nth-child(2)');
                        const afterSpan = mobileMenuButton.querySelector('.hamburger-line span:nth-child(3)');
                        
                        if (buttonSpan) buttonSpan.classList.remove('bg-transparent');
                        if (beforeSpan) beforeSpan.classList.remove('rotate-45', 'translate-y-2', 'bg-primary-500');
                        if (afterSpan) afterSpan.classList.remove('-rotate-45', '-translate-y-2', 'bg-primary-500');
                    }
                    
                    // Smooth scroll with a little bit of easing
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>
