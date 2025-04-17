@extends('pos.index')
@section('content_login')
<div x-show="!isLoading && !isLoggedIn && !hasActiveSession()"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
    class="fixed inset-0 flex justify-center items-center z-50">

    <!-- Background with animated waves -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-600 overflow-hidden">
        <!-- Wave animations -->
        <div class="absolute inset-0 opacity-10">
            <div class="wave wave1"></div>
            <div class="wave wave2"></div>
            <div class="wave wave3"></div>
        </div>
        <!-- Floating bubbles -->
        <div class="bubble bubble1"></div>
        <div class="bubble bubble2"></div>
        <div class="bubble bubble3"></div>
        <div class="bubble bubble4"></div>
        <div class="bubble bubble5"></div>
    </div>

    <div class="w-full max-w-3xl mx-4 relative z-10"> <!-- Adjusted max-width -->
        <!-- Premium card design with glass morphism -->
        <div class="relative bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg rounded-2xl overflow-hidden shadow-2xl border border-white border-opacity-30">
            <!-- Top decorator -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-500 rounded-full opacity-20"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-500 rounded-full opacity-20"></div>
            
            <!-- Header with logo - Top section -->
            <div class="relative bg-white bg-opacity-70 backdrop-filter backdrop-blur-lg py-6 px-8 flex items-center justify-start">
                <div class="mr-6 transform transition-all duration-500 hover:scale-110 hover:rotate-3">
                    <img src="/img/logo/logotamansari.jpeg" alt="Taman Sari Watersport"
                        class="h-20 w-20 rounded-full object-cover border-4 border-white shadow-lg">
                </div>
                <div>
                    <h2 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-700">
                        <span class="block">TAMAN SARI</span>
                        <span class="block">WATERSPORT</span>
                    </h2>
                    <div class="mt-1 flex items-center">
                        <span class="inline-block w-12 h-px bg-gradient-to-r from-blue-200 to-blue-400"></span>
                        <p class="mx-3 text-blue-800 font-medium">Welcome Back</p>
                        <span class="inline-block w-12 h-px bg-gradient-to-r from-blue-400 to-blue-200"></span>
                    </div>
                </div>
            </div>

            <!-- Main content - Bottom section -->
            <div class="px-8 py-6 bg-white bg-opacity-90">
                <p class="text-sm text-gray-600 text-center mb-6">
                    Log in to your account to access the watersport management system.
                    <br>Enjoy the beautiful ocean view while working!
                </p>

                <!-- Login Form -->
                <form x-on:submit.prevent="login">
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <!-- Username Input -->
                        <div class="transform transition hover:scale-105 duration-300">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Login Account</label>
                            <div class="relative rounded-lg overflow-hidden group">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 transition-transform duration-300 transform -translate-x-full group-hover:translate-x-0"></div>
                                <div class="flex items-center relative bg-white border-2 border-blue-100 rounded-lg overflow-hidden">
                                    <span class="pl-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <input type="text" x-model="username" placeholder="Enter your employee ID" required
                                        class="w-full py-3 px-3 bg-transparent text-gray-800 focus:outline-none">
                                </div>
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="transform transition hover:scale-105 duration-300">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <div class="relative rounded-lg overflow-hidden group">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 transition-transform duration-300 transform -translate-x-full group-hover:translate-x-0"></div>
                                <div class="flex items-center relative bg-white border-2 border-blue-100 rounded-lg overflow-hidden">
                                    <span class="pl-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <input type="password" x-model="password" placeholder="Enter your password" required
                                        class="w-full py-3 px-3 bg-transparent text-gray-800 focus:outline-none">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <label class="flex items-center space-x-2 relative cursor-pointer">
                                <input type="checkbox" class="absolute opacity-0 h-6 w-6 cursor-pointer">
                                <span class="relative flex-shrink-0 inline-flex items-center justify-center w-5 h-5 border-2 rounded border-blue-400">
                                    <span class="absolute inset-0 transform scale-0 rounded-sm bg-blue-500 transition-transform ease-in-out duration-200 translate-checkbox">
                                        <svg class="w-3 h-3 text-white" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.5 5.5L4.5 8.5L10.5 1.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </span>
                                <span class="text-sm text-gray-700">Keep me signed in</span>
                            </label>
                        </div>
                        <div class="text-sm">
                            <a href="#" class="font-medium text-blue-600 hover:text-indigo-600 hover:underline transition duration-300">
                                Create ID
                            </a>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full relative overflow-hidden group bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-lg mb-6">
                        <span class="absolute inset-0 w-full h-full transition-all duration-300 ease-out transform translate-x-0 group-hover:translate-x-full bg-gradient-to-r from-blue-500/30 to-transparent"></span>
                        <span class="absolute top-0 left-0 w-full h-full opacity-0 group-hover:opacity-100">
                            <span class="absolute inset-0 h-full w-1/3 bg-white/20 blur-sm transform -skew-x-12 -translate-x-full group-hover:translate-x-[900%] transition-transform duration-1000"></span>
                        </span>
                        <span class="flex items-center justify-center relative">
                            <span x-show="!isLoggingIn" class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                LOGIN
                            </span>
                            <span x-show="isLoggingIn" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </span>
                    </button>
                    
                    <div class="text-center mb-4">
                        <span class="text-sm text-gray-600">Don't have an account? </span>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-indigo-600 hover:underline transition duration-300">
                            Contact admin
                        </a>
                    </div>

                    <!-- Footer -->
                    <div class="mt-4 pt-4 border-t border-gray-200 text-center">
                        <p class="text-xs text-gray-500">© 2023 Taman Sari Watersport</p>
                        <p class="text-xs text-gray-500 mt-1">Tanjung Benoa, Bali - Indonesia</p>
                        <div class="flex justify-center space-x-4 mt-2">
                            <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Animated waves */
@keyframes wave {
    0% {
        transform: translateX(-50%) translateY(0) scaleY(1);
    }
    50% {
        transform: translateX(-50%) translateY(-7%) scaleY(0.95);
    }
    100% {
        transform: translateX(-50%) translateY(0) scaleY(1);
    }
}

.wave {
    position: absolute;
    width: 200%;
    height: 200%;
    border-radius: 40%;
    background: rgba(255, 255, 255, 0.1);
    left: 50%;
    transform: translateX(-50%);
    animation: wave 15s infinite linear;
}

.wave1 {
    bottom: -90%;
    opacity: 0.15;
    animation-duration: 20s;
}

.wave2 {
    bottom: -70%;
    opacity: 0.2;
    animation-duration: 15s;
    animation-delay: -5s;
}

.wave3 {
    bottom: -50%;
    opacity: 0.1;
    animation-duration: 12s;
    animation-delay: -2s;
}

/* Floating bubbles */
@keyframes float {
    0% {
        transform: translateY(0) translateX(0) rotate(0);
        opacity: 1;
    }
    100% {
        transform: translateY(-120px) translateX(20px) rotate(360deg);
        opacity: 0;
    }
}

.bubble {
    position: absolute;
    border-radius: 50%;
    background: linear-gradient(to top right, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.1));
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(5px);
    animation: float 8s infinite linear;
}

.bubble1 {
    bottom: 20%;
    left: 10%;
    width: 30px;
    height: 30px;
    animation-duration: 6s;
}

.bubble2 {
    bottom: 40%;
    right: 15%;
    width: 60px;
    height: 60px;
    animation-duration: 9s;
}

.bubble3 {
    bottom: 30%;
    left: 20%;
    width: 45px;
    height: 45px;
    animation-duration: 7s;
    animation-delay: 2s;
}

.bubble4 {
    bottom: 60%;
    right: 30%;
    width: 25px;
    height: 25px;
    animation-duration: 8s;
    animation-delay: 3s;
}

.bubble5 {
    bottom: 10%;
    right: 40%;
    width: 35px;
    height: 35px;
    animation-duration: 10s;
    animation-delay: 1s;
}

/* Custom checkbox animation */
input[type="checkbox"]:checked + span .translate-checkbox {
    transform: scale(1);
}

/* Ocean gradients */
.bg-ocean-gradient {
    background: linear-gradient(135deg, #0396FF, #0D47A1);
}
</style>
@endsection