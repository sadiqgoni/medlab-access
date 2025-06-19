<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DHR SPACE - Registration & Login Coming Soon">
    <title>Coming Soon - DHR SPACE</title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
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
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles for animations -->
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
        }
        
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

        @keyframes heartbeat {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .pulse-ring {
            animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }

        .heartbeat {
            animation: heartbeat 2s ease-in-out infinite;
        }
        
        .float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-primary-50 to-neutral-light">
    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Logo and Brand -->
            <div class="mb-8">
                <div class="w-24 h-24 mx-auto mb-6 relative">
                    <div class="absolute inset-0 rounded-full border-2 border-primary-200"></div>
                    <div class="absolute inset-0 rounded-full border-2 border-primary-500 pulse-ring"></div>
                    <div class="absolute inset-2 rounded-full overflow-hidden bg-white shadow-lg flex items-center justify-center">
                        <img src="/images/dhrlogo.jpg" alt="DHR SPACE Logo" class="w-16 h-16 object-contain">
                    </div>
                </div>
                <h1 class="text-4xl md:text-5xl font-display font-bold text-neutral-dark mb-4">
                    DHR SPACE
                </h1>
                <p class="text-xl text-primary-600 font-medium">Medical Logistics Platform</p>
            </div>

            <!-- Coming Soon Message -->
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 mb-8">
                <div class="mb-6">
                    <div class="w-20 h-20 mx-auto bg-primary-100 rounded-full flex items-center justify-center mb-6 float">
                        <i class="fas fa-rocket text-primary-600 text-3xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-neutral-dark mb-4">
                        Registration & Login Coming Soon!
                    </h2>
                    <p class="text-lg text-gray-600 mb-6">
                        We're putting the finishing touches on our platform to ensure the best experience for our users. 
                        Patient registration and login will be available very soon.
                    </p>
                </div>

                <!-- Features Preview -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="text-center p-4 bg-primary-50 rounded-xl">
                        <div class="w-12 h-12 mx-auto bg-primary-100 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-flask text-primary-600 text-xl"></i>
                        </div>
                        <h3 class="font-bold text-neutral-dark mb-2">eMedSample</h3>
                        <p class="text-sm text-gray-600">Lab test ordering and sample collection</p>
                    </div>
                    <div class="text-center p-4 bg-red-50 rounded-xl">
                        <div class="w-12 h-12 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-heartbeat text-red-600 text-xl heartbeat"></i>
                        </div>
                        <h3 class="font-bold text-neutral-dark mb-2">SharedBlood</h3>
                        <p class="text-sm text-gray-600">Blood donation and delivery service</p>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="space-y-4">
                    <p class="text-gray-600 font-medium">
                        Thank you for your interest in DHR SPACE! All registration features will be available soon.
                    </p>
                    <div class="bg-primary-50 border border-primary-200 rounded-xl p-4">
                        <p class="text-primary-700 text-sm">
                            <i class="fas fa-info-circle mr-2"></i>
                            Both patient and healthcare provider registration will launch together for the best user experience.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center mb-8">
                <a href="{{ route('landing') }}" class="inline-flex items-center text-primary-600 hover:text-primary-800 font-medium transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Homepage
                </a>
            </div>

            <!-- Contact Info -->
            <div class="text-center">
                <p class="text-gray-500 mb-4">Have questions? Get in touch with us:</p>
                <div class="flex flex-wrap justify-center gap-6 text-sm">
                    <a href="mailto:info@dhealthrides.com" class="flex items-center text-gray-600 hover:text-primary-600 transition-colors">
                        <i class="fas fa-envelope mr-2"></i>
                        info@dhealthrides.com
                    </a>
                    <span class="flex items-center text-gray-600">
                        <i class="fas fa-phone mr-2"></i>
                        +2347015262726
                    </span>
                    <a href="https://wa.me/2347015262726" target="_blank" class="flex items-center text-gray-600 hover:text-green-600 transition-colors">
                        <i class="fab fa-whatsapp mr-2"></i>
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 