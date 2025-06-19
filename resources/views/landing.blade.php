@extends('layouts.app')

@section('content')
<!-- Enhanced DHR SPACE Preloader -->
<div class="preloader fixed inset-0 z-50 bg-gradient-to-br from-gray-50 to-primary-50 flex items-center justify-center overflow-hidden">
    <!-- Subtle Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-primary-200 rounded-full blur-xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-48 h-48 bg-secondary-200 rounded-full blur-xl"></div>
        <div class="absolute top-3/4 left-3/4 w-24 h-24 bg-orange-200 rounded-full blur-xl"></div>
    </div>
    
    <!-- Main Preloader Container -->
    <div class="relative z-10 text-center max-w-md mx-auto px-6">
        
        <!-- Logo Section -->
        <div class="mb-8 fade-in-up">
            <div class="relative inline-block">
                <!-- Main Logo Container -->
                <div class="relative w-24 h-24 mx-auto mb-6">
                    <!-- Outer Ring Animation -->
                    <div class="absolute inset-0 rounded-full border-2 border-primary-200"></div>
                    <div class="absolute inset-0 rounded-full border-2 border-primary-500 pulse-ring"></div>
                    
                    <!-- Logo Image -->
                    <div class="absolute inset-2 rounded-full overflow-hidden bg-white shadow-lg flex items-center justify-center">
                        <img src="/images/dhrlogo.jpg" alt="DHR SPACE Logo" class="w-16 h-16 object-contain">
                    </div>
                    
                    <!-- Rotating Medical Icons -->
                    <div class="absolute inset-0 rotate">
                        <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 w-6 h-6 bg-primary-500 rounded-full flex items-center justify-center text-white text-xs">
                            🧬
                        </div>
                        <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-6 h-6 bg-secondary-500 rounded-full flex items-center justify-center text-white text-xs">
                            🩺
                        </div>
                        <div class="absolute -left-2 top-1/2 transform -translate-y-1/2 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center text-white text-xs heartbeat">
                            ❤️
                        </div>
                        <div class="absolute -right-2 top-1/2 transform -translate-y-1/2 w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center text-white text-xs">
                            🔬
                        </div>
                    </div>
                </div>
                
                <!-- Brand Name -->
                <h1 class="text-3xl font-bold text-gray-800 mb-2">DHR SPACE</h1>
                <p class="text-primary-600 font-medium">Medical Logistics Platform</p>
            </div>
        </div>
        
        <!-- Medical Services Illustration -->
        <div class="mb-8 fade-in-up" style="animation-delay: 0.5s;">
            <div class="flex justify-center items-center space-x-8">
                <!-- Lab Icon -->
                <div class="text-center float medical-icon">
                    <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center mb-2 mx-auto">
                        <span class="text-primary-600 text-2xl">🧪</span>
                    </div>
                    <p class="text-xs text-gray-600 font-medium">Labs</p>
                </div>
                
                <!-- Connection Line -->
                <div class="flex-1 h-px bg-gradient-to-r from-primary-200 via-secondary-200 to-orange-200"></div>
                
                <!-- DHR Hub -->
                <div class="text-center heartbeat medical-icon">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-xl flex items-center justify-center mb-2 mx-auto shadow-lg">
                        <span class="text-white text-2xl">🏥</span>
                    </div>
                    <p class="text-xs text-gray-700 font-bold">DHR SPACE</p>
                </div>
                
                <!-- Connection Line -->
                <div class="flex-1 h-px bg-gradient-to-r from-orange-200 via-red-200 to-primary-200"></div>
                
                <!-- Blood Bank Icon -->
                <div class="text-center float medical-icon" style="animation-delay: 1s;">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-2 mx-auto">
                        <span class="text-red-600 text-2xl">🩸</span>
                    </div>
                    <p class="text-xs text-gray-600 font-medium">Blood Banks</p>
                </div>
            </div>
        </div>
        
        <!-- Loading Progress -->
        <div class="mb-6 fade-in-up" style="animation-delay: 1s;">
            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-primary-500 via-secondary-500 to-orange-500 rounded-full loading-bar"></div>
            </div>
            <p class="text-gray-600 text-sm mt-3 loading-text-status">Connecting to medical network...</p>
        </div>
        
        <!-- Features Highlight -->
        <div class="fade-in-up" style="animation-delay: 1.5s;">
            <div class="grid grid-cols-2 gap-4 text-center">
                <div class="float" style="animation-delay: 0.2s;">
                    <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <span class="text-primary-600 text-sm">🔬</span>
                    </div>
                    <p class="text-xs text-gray-600">Lab Tests</p>
                </div>
                <div class="float" style="animation-delay: 0.4s;">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <span class="text-red-600 text-sm">🩸</span>
                    </div>
                    <p class="text-xs text-gray-600">Blood Services</p>
                </div>
            </div>
        </div>
        
        <!-- Tagline -->
        <div class="mt-8 fade-in-up" style="animation-delay: 2s;">
            <p class="text-gray-500 text-sm max-w-xs mx-auto leading-relaxed">
                Connecting healthcare providers and patients across Nigeria
            </p>
        </div>
    </div>
</div>

<!-- Preloader Styles -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
    
    @keyframes pulse-ring {
        0% {
            transform: scale(0.9);
            opacity: 1;
        }
        100% {
            transform: scale(1.8);
            opacity: 0;
        }
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-8px);
        }
    }
    
    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes heartbeat {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }
    
    @keyframes loadingProgress {
        0% { width: 0%; }
        30% { width: 30%; }
        60% { width: 60%; }
        100% { width: 100%; }
    }
    
    .pulse-ring {
        animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
    }
    
    .float {
        animation: float 3s ease-in-out infinite;
    }
    
    .rotate {
        animation: rotate 6s linear infinite;
    }
    
    .fade-in-up {
        animation: fadeInUp 1s ease-out forwards;
    }
    
    .heartbeat {
        animation: heartbeat 2s ease-in-out infinite;
    }
    
    .loading-bar {
        width: 0%;
        animation: loadingProgress 3s ease-in-out forwards;
    }
    
    .medical-icon {
        filter: drop-shadow(0 4px 6px rgba(30, 136, 229, 0.2));
    }
    
    .preloader {
        font-family: 'Inter', sans-serif;
    }
</style>

<!-- Preloader Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Loading text rotation
        const loadingTexts = [
            "Connecting to medical network...",
            "Syncing with laboratories...",
            "Accessing blood bank data...",
            "Preparing your dashboard...",
            "Loading DHR SPACE platform..."
        ];
        
        let currentTextIndex = 0;
        const loadingTextElement = document.querySelector('.loading-text-status');
        
        function rotateLoadingText() {
            if (loadingTextElement) {
                loadingTextElement.style.opacity = '0.5';
                setTimeout(() => {
                    currentTextIndex = (currentTextIndex + 1) % loadingTexts.length;
                    loadingTextElement.textContent = loadingTexts[currentTextIndex];
                    loadingTextElement.style.opacity = '1';
                }, 200);
            }
        }
        
        // Rotate loading text every 1.5 seconds
        const textInterval = setInterval(rotateLoadingText, 1500);
        
        // Add subtle mouse interaction
        document.addEventListener('mousemove', (e) => {
            const centerX = window.innerWidth / 2;
            const centerY = window.innerHeight / 2;
            const deltaX = (e.clientX - centerX) / centerX;
            const deltaY = (e.clientY - centerY) / centerY;
            
            const floatingElements = document.querySelectorAll('.float');
            floatingElements.forEach((element, index) => {
                const factor = (index + 1) * 2;
                element.style.transform = `translateY(${deltaY * factor}px) translateX(${deltaX * factor}px)`;
            });
        });
        
        // Hide preloader after page loads
        window.addEventListener('load', function() {
            setTimeout(() => {
                const preloader = document.querySelector('.preloader');
                if (preloader) {
                    preloader.style.opacity = '0';
                    preloader.style.transition = 'opacity 0.5s ease-out';
                    setTimeout(() => {
                        preloader.style.display = 'none';
                        clearInterval(textInterval);
                    }, 500);
                }
            }, 2000); // Show for 2 seconds after page load
        });
    });
</script>

<!-- Custom Cursor -->
<div class="custom-cursor hidden md:block"></div>
<div class="cursor-dot hidden md:block"></div>

<!-- Hero Section with Animated Elements -->
<section id="home" class="relative min-h-screen pt-32 pb-20 flex items-center overflow-hidden">
    <!-- Background and decorative elements -->
    <div class="absolute inset-0 z-0 bg-gradient-to-br from-primary-50 to-neutral-light overflow-hidden">
        <!-- Animated laboratory pattern -->
        <div class="absolute inset-0 opacity-5 pattern-grid-lg"></div>
        
        <!-- Floating DNA strands -->
        <div class="absolute top-20 right-20 w-32 h-64 opacity-10">
            <svg viewBox="0 0 100 400" xmlns="http://www.w3.org/2000/svg">
                <path d="M50,0 L50,400" stroke="#1E88E5" stroke-width="2" stroke-dasharray="10,10" />
                @for ($i = 0; $i < 20; $i++)
                    <line x1="10" y1="{{ $i * 20 }}" x2="90" y2="{{ $i * 20 }}" stroke="#4CAF50" stroke-width="2" />
                @endfor
            </svg>
        </div>
        
        <!-- Animated particles -->
        <div id="particles-container" class="absolute inset-0 z-0"></div>
        
        <!-- Morphing blobs -->
        <div class="morphing-bg top-1/4 left-1/4 opacity-10 animate-morph"></div>
        <div class="morphing-bg bottom-1/4 right-1/4 opacity-10 animate-morph" style="animation-delay: -7s;"></div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row items-center">
            <!-- Hero content -->
            <div class="w-full lg:w-2/3 text-center lg:text-left mb-12 lg:mb-0" data-aos="fade-right">
                <h1 class="text-2xl md:text-4xl lg:text-5xl font-display font-bold mb-6 text-neutral-dark leading-tight typing-animation">
                    <span class="relative inline-block">
                        <span class="relative z-10">Revolutionary</span>
                        <span class="absolute bottom-0 left-0 w-full h-3 bg-secondary-200 -z-10 transform -rotate-1"></span>
                    </span>
                    <br/>Medical Logistics in Nigeria
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-xl mx-auto lg:mx-0">
                    Connecting labs, blood banks, and patients through a sophisticated technology platform for seamless lab tests and blood donations.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="#services" class="group relative px-8 py-4 bg-primary-500 text-white rounded-xl text-lg font-medium overflow-hidden shadow-lg shadow-primary-500/20 transition-all duration-300 hover:shadow-xl hover:shadow-primary-500/30 hover:scale-105 pulse-element">
                        <span class="relative z-10">Get Started</span>
                        <span class="absolute inset-0 bg-gradient-to-r from-primary-600 to-primary-500 group-hover:scale-110 transition-transform duration-500"></span>
                    </a>
                    <a href="#how-it-works" class="px-8 py-4 bg-white text-primary-600 rounded-xl text-lg font-medium border-2 border-primary-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2">
                        <span>How It Works</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-pulse" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                <!-- Trust badges -->
                <div class="mt-12 flex flex-wrap justify-center lg:justify-start items-center gap-6">
                    <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium">ISO Certified</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium">NAFDAC Approved</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium">24/7 Support</span>
                    </div>
                </div>
            </div>
            
            <!-- Hero 3D illustration -->
            <div class="w-full lg:w-1/2 relative" data-aos="fade-left" data-aos-delay="200">
                <div class="relative">
                    <!-- 3D Medical Illustration -->
                    <div class="w-full h-[500px] relative">
                        <!-- Main image with animation -->
                        <img src="https://images.unsplash.com/photo-1581093588401-fbb62a02f120?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Medical Laboratory" class="w-full h-full object-cover rounded-xl shadow-2xl animate-float" />
                        
                        <!-- Floating elements -->
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-secondary-100 rounded-2xl shadow-lg animate-float-fast transform rotate-12 flex items-center justify-center">
                            <i class="fas fa-flask text-4xl text-secondary-500"></i>
                        </div>
                        
                        <div class="absolute -bottom-8 left-10 w-24 h-24 bg-primary-100 rounded-full shadow-lg animate-float-slow flex items-center justify-center">
                            <i class="fas fa-heartbeat text-3xl text-primary-500 heartbeat"></i>
                        </div>
                        
                        <div class="absolute top-1/3 -left-12 w-28 h-28 bg-accent/10 rounded-lg shadow-lg animate-float transform -rotate-6 flex items-center justify-center">
                            <i class="fas fa-vial text-3xl text-accent"></i>
                        </div>
                        
                        <!-- Animated 3D canvas -->
                        <canvas id="lab-3d-scene" class="absolute inset-0 w-full h-full opacity-30 pointer-events-none"></canvas>
                        
                        <!-- Floating stats cards -->
                        <div class="absolute top-10 right-1/4 bg-white/90 backdrop-blur-sm shadow-lg rounded-xl p-3 transform rotate-3 animate-float-slow">
                            <div class="flex items-center gap-3">
                                <div class="bg-red-100 p-2 rounded-lg">
                                    <i class="fas fa-heartbeat text-red-500 heartbeat"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Blood Donations</p>
                                    <p class="font-bold stat-counter" data-target="34567">0</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="absolute bottom-14 right-10 bg-white/90 backdrop-blur-sm shadow-lg rounded-xl p-3 transform -rotate-3 animate-float">
                            <div class="flex items-center gap-3">
                                <div class="bg-blue-100 p-2 rounded-lg">
                                    <i class="fas fa-flask text-blue-500"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Lab Tests</p>
                                    <p class="font-bold stat-counter" data-target="98432">0</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Partnership Logos -->
        <div class="mt-20 px-4" data-aos="fade-up" data-aos-delay="300">
            <p class="text-center text-gray-500 font-medium mb-8">Trusted by Nigeria's Leading Healthcare Institutions</p>
            <div class="scrolling-marquee bg-white/50 backdrop-blur-sm rounded-xl p-6 shadow-sm">
                <div class="scrolling-marquee-content flex items-center">
                    @php
                        $logos = [
                            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRaGrv6ramRNb8GP4vQpodMeE51oe1nnMeSbYQDKNRPNOJWgj-05uWH3iSL7JfqUHQBDwM&usqp=CAU', 
                            'https://upload.wikimedia.org/wikipedia/en/7/74/LASUTH_Logo.jpg',
                            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTKE4lU8YIgSCH4s6sMRmQzRrU_OuieJlPYJQ&s',
                            'https://www.atbuth.gov.ng/assets/img/logo.png',
                            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR_mgnUO9thiS0lYmKnsnr6yMhazQ0eZ9PnMQ&s',
                            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRjZGwzvw0nxX2W9bYep6ujyc0KbxzySxUDpg&s', 
                            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTYFa9960Sf9Jnoe67tJyqjC_ekUNNPq4vVSA&s', 
                            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSzO6FuLkYvEY24knpwm4GJF6xySiabdMOziA&s',
                           ];
                    @endphp

                    @foreach ($logos as $logoUrl)
                        <div class="inline-block mx-8 flex-shrink-0">
                            <img src="{{ $logoUrl }}" alt="Partner Logo" class="h-10 md:h-12 max-w-[150px] object-contain filter grayscale hover:grayscale-0 transition-all duration-200">
                        </div>
                    @endforeach

                    <!-- Duplicate for infinite scroll -->
                    @foreach ($logos as $logoUrl)
                        <div class="inline-block mx-8 flex-shrink-0">
                            <img src="{{ $logoUrl }}" alt="Partner Logo" class="h-10 md:h-12 max-w-[150px] object-contain filter grayscale hover:grayscale-0 transition-all duration-200">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bottom wave -->
    <div class="absolute bottom-0 left-0 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 180">
            <path fill="#FFFFFF" fill-opacity="1" d="M0,128L60,117.3C120,107,240,85,360,96C480,107,600,149,720,154.7C840,160,960,128,1080,112C1200,96,1320,96,1380,96L1440,96L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
        </svg>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section py-16 bg-white relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Stat 1 -->
            <div class="stat-item bg-white rounded-xl shadow-md p-6 text-center hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hospital text-primary-600 text-2xl"></i>
                </div>
                <h3 class="text-4xl font-bold mb-2 text-neutral-dark stat-counter" data-target="120">0</h3>
                <p class="text-gray-500">Partner Hospitals</p>
            </div>
            
            <!-- Stat 2 -->
            <div class="stat-item bg-white rounded-xl shadow-md p-6 text-center hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 rounded-full bg-secondary-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-flask text-secondary-600 text-2xl"></i>
                </div>
                <h3 class="text-4xl font-bold mb-2 text-neutral-dark stat-counter" data-target="450">0</h3>
                <p class="text-gray-500">Labs Connected</p>
            </div>
            
            <!-- Stat 3 -->
            <div class="stat-item bg-white rounded-xl shadow-md p-6 text-center hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heartbeat text-red-600 text-2xl heartbeat"></i>
                </div>
                <h3 class="text-4xl font-bold mb-2 text-neutral-dark stat-counter" data-target="25000">0</h3>
                <p class="text-gray-500">Blood Donations</p>
            </div>
            
            <!-- Stat 4 -->
            <div class="stat-item bg-white rounded-xl shadow-md p-6 text-center hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-4xl font-bold mb-2 text-neutral-dark stat-counter" data-target="98000">0</h3>
                <p class="text-gray-500">Patients Served</p>
            </div>
        </div>
    </div>
</section>


<!-- Enhanced Services Section -->
<section id="services" class="py-20 bg-neutral-light relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-primary-50 opacity-50 skew-x-12 -mr-20 z-0"></div>
        <div class="absolute bottom-0 left-0 w-1/4 h-1/2 bg-secondary-50 opacity-30 rounded-full -ml-20 -mb-20 z-0"></div>
        
        <!-- Animated particles -->
        <div class="particles-container"></div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-block">
                <span class="text-sm uppercase tracking-wider text-primary-600 font-semibold bg-primary-50 px-3 py-1 rounded-full">Our Services</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-display font-bold mt-4 mb-6">
                Innovative Medical Logistics Solutions
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Our cutting-edge platform connects patients, labs, and blood banks for streamlined medical logistics in Nigeria.
            </p>
        </div>
        
        <!-- Enhanced Service Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-6xl mx-auto">
            <!-- eMedSample Card -->
            <div class="feature-card group relative bg-white rounded-2xl shadow-xl p-8 transition-all duration-500 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <!-- Background decoration -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary-50 rounded-bl-full opacity-60 transition-all duration-500 group-hover:bg-primary-100"></div>
                <div class="absolute -bottom-16 -left-16 w-32 h-32 bg-primary-50/30 rounded-full transition-all duration-500 group-hover:bg-primary-100/30"></div>
                
                <div class="relative z-10">
                    <div class="w-20 h-20 rounded-2xl bg-primary-100 flex items-center justify-center mb-8 transform transition-transform duration-500 group-hover:rotate-6">
                        <i class="fas fa-flask text-4xl text-primary-600"></i>
                    </div>
                    
                    <h3 class="text-2xl font-display font-bold mb-4 transition-colors duration-300 group-hover:text-primary-600">eMedSample</h3>
                    
                    <p class="text-gray-600 mb-6 text-lg">
                        Order lab tests, track samples, and receive results seamlessly through our innovative platform.
                    </p>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex items-start">
                            <div class="mt-1 mr-3 flex-shrink-0 w-5 h-5 rounded-full bg-secondary-100 flex items-center justify-center">
                                <i class="fas fa-check text-xs text-secondary-600"></i>
                            </div>
                            <p class="text-gray-600">Schedule lab tests from the comfort of your home</p>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="mt-1 mr-3 flex-shrink-0 w-5 h-5 rounded-full bg-secondary-100 flex items-center justify-center">
                                <i class="fas fa-check text-xs text-secondary-600"></i>
                            </div>
                            <p class="text-gray-600">Professional sample collection by trained personnel</p>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="mt-1 mr-3 flex-shrink-0 w-5 h-5 rounded-full bg-secondary-100 flex items-center justify-center">
                                <i class="fas fa-check text-xs text-secondary-600"></i>
                            </div>
                            <p class="text-gray-600">Real-time tracking of your sample's journey</p>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="mt-1 mr-3 flex-shrink-0 w-5 h-5 rounded-full bg-secondary-100 flex items-center justify-center">
                                <i class="fas fa-check text-xs text-secondary-600"></i>
                            </div>
                            <p class="text-gray-600">Secure digital results delivery with expert interpretation</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <a href="{{ route('register') }}" class="group inline-flex items-center font-medium text-primary-600 hover:text-primary-800 transition-colors">
                            Explore eMedSample
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        
                        <span class="bg-primary-50 text-primary-700 text-sm font-medium px-3 py-1 rounded-full">
                            From ₦1,000
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- SharedBlood Card -->
            <div class="feature-card group relative bg-white rounded-2xl shadow-xl p-8 transition-all duration-500 overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <!-- Background decoration -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-red-50 rounded-bl-full opacity-60 transition-all duration-500 group-hover:bg-red-100"></div>
                <div class="absolute -bottom-16 -left-16 w-32 h-32 bg-red-50/30 rounded-full transition-all duration-500 group-hover:bg-red-100/30"></div>
                
                <div class="relative z-10">
                    <div class="w-20 h-20 rounded-2xl bg-red-100 flex items-center justify-center mb-8 transform transition-transform duration-500 group-hover:rotate-6">
                        <i class="fas fa-heartbeat text-4xl text-red-600 heartbeat"></i>
                    </div>
                    
                    <h3 class="text-2xl font-display font-bold mb-4 transition-colors duration-300 group-hover:text-red-600">SharedBlood</h3>
                    
                    <p class="text-gray-600 mb-6 text-lg">
                        Donate or request blood with real-time tracking and delivery through our life-saving network.
                    </p>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex items-start">
                            <div class="mt-1 mr-3 flex-shrink-0 w-5 h-5 rounded-full bg-secondary-100 flex items-center justify-center">
                                <i class="fas fa-check text-xs text-secondary-600"></i>
                            </div>
                            <p class="text-gray-600">Quick blood type matching and compatibility checks</p>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="mt-1 mr-3 flex-shrink-0 w-5 h-5 rounded-full bg-secondary-100 flex items-center justify-center">
                                <i class="fas fa-check text-xs text-secondary-600"></i>
                            </div>
                            <p class="text-gray-600">Emergency blood requests with priority handling</p>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="mt-1 mr-3 flex-shrink-0 w-5 h-5 rounded-full bg-secondary-100 flex items-center justify-center">
                                <i class="fas fa-check text-xs text-secondary-600"></i>
                            </div>
                            <p class="text-gray-600">Secure transportation with temperature monitoring</p>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="mt-1 mr-3 flex-shrink-0 w-5 h-5 rounded-full bg-secondary-100 flex items-center justify-center">
                                <i class="fas fa-check text-xs text-secondary-600"></i>
                            </div>
                            <p class="text-gray-600">Donor rewards program with health benefits</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <a href="{{ route('register') }}" class="group inline-flex items-center font-medium text-red-600 hover:text-red-800 transition-colors">
                            Explore SharedBlood
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        
                        <div class="flex items-center gap-2">
                            <span class="bg-green-50 text-green-700 text-sm font-medium px-3 py-1 rounded-full">
                                Save Lives
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- User Testimonial -->
        <div class="mt-20 max-w-4xl mx-auto" data-aos="fade-up" data-aos-delay="300">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-8 flex flex-col justify-center">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full overflow-hidden mr-4 ring-2 ring-primary-100">
                                <img src="https://t4.ftcdn.net/jpg/06/48/70/47/360_F_648704734_moetXNlcFTUCE2YlAQf0neIXpROxXrQI.jpg" alt="Mrs. Okonkwo" class="w-full h-full object-cover" />
                            </div>
                            <div>
                                <h4 class="font-bold">Mrs. Okonkwo</h4>
                                <p class="text-sm text-gray-500">Patient, Abuja</p>
                            </div>
                        </div>
                        <div class="relative mb-6">
                            <i class="fas fa-quote-left text-5xl text-primary-100 absolute -top-4 -left-2 opacity-50"></i>
                            <p class="text-gray-600 relative z-10 italic">
                                "The blood donation service saved my husband's life during an emergency surgery. We were able to quickly find a donor blood and track the delivery in real-time. The anxiety of waiting was lessened knowing exactly where the blood was in transit."
                            </p>
                        </div>
                        <div class="text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <div class="bg-primary-500 p-8 text-white flex flex-col justify-center">
                        <h3 class="text-xl font-bold mb-4">Why Our Services Matter</h3>
                        <p class="mb-6">
                            In Nigeria, timely access to medical testing and blood donations can mean the difference between life and death. Our platform bridges critical gaps in the healthcare system.
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <div class="mt-1 mr-3 flex-shrink-0 w-5 h-5 rounded-full bg-white/20 flex items-center justify-center">
                                    <i class="fas fa-check text-xs text-white"></i>
                                </div>
                                <span>Reduced wait times by 75%</span>
                            </li>
                            <li class="flex items-start">
                                <div class="mt-1 mr-3 flex-shrink-0 w-5 h-5 rounded-full bg-white/20 flex items-center justify-center">
                                    <i class="fas fa-check text-xs text-white"></i>
                                </div>
                                <span>98% successful delivery rate</span>
                            </li>
                            <li class="flex items-start">
                                <div class="mt-1 mr-3 flex-shrink-0 w-5 h-5 rounded-full bg-white/20 flex items-center justify-center">
                                    <i class="fas fa-check text-xs text-white"></i>
                                </div>
                                <span>Serving key regions across Nigeria</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service CTA -->
        <div class="mt-16 text-center" data-aos="fade-up" data-aos-delay="400">
            <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-primary-500 text-white rounded-xl font-medium text-lg hover:bg-primary-600 transition-colors shadow-lg shadow-primary-500/20 hover:shadow-xl hover:shadow-primary-500/30 pulse-element">
                Explore All Services
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
        
        <!-- Provider Registration Card (Subtle) -->
        <div class="mt-24 max-w-4xl mx-auto rounded-2xl overflow-hidden shadow-lg" data-aos="fade-up" data-aos-delay="500">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="bg-secondary-500 p-8 text-white">
                    <div class="mb-4 flex items-center">
                        <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center mr-4">
                            <i class="fas fa-hospital-user text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold">For Healthcare Providers</h3>
                    </div>
                    <p class="mb-6">Are you a laboratory, hospital, clinic or blood bank looking to expand your reach? Join our network of trusted healthcare providers.</p>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>Increase your patient base</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>Optimize logistics and sample collection</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>Enhance service delivery with our technology</span>
                        </li>
                    </ul>
                    <a href="{{ route('provider.register') }}" class="inline-flex items-center px-6 py-3 bg-white text-secondary-700 rounded-lg font-medium transition-all hover:bg-secondary-50 hover:shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>
                        Register as Healthcare Provider
                    </a>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1588196749597-9ff075ee6b5b?auto=format&fit=crop&w=500&q=80" alt="Medical Provider" class="w-full h-full object-cover" />
                    <div class="absolute inset-0 bg-gradient-to-l from-black/60 to-transparent flex items-center justify-center">
                        <div class="text-center p-6 max-w-xs">
                            <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center mb-4 shadow-lg">
                                <i class="fas fa-handshake text-secondary-500 text-xl"></i>
                            </div>
                            <h4 class="text-white text-xl font-bold mb-2">Become a Partner</h4>
                            <p class="text-white/90 text-sm">Join our network of healthcare providers and expand your services across Nigeria.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced How It Works Section -->
<section id="how-it-works" class="py-20 bg-white relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Lab pattern background -->
        <div class="absolute inset-0 opacity-5 bg-lab-pattern"></div>
        
        <!-- Animated morphing background -->
        <div class="morphing-bg" style="top: 20%; left: 10%; opacity: 0.05;"></div>
        <div class="morphing-bg" style="bottom: 20%; right: 10%; opacity: 0.05; animation-delay: -5s;"></div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="inline-block">
                <span class="text-sm uppercase tracking-wider text-primary-600 font-semibold bg-primary-50 px-3 py-1 rounded-full">How It Works</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-display font-bold mt-4 mb-6">
                Simple Process, Powerful Results
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Our intuitive platform makes medical logistics simple, efficient, and reliable through three easy steps.
            </p>
        </div>
        
        <div class="relative">
            <!-- Connection line -->
            <div class="hidden lg:block absolute top-1/2 left-0 w-full h-1 bg-gradient-to-r from-primary-100 via-secondary-100 to-accent/20 transform -translate-y-1/2 z-0"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
                <!-- Step 1: Place Order -->
                <div class="step-item bg-white rounded-2xl shadow-xl p-8 text-center" data-aos="fade-right" data-aos-delay="100">
                    <div class="relative w-20 h-20 mx-auto mb-6">
                        <div class="absolute inset-0 bg-primary-100 rounded-2xl transform rotate-6"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="w-10 h-10 flex items-center justify-center rounded-full bg-primary-500 text-white font-bold text-xl">1</span>
                        </div>
                    </div>
                    
                    <div class="h-20 flex items-center justify-center">
                        <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_vPnn3K.json" background="transparent" speed="1" style="width: 120px; height: 120px;" loop autoplay></lottie-player>
                    </div>
                    
                    <h3 class="text-xl font-display font-bold mb-4 mt-4">Place Your Order</h3>
                    <p class="text-gray-600 mb-6">
                        Select lab test or blood request through our user-friendly app. Provide necessary details and your preferred scheduling options.
                    </p>
                    
                    <div class="bg-primary-50 rounded-lg p-4">
                        <h4 class="font-medium text-primary-700 mb-2">What You'll Need:</h4>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-primary-500 mr-2"></i>
                                <span>Basic personal information</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-primary-500 mr-2"></i>
                                <span>Test type or blood requirements</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-primary-500 mr-2"></i>
                                <span>Preferred date and time</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Step 2: Track Delivery -->
                <div class="step-item bg-white rounded-2xl shadow-xl p-8 text-center transform lg:translate-y-10" data-aos="fade-up" data-aos-delay="200">
                    <div class="relative w-20 h-20 mx-auto mb-6">
                        <div class="absolute inset-0 bg-secondary-100 rounded-2xl transform rotate-6"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="w-10 h-10 flex items-center justify-center rounded-full bg-secondary-500 text-white font-bold text-xl">2</span>
                        </div>
                    </div>
                    
                    <div class="h-20 flex items-center justify-center">
                        <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_ukjcyybw.json" background="transparent" speed="1" style="width: 120px; height: 120px;" loop autoplay></lottie-player>
                    </div>
                    
                    <h3 class="text-xl font-display font-bold mb-4 mt-4">Track in Real-Time</h3>
                    <p class="text-gray-600 mb-6">
                        Monitor your sample or blood delivery in real-time through our secure tracking system with live updates and notifications.
                    </p>
                    
                    <div class="bg-secondary-50 rounded-lg p-4">
                        <h4 class="font-medium text-secondary-700 mb-2">Tracking Features:</h4>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-secondary-500 mr-2"></i>
                                <span>GPS location tracking</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-secondary-500 mr-2"></i>
                                <span>Status updates via SMS/app</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-secondary-500 mr-2"></i>
                                <span>Estimated arrival times</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Step 3: Get Results -->
                <div class="step-item bg-white rounded-2xl shadow-xl p-8 text-center" data-aos="fade-left" data-aos-delay="300">
                    <div class="relative w-20 h-20 mx-auto mb-6">
                        <div class="absolute inset-0 bg-accent/10 rounded-2xl transform rotate-6"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="w-10 h-10 flex items-center justify-center rounded-full bg-accent text-white font-bold text-xl">3</span>
                        </div>
                    </div>
                    
                    <div class="h-20 flex items-center justify-center">
                        <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_touohxv0.json" background="transparent" speed="1" style="width: 120px; height: 120px;" loop autoplay></lottie-player>
                    </div>
                    
                    <h3 class="text-xl font-display font-bold mb-4 mt-4">Receive Results</h3>
                    <p class="text-gray-600 mb-6">
                        Get test results digitally through our secure platform or confirm blood donation completion with detailed reports.
                    </p>
                    
                    <div class="bg-orange-50 rounded-lg p-4">
                        <h4 class="font-medium text-orange-700 mb-2">Result Delivery:</h4>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-orange-500 mr-2"></i>
                                <span>Secure digital reports</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-orange-500 mr-2"></i>
                                <span>Doctor consultation options</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-orange-500 mr-2"></i>
                                <span>Historical data access</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
     <!-- Process Demo Video -->
     <div class="mt-20 max-w-6xl mx-auto" data-aos="fade-up" data-aos-delay="400">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="w-full md:w-1/2">
                    <h3 class="text-2xl font-display font-bold mb-4">See How It Works</h3>
                    <p class="text-gray-600 mb-6">
                        Watch our short demo video to see exactly how DHR SPACE transforms medical logistics in Nigeria, from sample collection to result delivery.
                    </p>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-primary-100 flex-shrink-0 flex items-center justify-center mr-4">
                                <i class="fas fa-shield-alt text-primary-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold">Secure & Confidential</h4>
                                <p class="text-gray-500 text-sm">Your medical data is encrypted and protected</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-primary-100 flex-shrink-0 flex items-center justify-center mr-4">
                                <i class="fas fa-clock text-primary-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold">Fast Turnaround</h4>
                                <p class="text-gray-500 text-sm">Most results delivered within 24-48 hours</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-primary-100 flex-shrink-0 flex items-center justify-center mr-4">
                                <i class="fas fa-medal text-primary-600"></i>
                            </div>
                            <div>
                                <h4 class="font-bold">Quality Assured</h4>
                                <p class="text-gray-500 text-sm">All partner labs meet our strict quality standards</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="#" class="inline-flex items-center px-6 py-3 bg-primary-500 text-white rounded-xl font-medium hover:bg-primary-600 transition-colors">
                        Watch Demo
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                
                <div class="w-full md:w-1/2">
                    <div class="relative rounded-2xl overflow-hidden shadow-lg h-96" id="how-it-works-slider">
                        <!-- Slider Images -->
                        <img src="/images/labtechwoman.png" alt="Lab technician at work" class="slider-image absolute inset-0 w-full h-full object-cover transition-opacity duration-500 opacity-100" data-slide="1" />
                        <img src="/images/deliveringmed.jpg" alt="Medical delivery" class="slider-image absolute inset-0 w-full h-full object-cover transition-opacity duration-500 opacity-0" data-slide="2" />
                        <img src="/images/rideblood.jpg" alt="Blood delivery bike" class="slider-image absolute inset-0 w-full h-full object-cover transition-opacity duration-500 opacity-0" data-slide="3" />
                        
                        <!-- Play button -->
                        <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                            <button class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg transform transition-transform hover:scale-110 pulse-element">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Interactive process points / Slider Controls -->
                        <div class="absolute top-1/4 left-1/4 transform -translate-x-1/2 -translate-y-1/2">
                            <button class="slider-control w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center text-white cursor-pointer pulse-element shadow-lg text-lg font-bold ring-2 ring-white ring-offset-2 ring-offset-primary-500 transition-all duration-300 active-slide" data-target-slide="1">1</button>
                        </div>
                        
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <button class="slider-control w-10 h-10 bg-secondary-500 rounded-full flex items-center justify-center text-white cursor-pointer pulse-element shadow-lg text-lg font-bold ring-2 ring-white ring-offset-2 ring-offset-secondary-500 transition-all duration-300" data-target-slide="2">2</button>
                        </div>
                        
                        <div class="absolute bottom-1/4 right-1/4 transform translate-x-1/2 translate-y-1/2">
                            <button class="slider-control w-10 h-10 bg-accent rounded-full flex items-center justify-center text-white cursor-pointer pulse-element shadow-lg text-lg font-bold ring-2 ring-white ring-offset-2 ring-offset-accent transition-all duration-300" data-target-slide="3">3</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Join CTA -->
        <div class="mt-16 text-center" data-aos="fade-up" data-aos-delay="500">
            <a href="#" class="inline-flex items-center px-8 py-4 bg-secondary-500 text-white rounded-xl font-medium text-lg hover:bg-secondary-600 transition-colors shadow-lg shadow-secondary-500/20 hover:shadow-xl hover:shadow-secondary-500/30 pulse-element">
                Join DHR SPACE Today
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-16 md:py-24 bg-neutral-light">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 fade-in-section">
            <h2 class="text-2xl md:text-3xl font-bold mb-4">Get In Touch</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Have questions or need more information? Reach out to our team.
            </p>
        </div>
        
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                <!-- Contact Form -->
                <div class="lg:col-span-3">
                    <form action="/contact" method="POST" class="bg-white rounded-xl shadow-lg p-8 fade-in-section">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="form-group">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" id="name" name="name" required class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Your name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" id="email" name="email" required class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Your email">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tag text-gray-400"></i>
                                </div>
                                <input type="text" id="subject" name="subject" required class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Message subject">
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <i class="fas fa-comment text-gray-400"></i>
                                </div>
                                <textarea id="message" name="message" rows="5" required class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Your message"></textarea>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="bg-primary hover:bg-primary/90 text-gray px-6 py-3 rounded-full text-lg font-medium transition-transform hover:scale-105 shadow-lg shadow-primary/20" id="contact-submit">
                                <span class="flex items-center justify-center gap-2">
                                    <i class="fas fa-paper-plane"></i>
                                    Send Message
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Contact Info -->
                <div class="lg:col-span-2">
                    <div class="bg-primary-500 rounded-xl shadow-lg p-8 text-white h-full">
                        <h3 class="text-xl font-bold mb-6">Contact Information</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <p class="font-medium mb-1">Our Location</p>
                                    <p class="text-white/80">B292 Wunti Street, Bauchi, Bauchi State, Nigeria</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <p class="font-medium mb-1">Phone Numbers</p>
                                    <p class="text-white/80">+2347015262726</p>
                                    <p class="text-white/80">+2348100413965</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <p class="font-medium mb-1">Email Address</p>
                                    <p class="text-white/80">info@dhealthrides.com</p>
                                </div>
                            </div>
                            
                            {{-- <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fab fa-whatsapp"></i>
                                </div> --}}
                                {{-- <div>
                                    <p class="font-medium mb-1">WhatsApp</p>
                                    <a href="https://wa.me/2347015262726" target="_blank" class="text-white/80 hover:text-white transition-colors">+2347015262726</a>
                                </div> --}}
                            {{-- </div> --}}
                            
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <p class="font-medium mb-1">Working Hours</p>
                                    <p class="text-white/80">Mon - Fri: 8:00 AM - 6:00 PM</p>
                                    <p class="text-white/80">Sat: 9:00 AM - 3:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Live Chat Widget -->
<div class="fixed bottom-6 right-6 z-50">
    <button id="chat-button" class="w-16 h-16 bg-primary-500 rounded-full shadow-lg flex items-center justify-center text-white hover:bg-primary-600 transition-colors focus:outline-none pulse-element">
        <i class="fas fa-comments text-2xl"></i>
    </button>
    
    <div id="chat-widget" class="hidden absolute bottom-20 right-0 w-80 bg-white rounded-xl shadow-2xl overflow-hidden">
        <div class="bg-primary-500 text-white p-4 flex justify-between items-center">
            <div>
                <h3 class="font-bold">DHR Support</h3>
                <p class="text-xs text-white/80">We typically reply in a few minutes</p>
            </div>
            <button id="close-chat" class="text-white hover:text-white/80">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="h-80 p-4 overflow-y-auto" id="chat-messages">
            <div class="flex mb-4">
                <div class="w-8 h-8 rounded-full bg-primary-100 flex-shrink-0 flex items-center justify-center mr-2">
                    <span class="text-primary-500 text-sm font-bold">DHR</span>
                </div>
                <div class="bg-neutral-light rounded-lg p-3 max-w-[80%]">
                    <p class="text-sm">Hello! How can I help you with DHR SPACE today?</p>
                </div>
            </div>
        </div>
        
        <div class="p-4 border-t">
            <div class="flex">
                <input type="text" id="chat-input" placeholder="Type your message..." class="flex-1 border rounded-l-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-primary-500">
                <button id="send-message" class="bg-primary-500 text-white px-4 py-2 rounded-r-lg hover:bg-primary-600">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Chat Widget -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatButton = document.getElementById('chat-button');
        const chatWidget = document.getElementById('chat-widget');
        const closeChat = document.getElementById('close-chat');
        const chatInput = document.getElementById('chat-input');
        const sendMessage = document.getElementById('send-message');
        const chatMessages = document.getElementById('chat-messages');
        
        chatButton.addEventListener('click', function() {
            chatWidget.classList.toggle('hidden');
        });
        
        closeChat.addEventListener('click', function() {
            chatWidget.classList.add('hidden');
        });
        
        function sendUserMessage() {
            const message = chatInput.value.trim();
            if (message === '') return;
            
            // Add user message
            const userMessageHTML = `
                <div class="flex justify-end mb-4">
                    <div class="bg-primary-500 text-white rounded-lg p-3 max-w-[80%]">
                        <p class="text-sm">${message}</p>
                    </div>
                </div>
            `;
            chatMessages.innerHTML += userMessageHTML;
            chatInput.value = '';
            
            // Scroll to bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
            // Simulate response after a short delay
            setTimeout(function() {
                const botMessageHTML = `
                    <div class="flex mb-4">
                        <div class="w-8 h-8 rounded-full bg-primary-100 flex-shrink-0 flex items-center justify-center mr-2">
                            <span class="text-primary-500 text-sm font-bold">DHR</span>
                        </div>
                        <div class="bg-neutral-light rounded-lg p-3 max-w-[80%]">
                            <p class="text-sm">Thank you for your message. One of our representatives will assist you shortly.</p>
                        </div>
                    </div>
                `;
                chatMessages.innerHTML += botMessageHTML;
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }, 1000);
        }
        
        sendMessage.addEventListener('click', sendUserMessage);
        
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendUserMessage();
            }
        });
    });
</script>
@endsection
