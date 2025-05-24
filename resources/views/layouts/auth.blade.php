<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DHR SPACE') }}</title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
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
                        },
                        'fadeInUp': {
                            'from': { opacity: 0, transform: 'translateY(30px)' },
                            'to': { opacity: 1, transform: 'translateY(0)' }
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
                        'fadeInUp': 'fadeInUp 0.6s ease-out forwards'
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
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
 
    <!-- Custom Auth CSS -->
    <link href="{{ asset('css/auth-animations.css') }}" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
        
        /* Auth Form Styling */
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            z-index: 10;
            width: 100%;
            /* Ensure perfect centering */
            box-sizing: border-box;
        }
        
        .auth-card {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            position: relative;
            z-index: 10;
            border: 1px solid rgba(30, 136, 229, 0.1);
            margin: auto;
            /* Ensure the card is perfectly centered */
            transform: translateY(0);
            /* Add smooth fade-in animation */
            opacity: 1;
            transition: all 0.3s ease;
        }
        
        .fade-in {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .auth-header {
            background: linear-gradient(135deg, #1E88E5, #0068d6);
            padding: 2rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .auth-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            z-index: 0;
        }
        
        .auth-header h1 {
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }
        
        .auth-header p {
            opacity: 0.9;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }
        
        .auth-body {
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #2A3342;
            font-size: 0.95rem;
        }
        
        .form-group .input-wrapper {
            position: relative;
        }
        
        .form-group .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #1E88E5;
            font-size: 1rem;
            z-index: 2;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f9fafb;
            position: relative;
            z-index: 1;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #1E88E5;
            box-shadow: 0 0 0 3px rgba(30, 136, 229, 0.1);
            background-color: white;
        }
        
        .form-group .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            z-index: 2;
        }
        
        .form-group .password-toggle:hover {
            color: #1E88E5;
        }
        
        .form-error {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
        }
        
        .form-error i {
            margin-right: 0.25rem;
        }
        
        .form-error.show {
            display: flex;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1E88E5, #0068d6);
            color: white;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(30, 136, 229, 0.2), 0 2px 4px -1px rgba(30, 136, 229, 0.1);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #0068d6, #0053ae);
            transform: translateY(-1px);
            box-shadow: 0 6px 10px -1px rgba(30, 136, 229, 0.25), 0 2px 4px -1px rgba(30, 136, 229, 0.1);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .btn-block {
            width: 100%;
        }
        
        .btn-icon {
            margin-right: 0.5rem;
        }
        
        .auth-footer {
            padding: 1.5rem 2rem;
            background-color: #f9fafb;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }
        
        .auth-link {
            color: #1E88E5;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .auth-link:hover {
            color: #0068d6;
            text-decoration: underline;
        }
        
        .checkbox-wrapper {
            display: flex;
            align-items: center;
        }
        
        .checkbox-wrapper input[type="checkbox"] {
            margin-right: 0.5rem;
            width: auto;
            padding: 0;
        }
        
        .checkbox-wrapper label {
            margin-bottom: 0;
            font-size: 0.875rem;
            font-weight: 400;
        }
        
        /* Background Elements */
        .bg-shape-1 {
            position: fixed;
            top: -100px;
            right: -100px;
            width: 250px;
            height: 250px;
            background: linear-gradient(135deg, rgba(30, 136, 229, 0.1), rgba(76, 175, 80, 0.1));
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            animation: morph 15s linear infinite alternate;
            z-index: 1;
        }
        
        .bg-shape-2 {
            position: fixed;
            bottom: -100px;
            left: -100px;
            width: 250px;
            height: 250px;
            background: linear-gradient(135deg, rgba(76, 175, 80, 0.1), rgba(30, 136, 229, 0.1));
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            animation: morph 15s linear infinite alternate;
            z-index: 1;
        }
        
        .bg-dots {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(rgba(30, 136, 229, 0.05) 1px, transparent 1px);
            background-size: 20px 20px;
            z-index: 0;
        }
        
        /* Mobile responsive adjustments */
        @media (max-width: 768px) {
            .auth-container {
                padding: 0.75rem;
                min-height: 100vh;
                /* Ensure full height on mobile */
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .auth-card {
                margin: auto;
                width: 100%;
                max-width: 100%;
                /* Ensure card doesn't get cut off on small screens */
                min-height: auto;
                transform: translateY(0);
            }
            
            .auth-header {
                padding: 1.5rem;
            }
            
            .auth-body {
                padding: 1.5rem;
            }
            
            .form-group {
                margin-bottom: 1.25rem;
            }
            
            .form-group input,
            .form-group select,
            .form-group textarea {
                padding: 0.875rem 1rem 0.875rem 2.5rem;
                font-size: 1rem;
            }
            
            .form-group .input-icon {
                left: 0.875rem;
                font-size: 0.875rem;
            }
            
            .form-group .password-toggle {
                right: 0.875rem;
            }
            
            .btn {
                padding: 1rem 1.5rem;
                font-size: 1rem;
            }
        }
        
        @media (max-width: 480px) {
            .auth-container {
                padding: 0.5rem;
                /* Tighter padding on very small screens */
            }
            
            .auth-card {
                border-radius: 15px;
                /* Slightly smaller border radius on small screens */
            }
            
            .auth-header {
                padding: 1.25rem;
            }
            
            .auth-body {
                padding: 1.25rem;
            }
            
            .form-group input,
            .form-group select,
            .form-group textarea {
                padding: 0.75rem 0.875rem 0.75rem 2.25rem;
            }
            
            .form-group .input-icon {
                left: 0.75rem;
            }
            
            .form-group .password-toggle {
                right: 0.625rem;
            }
        }
        
        @media (max-width: 375px) {
            .auth-header h1 {
                font-size: 1.25rem;
            }
            
            .auth-header p {
                font-size: 0.8125rem;
            }
        }
    </style>
</head>
<body>
    <!-- Enhanced Auth Preloader -->
    <div id="auth-preloader" class="fixed inset-0 z-50 bg-gradient-to-br from-gray-50 to-primary-50 flex items-center justify-center">
        <div class="text-center">
            <!-- Logo Container -->
            <div class="relative w-24 h-24 mx-auto mb-6">
                <!-- Pulse Ring -->
                <div class="absolute inset-0 rounded-full border-2 border-primary-500 animate-ping opacity-75"></div>
                
                <!-- Logo -->
                <div class="absolute inset-2 rounded-full overflow-hidden bg-white shadow-lg flex items-center justify-center">
                    <img src="/images/dhrlogo.jpg" alt="DHR SPACE" class="w-16 h-16 object-contain">
                </div>
                
                <!-- Rotating Medical Icon -->
                <div class="absolute -top-2 -right-2 w-6 h-6 bg-primary-500 rounded-full flex items-center justify-center text-white text-xs animate-spin">
                    ⚕️
                </div>
            </div>
            
            <!-- Brand -->
            <h2 class="text-2xl font-bold text-gray-800 mb-2">DHR SPACE</h2>
            <p class="text-primary-600 font-medium mb-6">Secure Access Portal</p>
            
            <!-- Auth Loading Animation -->
            <div class="flex items-center justify-center space-x-1 mb-4">
                <div class="w-2 h-2 bg-primary-500 rounded-full animate-bounce"></div>
                <div class="w-2 h-2 bg-primary-400 rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
                <div class="w-2 h-2 bg-primary-300 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
            </div>
            
            <!-- Loading Text -->
            <p class="text-gray-500 text-sm" id="auth-loading-text">Preparing secure environment...</p>
        </div>
    </div>
    
    <!-- Background Elements -->
    <div class="bg-dots"></div>
    <div class="bg-shape-1"></div>
    <div class="bg-shape-2"></div>
    
    <!-- Main Content -->
    <div class="auth-container">
        {{ $slot }}
    </div>
    
    <!-- JavaScript for interactions -->
    <script>
        // Auth Preloader
        document.addEventListener('DOMContentLoaded', function() {
            // Auth-specific loading texts
            const authLoadingTexts = [
                "Preparing secure environment...",
                "Verifying security protocols...",
                "Loading authentication system...",
                "Establishing secure connection...",
                "Ready for secure access!"
            ];
            
            let currentTextIndex = 0;
            const loadingTextElement = document.getElementById('auth-loading-text');
            
            function rotateAuthLoadingText() {
                if (loadingTextElement && currentTextIndex < authLoadingTexts.length - 1) {
                    loadingTextElement.style.opacity = '0.5';
                    setTimeout(() => {
                        currentTextIndex++;
                        loadingTextElement.textContent = authLoadingTexts[currentTextIndex];
                        loadingTextElement.style.opacity = '1';
                    }, 200);
                }
            }
            
            // Rotate loading text every 800ms
            const textInterval = setInterval(rotateAuthLoadingText, 800);
            
            // Hide preloader and show content
            setTimeout(function() {
                const preloader = document.getElementById('auth-preloader');
                if (preloader) {
                    preloader.style.opacity = '0';
                    preloader.style.transition = 'opacity 0.5s ease-out';
                    setTimeout(() => {
                        preloader.style.display = 'none';
                        clearInterval(textInterval);
                    }, 500);
                }
                
                // Initialize AOS after preloader
                AOS.init({
                    duration: 800,
                    easing: 'ease-out',
                    once: true
                });
            }, 2500);
            
            // Password toggle functionality
            const passwordToggles = document.querySelectorAll('.password-toggle');
            passwordToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    const icon = this.querySelector('i');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });
            
            // Form animations
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.opacity = '0';
                group.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    group.style.transition = 'all 0.5s ease';
                    group.style.opacity = '1';
                    group.style.transform = 'translateY(0)';
                }, 2600 + (index * 100)); // Wait for preloader to finish
            });
            
            // Button animation
            const submitBtn = document.querySelector('.btn-primary');
            if (submitBtn) {
                submitBtn.style.opacity = '0';
                submitBtn.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    submitBtn.style.transition = 'all 0.5s ease';
                    submitBtn.style.opacity = '1';
                    submitBtn.style.transform = 'translateY(0)';
                }, 2600 + (formGroups.length * 100));
            }
            
            // Show mini loader on form submissions
            document.addEventListener('submit', function(e) {
                const form = e.target;
                if (form.tagName === 'FORM') {
                    showAuthProcessing();
                }
            });
        });
        
        // Auth-specific mini loader
        function showAuthProcessing() {
            const processingHTML = `
                <div id="auth-processing" class="fixed inset-0 z-50 bg-black/30 backdrop-blur-sm flex items-center justify-center">
                    <div class="bg-white rounded-xl p-6 shadow-xl max-w-sm mx-4">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-8 h-8 border-2 border-primary-500 border-t-transparent rounded-full animate-spin"></div>
                            <span class="text-gray-700 font-medium">Processing...</span>
                        </div>
                        <p class="text-gray-500 text-sm">Please wait while we verify your credentials securely.</p>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', processingHTML);
        }
    </script>
</body>
</html>
