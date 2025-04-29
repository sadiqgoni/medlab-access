@extends('layouts.app')

@section('content')
<!-- Preloader -->
<div class="preloader">
    <div class="loader">
        <div class="blood-drop"></div>
        <div class="test-tube">
            <div class="filling"></div>
        </div>
        <p class="mt-32 text-center font-display font-semibold text-primary-500">MedLab-Access</p>
    </div>
</div>

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
            <div class="w-full lg:w-1/2 text-center lg:text-left mb-12 lg:mb-0" data-aos="fade-right">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-bold mb-6 text-neutral-dark leading-tight">
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
                    <a href="#services" class="group relative px-8 py-4 bg-primary-500 text-white rounded-xl text-lg font-medium overflow-hidden shadow-lg shadow-primary-500/20 transition-all duration-300 hover:shadow-xl hover:shadow-primary-500/30 hover:scale-105">
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
                            <i class="fas fa-heartbeat text-3xl text-primary-500"></i>
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
                                    <i class="fas fa-heartbeat text-red-500"></i>
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
                <div class="scrolling-marquee-content">
                    <!-- Partner logos -->
                    @for ($i = 1; $i <= 8; $i++)
                        <div class="inline-block mx-8">
                            <div class="h-12 w-32 bg-white rounded-lg shadow-sm flex items-center justify-center">
                                <div class="text-gray-400 font-medium">Partner {{ $i }}</div>
                            </div>
                        </div>
                    @endfor
                    <!-- Duplicate for infinite scroll -->
                    @for ($i = 1; $i <= 8; $i++)
                        <div class="inline-block mx-8">
                            <div class="h-12 w-32 bg-white rounded-lg shadow-sm flex items-center justify-center">
                                <div class="text-gray-400 font-medium">Partner {{ $i }}</div>
                            </div>
                        </div>
                    @endfor
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
                    <i class="fas fa-heartbeat text-red-600 text-2xl"></i>
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

<!-- CTA Section with Enhanced Design -->
<section class="py-16 md:py-24 bg-cover bg-center relative" style="background-image: linear-gradient(rgba(30, 136, 229, 0.9), rgba(30, 136, 229, 0.9)), url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
    <!-- Animated Particles -->
    <div class="particles-container"></div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto text-center fade-in-section">
            <h2 class="text-2xl md:text-3xl font-bold mb-6 text-white">Ready to Transform Medical Logistics?</h2>
            <p class="text-lg mb-8 text-white">
                Join MedLab-Access today and experience seamless lab test requests and blood donations.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#" class="bg-white text-primary hover:bg-gray-100 px-6 py-3 rounded-full text-lg font-medium inline-block transition-transform hover:scale-105 pulse cta-button">
                    Register Now
                </a>
                <a href="#contact" class="bg-transparent border-2 border-white hover:bg-white/10 px-6 py-3 rounded-full text-lg font-medium inline-block transition-transform hover:scale-105">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Contact Form Section -->
<section id="contact" class="py-16 md:py-24">
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
                            <button type="submit" class="bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-full text-lg font-medium transition-transform hover:scale-105 shadow-lg shadow-primary/20" id="contact-submit">
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
                                    <p class="text-white/80">Lagos, Nigeria</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <p class="font-medium mb-1">Phone Number</p>
                                    <p class="text-white/80">+234-XXX-XXX-XXXX</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <p class="font-medium mb-1">Email Address</p>
                                    <p class="text-white/80">info@medlabaccess.ng</p>
                                </div>
                            </div>
                            
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
                        
                        <div class="mt-8">
                            <p class="font-medium mb-3">Follow Us</p>
                            <div class="flex space-x-4">
                                <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section with Enhanced Accordion -->
<section class="py-16 md:py-24 bg-neutral-light">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 fade-in-section">
            <h2 class="text-2xl md:text-3xl font-bold mb-4">Frequently Asked Questions</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Find answers to common questions about our services.
            </p>
        </div>
        
        <div class="max-w-3xl mx-auto fade-in-section">
            <!-- FAQ Item 1 -->
            <div class="mb-6">
                <button class="faq-question flex justify-between items-center w-full text-left font-bold p-5 rounded-xl bg-white hover:bg-white focus:outline-none transition-colors shadow-md" onclick="toggleFAQ(this)">
                    <span>How does lab sample collection work?</span>
                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center transform transition-transform duration-300">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </button>
                <div class="faq-answer hidden mt-2 p-5 rounded-xl bg-white shadow-md">
                    <p class="text-gray-600">
                        Our trained professionals will visit your location to collect samples. Alternatively, you can visit one of our partner labs. All samples are properly handled and transported under optimal conditions to ensure accurate results.
                    </p>
                    <div class="mt-4 p-3 bg-primary-50 rounded-lg border border-primary-100">
                        <div class="flex items-start">
                            <div class="text-primary-500 mr-3">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <p class="text-sm text-primary-700">
                                <strong>Pro Tip:</strong> Schedule your sample collection early in the morning for faster results.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- FAQ Item 2 -->
            <div class="mb-6">
                <button class="faq-question flex justify-between items-center w-full text-left font-bold p-5 rounded-xl bg-white hover:bg-white focus:outline-none transition-colors shadow-md" onclick="toggleFAQ(this)">
                    <span>How can I donate blood through SharedBlood?</span>
                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center transform transition-transform duration-300">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </button>
                <div class="faq-answer hidden mt-2 p-5 rounded-xl bg-white shadow-md">
                    <p class="text-gray-600">
                        Register on our platform, complete a brief health questionnaire, and schedule a donation appointment. Our team will guide you through the process and ensure your donation reaches those in need.
                    </p>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-primary-50 p-3 rounded-lg text-center">
                            <div class="text-primary-500 text-xl mb-1">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <h4 class="font-medium text-sm">Register</h4>
                        </div>
                        <div class="bg-primary-50 p-3 rounded-lg text-center">
                            <div class="text-primary-500 text-xl mb-1">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h4 class="font-medium text-sm">Schedule</h4>
                        </div>
                        <div class="bg-primary-50 p-3 rounded-lg text-center">
                            <div class="text-primary-500 text-xl mb-1">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>
                            <h4 class="font-medium text-sm">Donate</h4>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- FAQ Item 3 -->
            <div class="mb-6">
                <button class="faq-question flex justify-between items-center w-full text-left font-bold p-5 rounded-xl bg-white hover:bg-white focus:outline-none transition-colors shadow-md" onclick="toggleFAQ(this)">
                    <span>How long does it take to receive lab results?</span>
                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center transform transition-transform duration-300">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </button>
                <div class="faq-answer hidden mt-2 p-5 rounded-xl bg-white shadow-md">
                    <p class="text-gray-600">
                        Turnaround times vary depending on the type of test. Routine tests typically take 24-48 hours, while specialized tests may take 3-5 business days. You'll receive notifications at each stage of the process.
                    </p>
                    <div class="mt-4 bg-primary-50 p-4 rounded-lg">
                        <h5 class="font-medium mb-2">Typical Turnaround Times:</h5>
                        <ul class="space-y-2">
                            <li class="flex items-center">
                                <span class="w-4 h-4 bg-green-500 rounded-full mr-2"></span>
                                <span>Basic blood work: 24 hours</span>
                            </li>
                            <li class="flex items-center">
                                <span class="w-4 h-4 bg-yellow-500 rounded-full mr-2"></span>
                                <span>Hormone panels: 48 hours</span>
                            </li>
                            <li class="flex items-center">
                                <span class="w-4 h-4 bg-orange-500 rounded-full mr-2"></span>
                                <span>Specialized tests: 3-5 days</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- FAQ Item 4 -->
            <div class="mb-6">
                <button class="faq-question flex justify-between items-center w-full text-left font-bold p-5 rounded-xl bg-white hover:bg-white focus:outline-none transition-colors shadow-md" onclick="toggleFAQ(this)">
                    <span>Is my medical information secure?</span>
                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center transform transition-transform duration-300">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </button>
                <div class="faq-answer hidden mt-2 p-5 rounded-xl bg-white shadow-md">
                    <p class="text-gray-600">
                        Absolutely. We adhere to strict privacy policies and employ industry-standard encryption to protect your personal and medical information. Your data is only shared with authorized healthcare providers involved in your care.
                    </p>
                    <div class="mt-4 flex items-center p-3 bg-green-50 rounded-lg border border-green-100">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-shield-alt text-green-600"></i>
                        </div>
                        <div>
                            <h5 class="font-medium text-green-800">Bank-Level Security</h5>
                            <p class="text-sm text-green-700">All your data is encrypted with 256-bit encryption and stored in secure servers.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- FAQ Item 5 -->
            <div class="mb-6">
                <button class="faq-question flex justify-between items-center w-full text-left font-bold p-5 rounded-xl bg-white hover:bg-white focus:outline-none transition-colors shadow-md" onclick="toggleFAQ(this)">
                    <span>What payment methods do you accept?</span>
                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center transform transition-transform duration-300">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </button>
                <div class="faq-answer hidden mt-2 p-5 rounded-xl bg-white shadow-md">
                    <p class="text-gray-600">
                        We accept various payment methods including credit/debit cards, bank transfers, mobile money, and cash payments. For corporate clients, we also offer invoice-based billing with flexible payment terms.
                    </p>
                    <div class="mt-4 grid grid-cols-5 gap-2">
                        <div class="bg-gray-100 p-2 rounded flex items-center justify-center">
                            <i class="fab fa-cc-visa text-2xl text-blue-700"></i>
                        </div>
                        <div class="bg-gray-100 p-2 rounded flex items-center justify-center">
                            <i class="fab fa-cc-mastercard text-2xl text-red-600"></i>
                        </div>
                        <div class="bg-gray-100 p-2 rounded flex items-center justify-center">
                            <i class="fas fa-university text-2xl text-gray-700"></i>
                        </div>
                        <div class="bg-gray-100 p-2 rounded flex items-center justify-center">
                            <i class="fas fa-mobile-alt text-2xl text-green-600"></i>
                        </div>
                        <div class="bg-gray-100 p-2 rounded flex items-center justify-center">
                            <i class="fas fa-money-bill-wave text-2xl text-green-700"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Still Have Questions -->
        <div class="mt-12 max-w-3xl mx-auto text-center">
            <h3 class="text-xl font-bold mb-4">Still Have Questions?</h3>
            <p class="text-gray-600 mb-6">Our team is ready to assist you with any other questions you might have.</p>
            <a href="#contact" class="inline-flex items-center px-6 py-3 bg-primary-500 text-white rounded-xl font-medium hover:bg-primary-600 transition-colors shadow-lg shadow-primary/20">
                <i class="fas fa-headset mr-2"></i>
                Contact Support
            </a>
        </div>
    </div>
</section>

<!-- Partners Section with Enhanced Design -->
<section class="py-16 md:py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 fade-in-section">
            <h2 class="text-2xl md:text-3xl font-bold mb-4">Our Partners</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                We collaborate with leading healthcare institutions across Nigeria.
            </p>
        </div>
        
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 items-center">
                <!-- Partner logos with hover effects -->
                @for ($i = 1; $i <= 8; $i++)
                    <div class="group bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center h-32">
                        <div class="text-gray-400 font-bold group-hover:text-primary-500 transition-colors duration-300">Partner {{ $i }}</div>
                    </div>
                @endfor
            </div>
            
            <!-- Partnership CTA -->
            <div class="mt-12 text-center">
                <h3 class="text-xl font-bold mb-4">Become a Partner</h3>
                <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                    Join our network of healthcare providers and contribute to improving medical logistics in Nigeria.
                </p>
                <a href="#" class="inline-flex items-center px-6 py-3 bg-white border-2 border-primary-500 text-primary-600 rounded-xl font-medium hover:bg-primary-50 transition-colors">
                    <i class="fas fa-handshake mr-2"></i>
                    Partner With Us
                </a>
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
                <h3 class="font-bold">MedLab Support</h3>
                <p class="text-xs text-white/80">We typically reply in a few minutes</p>
            </div>
            <button id="close-chat" class="text-white hover:text-white/80">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="h-80 p-4 overflow-y-auto" id="chat-messages">
            <div class="flex mb-4">
                <div class="w-8 h-8 rounded-full bg-primary-100 flex-shrink-0 flex items-center justify-center mr-2">
                    <span class="text-primary-500 text-sm font-bold">M</span>
                </div>
                <div class="bg-neutral-light rounded-lg p-3 max-w-[80%]">
                    <p class="text-sm">Hello! How can I help you with MedLab-Access today?</p>
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
                            <span class="text-primary-500 text-sm font-bold">M</span>
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
