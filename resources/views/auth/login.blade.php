<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Auth Form with Tailwind</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        secondary: {
                            50: '#faf5ff',
                            100: '#f3e8ff',
                            200: '#e9d5ff',
                            300: '#d8b4fe',
                            400: '#c084fc',
                            500: '#a855f7',
                            600: '#9333ea',
                            700: '#7e22ce',
                            800: '#6b21a8',
                            900: '#581c87',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-reverse': 'float-reverse 5s ease-in-out infinite',
                        'pulse-slow': 'pulse 5s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        'float-reverse': {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(20px)' },
                        }
                    }
                }
            }
        }
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body class="bg-gradient-to-br from-primary-50 to-secondary-50 min-h-screen flex items-center justify-center p-4">
    <!-- Floating decorative elements -->
    <div class="fixed top-20 left-20 w-32 h-32 rounded-full bg-primary-100 opacity-30 mix-blend-multiply blur-xl animate-float"></div>
    <div class="fixed bottom-20 right-20 w-40 h-40 rounded-full bg-secondary-100 opacity-30 mix-blend-multiply blur-xl animate-float-reverse"></div>
    
    <div class="max-w-5xl w-full bg-white/90 backdrop-blur-lg rounded-3xl shadow-2xl overflow-hidden border border-white/20 relative z-10">
        <div class="md:flex h-full">
            <!-- Left Side - Illustration -->
            <div class="hidden md:block md:w-2/5 bg-gradient-to-br from-primary-600 to-secondary-600 p-10 flex flex-col justify-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-10 left-10 w-20 h-20 rounded-full bg-white animate-float"></div>
                    <div class="absolute bottom-10 right-10 w-24 h-24 rounded-full bg-white animate-float-reverse"></div>
                    <div class="absolute top-1/3 right-1/4 w-16 h-16 rounded-full bg-white animate-pulse-slow"></div>
                </div>
                
                <div class="text-white text-center relative z-10">
                    <h2 class="text-4xl font-bold mb-4">Welcome!</h2>
                    <p class="mb-8 text-white/90 max-w-md mx-auto">Join our community of creators and explore exclusive features tailored just for you.</p>
                    <img src="https://illustrations.popsy.co/amber/designer.svg" alt="Login Illustration" class="w-full h-72 object-contain mx-auto animate-float">
                    
                    <div class="mt-12">
                        <h3 class="text-lg font-medium mb-3">Sign in with</h3>
                        <div class="flex justify-center space-x-4">
                            <button class="bg-white/10 hover:bg-white/20 p-3 rounded-full backdrop-blur-md transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                                <i class="fab fa-google text-lg"></i>
                            </button>
                            <button class="bg-white/10 hover:bg-white/20 p-3 rounded-full backdrop-blur-md transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                                <i class="fab fa-apple text-lg"></i>
                            </button>
                            <button class="bg-white/10 hover:bg-white/20 p-3 rounded-full backdrop-blur-md transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                                <i class="fab fa-github text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Side - Forms -->
            <div class="w-full md:w-3/5 p-8 md:p-10">
                <!-- Logo -->
                <div class="flex justify-center md:justify-start mb-6">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 flex items-center justify-center mr-2">
                            <i class="fas fa-rocket text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-primary-600 to-secondary-600 bg-clip-text text-transparent">AuthFlow</span>
                    </div>
                </div>
                
                <!-- Tab Navigation -->
                <div class="flex border-b border-gray-200 mb-8">
                    <button id="login-tab" class="flex-1 py-3 font-medium text-center border-b-2 border-primary-500 text-primary-600 transition-all duration-300">Sign In</button>
                    <button id="register-tab" class="flex-1 py-3 font-medium text-center text-gray-500 hover:text-primary-600 transition-all duration-300">Sign Up</button>
                </div>
                
                <!-- Login Form -->
                <form id="loginForm" class="space-y-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-1">Welcome back</h2>
                    <p class="text-gray-500 mb-6">Sign in to continue to your account</p>
                    
                    <div class="space-y-5">
                        <div>
                            <label for="login-email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" id="login-email" name="email" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 hover:border-gray-400" placeholder="you@example.com" required>
                            </div>
                            <p id="login-email-error" class="mt-1 text-xs text-red-600 hidden">Please enter a valid email address</p>
                        </div>
                        
                        <div>
                            <label for="login-password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="login-password" name="password" class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 hover:border-gray-400" placeholder="••••••••" required minlength="8">
                                <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600 toggle-password" data-target="login-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <p id="login-password-error" class="mt-1 text-xs text-red-600 hidden">Password must be at least 8 characters</p>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="remember-me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                            </div>
                            <a href="#" class="text-sm text-primary-600 hover:text-primary-500 font-medium">Forgot password?</a>
                        </div>
                        
                        <!-- reCAPTCHA -->
                        <div id="login-recaptcha" class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
                        <p id="login-recaptcha-error" class="mt-1 text-xs text-red-600 hidden">Please verify you're not a robot</p>
                        
                        <button type="submit" class="w-full bg-gradient-to-r from-primary-600 to-secondary-600 text-white py-3 px-4 rounded-xl hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md flex items-center justify-center gap-2">
                            <i class="fas fa-sign-in-alt"></i> Sign In
                        </button>
                        
                        <div class="relative my-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">Or continue with</span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" class="w-full bg-white border border-gray-300 text-gray-700 py-2.5 px-4 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all duration-300 flex items-center justify-center gap-2">
                                <i class="fab fa-google text-red-500"></i> Google
                            </button>
                            <button type="button" class="w-full bg-white border border-gray-300 text-gray-700 py-2.5 px-4 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all duration-300 flex items-center justify-center gap-2">
                                <i class="fab fa-apple"></i> Apple
                            </button>
                        </div>
                    </div>
                    
                    <div class="text-center text-sm text-gray-500">
                        Don't have an account? <button type="button" id="switch-to-register" class="text-primary-600 hover:text-primary-500 font-medium">Sign up</button>
                    </div>
                </form>
                
                <!-- Register Form (Hidden by default) -->
                <form id="registerForm" class="space-y-6 hidden">
                    <h2 class="text-2xl font-bold text-gray-800 mb-1">Create your account</h2>
                    <p class="text-gray-500 mb-6">Get started with your free account today</p>
                    
                    <div class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="first-name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" id="first-name" name="firstName" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 hover:border-gray-400" placeholder="John" required>
                                </div>
                                <p id="first-name-error" class="mt-1 text-xs text-red-600 hidden">Please enter your first name</p>
                            </div>
                            <div>
                                <label for="last-name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" id="last-name" name="lastName" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 hover:border-gray-400" placeholder="Doe" required>
                                </div>
                                <p id="last-name-error" class="mt-1 text-xs text-red-600 hidden">Please enter your last name</p>
                            </div>
                        </div>
                        
                        <div>
                            <label for="register-email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" id="register-email" name="email" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 hover:border-gray-400" placeholder="you@example.com" required>
                            </div>
                            <p id="register-email-error" class="mt-1 text-xs text-red-600 hidden">Please enter a valid email address</p>
                        </div>
                        
                        <div>
                            <label for="register-password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="register-password" name="password" class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 hover:border-gray-400" placeholder="••••••••" required minlength="8">
                                <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600 toggle-password" data-target="register-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="mt-2">
                                <div class="flex items-center space-x-2">
                                    <div id="strength-meter" class="h-1.5 w-full bg-gray-200 rounded-full overflow-hidden">
                                        <div id="strength-meter-fill" class="h-full bg-gray-400 w-0 transition-all duration-500"></div>
                                    </div>
                                    <span id="strength-text" class="text-xs text-gray-500">Weak</span>
                                </div>
                                <p id="register-password-error" class="mt-1 text-xs text-red-600 hidden">Password must be at least 8 characters</p>
                            </div>
                            
                            <div class="mt-3 text-xs text-gray-500">
                                <p class="flex items-center mb-1"><i class="fas fa-check-circle mr-1.5 text-primary-500"></i> At least 8 characters</p>
                                <p class="flex items-center mb-1"><i class="fas fa-check-circle mr-1.5 text-gray-300"></i> Uppercase & lowercase letters</p>
                                <p class="flex items-center"><i class="fas fa-check-circle mr-1.5 text-gray-300"></i> At least one number or symbol</p>
                            </div>
                        </div>
                        
                        <div>
                            <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="confirm-password" name="confirmPassword" class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 hover:border-gray-400" placeholder="••••••••" required>
                                <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600 toggle-password" data-target="confirm-password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <p id="confirm-password-error" class="mt-1 text-xs text-red-600 hidden">Passwords do not match</p>
                        </div>
                        
                        <!-- Terms and Conditions -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded" required>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-700">I agree to the <button type="button" id="terms-modal-button" class="text-primary-600 hover:text-primary-500">Terms and Conditions</button> and <button type="button" id="privacy-modal-button" class="text-primary-600 hover:text-primary-500">Privacy Policy</button></label>
                                <p id="terms-error" class="mt-1 text-xs text-red-600 hidden">You must accept the terms and conditions</p>
                            </div>
                        </div>
                        
                        <!-- Newsletter subscription -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="newsletter" name="newsletter" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="newsletter" class="font-medium text-gray-700">Subscribe to our newsletter for updates and offers</label>
                            </div>
                        </div>
                        
                        <!-- reCAPTCHA -->
                        <div id="register-recaptcha" class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
                        <p id="register-recaptcha-error" class="mt-1 text-xs text-red-600 hidden">Please verify you're not a robot</p>
                        
                        <button type="submit" class="w-full bg-gradient-to-r from-primary-600 to-secondary-600 text-white py-3 px-4 rounded-xl hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md flex items-center justify-center gap-2">
                            <i class="fas fa-user-plus"></i> Create Account
                        </button>
                    </div>
                    
                    <div class="text-center text-sm text-gray-500">
                        Already have an account? <button type="button" id="switch-to-login" class="text-primary-600 hover:text-primary-500 font-medium">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Terms and Conditions Modal -->
    <div id="terms-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-50 transition-opacity duration-300">
        <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[80vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0" id="terms-modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800">Terms and Conditions</h3>
                    <button id="close-terms-modal" class="text-gray-500 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100 transition">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                
                <div class="prose prose-sm text-gray-600 max-w-none">
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">1. Acceptance of Terms</h4>
                    <p>By accessing or using our services, you agree to be bound by these Terms and Conditions. If you do not agree with any part of these terms, you must not use our services.</p>
                    
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">2. User Responsibilities</h4>
                    <p>You are responsible for maintaining the confidentiality of your account information and for all activities that occur under your account. You agree to notify us immediately of any unauthorized use of your account.</p>
                    
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">3. Privacy Policy</h4>
                    <p>Your use of our services is also governed by our Privacy Policy, which explains how we collect, use, and protect your personal information.</p>
                    
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">4. Intellectual Property</h4>
                    <p>All content included on our platform, such as text, graphics, logos, and software, is the property of our company or its content suppliers and protected by intellectual property laws.</p>
                    
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">5. Prohibited Activities</h4>
                    <p>You agree not to engage in any of the following prohibited activities: (a) using our services for any illegal purpose; (b) harassing, abusing, or harming others; (c) interfering with or disrupting the services.</p>
                    
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">6. Termination</h4>
                    <p>We may terminate or suspend your account immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach these Terms.</p>
                    
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">7. Limitation of Liability</h4>
                    <p>In no event shall our company be liable for any indirect, incidental, special, consequential or punitive damages resulting from your use of or inability to use the services.</p>
                    
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">8. Changes to Terms</h4>
                    <p>We reserve the right to modify these terms at any time. Your continued use of the services after any such changes constitutes your acceptance of the new Terms.</p>
                    
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">9. Governing Law</h4>
                    <p>These Terms shall be governed by and construed in accordance with the laws of the jurisdiction in which our company is established.</p>
                </div>
                
                <div class="mt-6 pt-4 border-t border-gray-200 flex justify-end">
                    <button id="accept-terms" class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white px-6 py-2.5 rounded-lg hover:opacity-90 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md">
                        I Accept
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Privacy Policy Modal -->
    <div id="privacy-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-50 transition-opacity duration-300">
        <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[80vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0" id="privacy-modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800">Privacy Policy</h3>
                    <button id="close-privacy-modal" class="text-gray-500 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100 transition">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                
                <div class="prose prose-sm text-gray-600 max-w-none">
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">1. Information We Collect</h4>
                    <p>We collect personal information you provide when you register, including your name, email address, and other contact details. We also automatically collect certain technical data when you use our services.</p>
                    
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">2. How We Use Your Information</h4>
                    <p>We use your information to provide and improve our services, communicate with you, personalize your experience, and for security and authentication purposes.</p>
                    
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">3. Data Sharing</h4>
                    <p>We do not sell your personal information. We may share data with trusted service providers who assist us in operating our services, and when required by law.</p>
                    
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">4. Data Security</h4>
                    <p>We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, or destruction.</p>
                    
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">5. Your Rights</h4>
                    <p>You have the right to access, correct, or delete your personal information. You may also object to or restrict certain processing activities.</p>
                    
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">6. Cookies</h4>
                    <p>We use cookies and similar technologies to enhance your experience, analyze usage, and for advertising purposes. You can control cookies through your browser settings.</p>
                    
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">7. Children's Privacy</h4>
                    <p>Our services are not directed to children under 13. We do not knowingly collect personal information from children under 13.</p>
                    
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">8. International Transfers</h4>
                    <p>Your information may be transferred to and processed in countries other than your own, which may have different data protection laws.</p>
                    
                    <h4 class="text-lg font-semibold text-gray-800 mt-4">9. Changes to This Policy</h4>
                    <p>We may update this Privacy Policy from time to time. We will notify you of significant changes through our website or by email.</p>
                </div>
                
                <div class="mt-6 pt-4 border-t border-gray-200 flex justify-end">
                    <button id="accept-privacy" class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white px-6 py-2.5 rounded-lg hover:opacity-90 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md">
                        I Understand
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Spinner (Hidden by default) -->
    <div id="loading-spinner" class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50 hidden transition-opacity duration-300">
        <div class="bg-white p-8 rounded-2xl shadow-2xl flex flex-col items-center transform transition-all duration-300 scale-90 opacity-0" id="spinner-content">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-primary-500 mb-6"></div>
            <p class="text-gray-700 font-medium">Processing your request...</p>
            <p class="text-sm text-gray-500 mt-1">This may take a few moments</p>
        </div>
    </div>
    
    <!-- Success Modal (Hidden by default) -->
    <div id="success-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 hidden z-50 transition-opacity duration-300">
        <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-md w-full text-center transform transition-all duration-300 scale-90 opacity-0" id="success-modal-content">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check-circle text-4xl text-green-500"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Success!</h3>
            <p id="success-message" class="text-gray-600 mb-6">Your account has been created successfully.</p>
            <button id="close-success-modal" class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white px-6 py-2.5 rounded-lg hover:opacity-90 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-md w-full">
                Continue
            </button>
        </div>
    </div>
    
    <script>
        // Configure Toastr
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "toastClass": "!rounded-xl !shadow-lg !border !border-gray-200"
        };

        // Show modal with animation
        function showModal(modalId, contentId) {
            const modal = document.getElementById(modalId);
            const content = document.getElementById(contentId);
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        // Hide modal with animation
        function hideModal(modalId, contentId) {
            const modal = document.getElementById(modalId);
            const content = document.getElementById(contentId);
            
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Tab switching functionality
        function switchToLogin() {
            document.getElementById('registerForm').classList.add('hidden');
            document.getElementById('loginForm').classList.remove('hidden');
            document.getElementById('register-tab').classList.remove('border-primary-500', 'text-primary-600');
            document.getElementById('register-tab').classList.add('text-gray-500');
            document.getElementById('login-tab').classList.add('border-primary-500', 'text-primary-600');
            document.getElementById('login-tab').classList.remove('text-gray-500');
        }
        
        function switchToRegister() {
            document.getElementById('loginForm').classList.add('hidden');
            document.getElementById('registerForm').classList.remove('hidden');
            document.getElementById('login-tab').classList.remove('border-primary-500', 'text-primary-600');
            document.getElementById('login-tab').classList.add('text-gray-500');
            document.getElementById('register-tab').classList.add('border-primary-500', 'text-primary-600');
            document.getElementById('register-tab').classList.remove('text-gray-500');
        }
        
        document.getElementById('switch-to-register').addEventListener('click', switchToRegister);
        document.getElementById('switch-to-login').addEventListener('click', switchToLogin);
        document.getElementById('login-tab').addEventListener('click', switchToLogin);
        document.getElementById('register-tab').addEventListener('click', switchToRegister);
        
        // Terms and Conditions Modal
        document.getElementById('terms-modal-button').addEventListener('click', () => {
            showModal('terms-modal', 'terms-modal-content');
        });
        
        document.getElementById('close-terms-modal').addEventListener('click', () => {
            hideModal('terms-modal', 'terms-modal-content');
        });
        
        document.getElementById('accept-terms').addEventListener('click', () => {
            document.getElementById('terms').checked = true;
            document.getElementById('terms-error').classList.add('hidden');
            hideModal('terms-modal', 'terms-modal-content');
        });
        
        // Privacy Policy Modal
        document.getElementById('privacy-modal-button').addEventListener('click', () => {
            showModal('privacy-modal', 'privacy-modal-content');
        });
        
        document.getElementById('close-privacy-modal').addEventListener('click', () => {
            hideModal('privacy-modal', 'privacy-modal-content');
        });
        
        document.getElementById('accept-privacy').addEventListener('click', () => {
            hideModal('privacy-modal', 'privacy-modal-content');
        });
        
        // Close modals when clicking outside
        document.getElementById('terms-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideModal('terms-modal', 'terms-modal-content');
            }
        });
        
        document.getElementById('privacy-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideModal('privacy-modal', 'privacy-modal-content');
            }
        });
        
        document.getElementById('success-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideModal('success-modal', 'success-modal-content');
            }
        });
        
        document.getElementById('close-success-modal').addEventListener('click', () => {
            hideModal('success-modal', 'success-modal-content');
        });

        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
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

        // Password strength meter with improved logic
        document.getElementById('register-password').addEventListener('input', function() {
            const password = this.value;
            const meter = document.getElementById('strength-meter-fill');
            const text = document.getElementById('strength-text');
            const requirements = document.querySelectorAll('#registerForm .fa-check-circle');
            
            // Reset
            meter.style.width = '0%';
            meter.style.backgroundColor = '#9CA3AF'; // gray-400
            text.textContent = 'Weak';
            text.className = 'text-xs text-gray-500';
            
            if (password.length === 0) {
                requirements.forEach(icon => {
                    icon.classList.remove('text-primary-500', 'text-green-500');
                    icon.classList.add('text-gray-300');
                });
                return;
            }
            
            // Check requirements
            const hasMinLength = password.length >= 8;
            const hasUpperLower = /[a-z]/.test(password) && /[A-Z]/.test(password);
            const hasNumberOrSymbol = /\d/.test(password) || /[!@#$%^&*(),.?":{}|<>]/.test(password);
            
            // Update requirement icons
            requirements[0].classList.toggle('text-primary-500', hasMinLength);
            requirements[0].classList.toggle('text-gray-300', !hasMinLength);
            
            requirements[1].classList.toggle('text-primary-500', hasUpperLower);
            requirements[1].classList.toggle('text-gray-300', !hasUpperLower);
            
            requirements[2].classList.toggle('text-primary-500', hasNumberOrSymbol);
            requirements[2].classList.toggle('text-gray-300', !hasNumberOrSymbol);
            
            // Calculate strength
            let strength = 0;
            
            // Length
            if (password.length > 7) strength += 1;
            if (password.length > 10) strength += 1;
            if (password.length > 14) strength += 1;
            
            // Complexity
            if (hasUpperLower) strength += 1;
            if (hasNumberOrSymbol) strength += 1;
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength += 1;
            
            // Update meter
            const width = Math.min(strength * 20, 100);
            meter.style.width = width + '%';
            
            if (strength <= 2) {
                meter.style.backgroundColor = '#EF4444'; // red-500
                text.textContent = 'Weak';
                text.className = 'text-xs text-red-500';
            } else if (strength <= 4) {
                meter.style.backgroundColor = '#F59E0B'; // amber-500
                text.textContent = 'Medium';
                text.className = 'text-xs text-amber-500';
            } else {
                meter.style.backgroundColor = '#10B981'; // emerald-500
                text.textContent = 'Strong';
                text.className = 'text-xs text-emerald-500';
            }
        });

        // Show loading spinner with animation
        function showLoading() {
            const spinner = document.getElementById('loading-spinner');
            const content = document.getElementById('spinner-content');
            
            spinner.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-90', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        // Hide loading spinner with animation
        function hideLoading() {
            const spinner = document.getElementById('loading-spinner');
            const content = document.getElementById('spinner-content');
            
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-90', 'opacity-0');
            
            setTimeout(() => {
                spinner.classList.add('hidden');
            }, 300);
        }

        // Show success modal with animation
        function showSuccess(message) {
            const modal = document.getElementById('success-modal');
            const content = document.getElementById('success-modal-content');
            const messageEl = document.getElementById('success-message');
            
            messageEl.textContent = message;
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-90', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        // Form validation and submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate form
            let isValid = true;
            const email = document.getElementById('login-email');
            const password = document.getElementById('login-password');
            const recaptchaResponse = grecaptcha.getResponse();
            
            // Reset errors
            document.querySelectorAll('#loginForm .hidden').forEach(el => el.classList.add('hidden'));
            
            // Validate email
            if (!email.value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                document.getElementById('login-email-error').classList.remove('hidden');
                isValid = false;
                email.classList.add('border-red-500');
                email.classList.remove('border-gray-300');
            } else {
                email.classList.remove('border-red-500');
                email.classList.add('border-gray-300');
            }
            
            // Validate password
            if (!password.value || password.value.length < 8) {
                document.getElementById('login-password-error').classList.remove('hidden');
                isValid = false;
                password.classList.add('border-red-500');
                password.classList.remove('border-gray-300');
            } else {
                password.classList.remove('border-red-500');
                password.classList.add('border-gray-300');
            }
            
            // Validate reCAPTCHA
            if (!recaptchaResponse) {
                document.getElementById('login-recaptcha-error').classList.remove('hidden');
                isValid = false;
            }
            
            if (!isValid) {
                toastr.error('Please fill all required fields correctly');
                return;
            }
            
            // Show loading spinner
            showLoading();
            
            // Simulate API call
            setTimeout(() => {
                hideLoading();
                
                // In a real app, you would check credentials and handle response
                // For demo purposes, we'll assume login is successful
                toastr.success('Login successful! Redirecting...');
                
                // Reset form
                this.reset();
                grecaptcha.reset();
                
                // In a real app, you would redirect or perform other actions
                // window.location.href = '/dashboard';
            }, 2000);
        });
        
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate form
            let isValid = true;
            const firstName = document.getElementById('first-name');
            const lastName = document.getElementById('last-name');
            const email = document.getElementById('register-email');
            const password = document.getElementById('register-password');
            const confirmPassword = document.getElementById('confirm-password');
            const terms = document.getElementById('terms');
            const recaptchaResponse = grecaptcha.getResponse();
            
            // Reset errors
            document.querySelectorAll('#registerForm .hidden').forEach(el => el.classList.add('hidden'));
            
            // Validate first name
            if (!firstName.value) {
                document.getElementById('first-name-error').classList.remove('hidden');
                isValid = false;
                firstName.classList.add('border-red-500');
                firstName.classList.remove('border-gray-300');
            } else {
                firstName.classList.remove('border-red-500');
                firstName.classList.add('border-gray-300');
            }
            
            // Validate last name
            if (!lastName.value) {
                document.getElementById('last-name-error').classList.remove('hidden');
                isValid = false;
                lastName.classList.add('border-red-500');
                lastName.classList.remove('border-gray-300');
            } else {
                lastName.classList.remove('border-red-500');
                lastName.classList.add('border-gray-300');
            }
            
            // Validate email
            if (!email.value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                document.getElementById('register-email-error').classList.remove('hidden');
                isValid = false;
                email.classList.add('border-red-500');
                email.classList.remove('border-gray-300');
            } else {
                email.classList.remove('border-red-500');
                email.classList.add('border-gray-300');
            }
            
            // Validate password
            if (!password.value || password.value.length < 8) {
                document.getElementById('register-password-error').classList.remove('hidden');
                isValid = false;
                password.classList.add('border-red-500');
                password.classList.remove('border-gray-300');
            } else {
                password.classList.remove('border-red-500');
                password.classList.add('border-gray-300');
            }
            
            // Validate confirm password
            if (password.value !== confirmPassword.value) {
                document.getElementById('confirm-password-error').classList.remove('hidden');
                isValid = false;
                confirmPassword.classList.add('border-red-500');
                confirmPassword.classList.remove('border-gray-300');
            } else {
                confirmPassword.classList.remove('border-red-500');
                confirmPassword.classList.add('border-gray-300');
            }
            
            // Validate terms
            if (!terms.checked) {
                document.getElementById('terms-error').classList.remove('hidden');
                isValid = false;
            }
            
            // Validate reCAPTCHA
            if (!recaptchaResponse) {
                document.getElementById('register-recaptcha-error').classList.remove('hidden');
                isValid = false;
            }
            
            if (!isValid) {
                toastr.error('Please fill all required fields correctly');
                return;
            }
            
            // Show loading spinner
            showLoading();
            
            // Simulate API call
            setTimeout(() => {
                hideLoading();
                
                // Show success modal instead of toast
                showSuccess('Your account has been created successfully! Welcome to our platform.');
                
                // Reset form
                this.reset();
                grecaptcha.reset();
                document.getElementById('strength-meter-fill').style.width = '0%';
                document.getElementById('strength-text').textContent = 'Weak';
                document.getElementById('strength-text').className = 'text-xs text-gray-500';
                
                // Reset requirement icons
                document.querySelectorAll('#registerForm .fa-check-circle').forEach(icon => {
                    icon.classList.remove('text-primary-500', 'text-green-500');
                    icon.classList.add('text-gray-300');
                });
                
                // Switch to login form after success
                setTimeout(() => {
                    switchToLogin();
                    hideModal('success-modal', 'success-modal-content');
                }, 3000);
            }, 2000);
        });

        // Social login buttons
        document.querySelectorAll('#loginForm button[type="button"], #registerForm button[type="button"]').forEach(button => {
            button.addEventListener('click', function() {
                const provider = this.textContent.trim();
                toastr.info(`Redirecting to ${provider} login...`);
            });
        });

        // Forgot password link
        document.querySelector('a[href="#"]').addEventListener('click', function(e) {
            e.preventDefault();
            toastr.info('Password reset link would be sent to your email');
        });
    </script>
</body>
</html>