<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DHR SPACE - Loading</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    }
                }
            }
        }
    </script>
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
            animation: loadingProgress 4s ease-in-out infinite;
        }
        
        .medical-icon {
            filter: drop-shadow(0 4px 6px rgba(30, 136, 229, 0.2));
        }
        
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-primary-50 min-h-screen flex items-center justify-center overflow-hidden">
    
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
    
    <script>
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
        setInterval(rotateLoadingText, 1500);
        
        // Simulate loading completion (adjust timing as needed)
        setTimeout(() => {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease-out';
            setTimeout(() => {
                // Redirect to main application or hide preloader
                window.location.href = '/dashboard';
            }, 500);
        }, 6000); // 6 seconds total loading time
        
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
    </script>
</body>
</html>