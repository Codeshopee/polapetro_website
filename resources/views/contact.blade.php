@extends('components.navigation')

@section('title', 'Contact Us - Pola Petro Development')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
    .font-poppins {
        font-family: 'Poppins', sans-serif;
    }
    
    /* Simple notification styles */
    .notification {
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 400;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }
    
    .notification.show {
        opacity: 1;
        transform: translateY(0);
    }
    
    .notification.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .notification.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .notification .icon {
        width: 16px;
        height: 16px;
        margin-right: 8px;
        flex-shrink: 0;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .notification {
            padding: 10px 12px;
            font-size: 13px;
        }
        
        .notification .icon {
            width: 14px;
            height: 14px;
        }
    }
</style>

@section('content')
    <div class="min-h-screen bg-gray-100">

        <!-- Hero Section - Responsive -->
        <div class="relative h-[300px] sm:h-[400px] lg:h-[450px]">
            <!-- Background image -->
            <div class="absolute inset-0">
                <img src="/images/salam.jpg" alt="Contact Background" class="w-full h-full object-cover object-center">
            </div>

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black opacity-10"></div>

            <!-- Content - Responsive -->
            <div class="relative z-10 flex items-center h-full">
                <div class="container mx-auto px-4 sm:px-6 lg:px-20 text-left text-white font-poppins">
                    <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-light leading-tight mb-2 sm:mb-4">
                        We would like to engage with you
                    </h1>
                    <p class="text-sm sm:text-lg md:text-xl lg:text-2xl font-light">
                        Please fill the form or contact our Head Office in Jakarta
                    </p>
                </div>
            </div>
        </div>

        <!-- Map + Form Section - Responsive Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 min-h-[600px] lg:min-h-[700px]">
            <!-- Map - Responsive Height -->
            <div class="w-full h-[400px] lg:h-full order-2 lg:order-1">
                <iframe class="w-full h-full"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3589.5297355768184!2d106.76073607458558!3d-6.18962656064194!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f71b4422695b%3A0xa91dc270526105e6!2sPola%20Petro%20Development%2C%20PT!5e1!3m2!1sid!2sid!4v1755595262210!5m2!1sid!2sid"
                    style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>

            <!-- Form - Responsive Padding and Layout -->
            <div class="bg-[#696969] text-white p-4 sm:p-6 lg:p-8 flex items-center font-poppins order-1 lg:order-2">
                <div class="w-full max-w-md mx-auto lg:max-w-none">
                    <!-- Simple Notification Area - Responsive -->
                    <div id="notificationArea" class="mb-4 lg:mb-6">
                        @if(session('success'))
                            <div class="notification success show">
                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="notification error show">
                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                {{ session('error') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="notification error show">
                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $errors->first() }}
                            </div>
                        @endif
                    </div>

                    <!-- Form - Responsive Spacing -->
                    <form action="{{ route('contact.store') }}" method="POST" class="w-full space-y-3 sm:space-y-4" id="contactForm">
                        @csrf

                        <!-- Honeypot field for spam protection (hidden) -->
                        <div style="display: none;" aria-hidden="true">
                            <label for="website">Don't fill this out if you're human:</label>
                            <input type="text" id="website" name="website" tabindex="-1" autocomplete="nope">
                        </div>

                        <!-- Name - Responsive Input -->
                        <div>
                            <label for="name" class="block mb-1 font-light text-sm sm:text-base">
                                Your Name <span class="text-red-400">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 bg-[#696969] border border-gray-400 text-white placeholder-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200 text-sm sm:text-base @error('name') border-red-400 @enderror"
                                placeholder="Enter your full name">
                        </div>

                        <!-- Email - Responsive Input -->
                        <div>
                            <label for="email" class="block mb-1 font-light text-sm sm:text-base">
                                Your Email <span class="text-red-400">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 bg-[#696969] border border-gray-400 text-white placeholder-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200 text-sm sm:text-base @error('email') border-red-400 @enderror"
                                placeholder="Enter your email address">
                        </div>

                        <!-- Select - Responsive Select -->
                        <div>
                            <label for="subject" class="block mb-1 font-light text-sm sm:text-base">
                                Who Are You? <span class="text-red-400">*</span>
                            </label>
                            <select id="subject" name="subject" required
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 bg-[#696969] border border-gray-400 text-white rounded focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200 text-sm sm:text-base @error('subject') border-red-400 @enderror">
                                <option value="" disabled {{ old('subject') ? '' : 'selected' }} class="text-gray-400">
                                    Select your category
                                </option>
                                <option value="Customer" {{ old('subject') == 'Customer' ? 'selected' : '' }}>
                                    Customer
                                </option>
                                <option value="Supplier" {{ old('subject') == 'Supplier' ? 'selected' : '' }}>
                                    Supplier
                                </option>
                            </select>
                        </div>

                        <!-- Message - Responsive Textarea -->
                        <div>
                            <label for="message" class="block mb-1 font-light text-sm sm:text-base">
                                Your Message <span class="text-red-400">*</span>
                            </label>
                            <textarea id="message" name="message" rows="4" required
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 bg-[#696969] border border-gray-400 text-white placeholder-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200 resize-vertical text-sm sm:text-base @error('message') border-red-400 @enderror"
                                placeholder="Please describe your inquiry in detail...">{{ old('message') }}</textarea>
                        </div>

                        <!-- Submit Button - Responsive Button -->
                        <div class="pt-2">
                            <button type="submit" id="submitBtn"
                                class="w-full bg-[#48D1CC] hover:bg-[#3bb5b2] text-white font-light py-3 sm:py-4 rounded transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-teal-400 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed text-sm sm:text-base">
                                <span id="submitText" class="flex items-center justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Send Message
                                </span>
                                <span id="loadingText" class="hidden flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4 sm:h-5 sm:w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Sending...
                                </span>
                            </button>
                        </div>

                        <!-- Simple notification below button - Responsive -->
                        <div id="bottomNotification" class="text-center text-xs sm:text-sm hidden mt-2">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Company Info Section - Responsive -->
        <div class="w-full bg-cover bg-center relative"
            style="background-image: url('{{ asset('images/Jakarta.jpg') }}'); height: 250px; sm:height: 350px; lg:height: 427px; margin: 0 auto;">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-10"></div>

            <!-- Content - Responsive positioning -->
            <div class="relative z-10 flex items-center h-full">
                <div class="container mx-auto px-4 sm:px-6 lg:px-20 xl:ml-[130px] text-left font-poppins">
                    <h1 class="text-base sm:text-xl lg:text-2xl font-light leading-snug mb-2 sm:mb-3 text-teal-400">
                        PT Pola Petro Development
                    </h1>

                    <div class="text-xs sm:text-sm lg:text-base font-light text-white space-y-0.5 sm:space-y-1">
                        <p>Jl. Kedoya Agave Raya Blok I No.45</p>
                        <p>Jakarta 11520</p>
                        <p>Hp : 021 – 5801136</p>
                        <p>Fax : 021 – 5814810</p>
                        <p>Email : support@polapetro.co.id</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer - Responsive -->
        <footer class="bg-[#1f1f1f] text-[#696969] text-xs py-4 sm:py-6 text-center sm:text-left px-4 sm:px-8 lg:pl-40 font-poppins">
            &copy; 2017 PT Pola Petro Development
        </footer>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('contactForm');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const loadingText = document.getElementById('loadingText');
            const bottomNotification = document.getElementById('bottomNotification');

            // Form submission handling
            form.addEventListener('submit', function (e) {
                // Show loading state
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                loadingText.classList.remove('hidden');

                // Show simple notification below button
                showBottomNotification('Sending message...', 'info');

                // Re-enable after 5 seconds (fallback)
                setTimeout(function () {
                    submitBtn.disabled = false;
                    submitText.classList.remove('hidden');
                    loadingText.classList.add('hidden');
                    hideBottomNotification();
                }, 5000);
            });

            // Function to show notification below button
            function showBottomNotification(message, type) {
                bottomNotification.innerHTML = message;
                bottomNotification.className = 'text-center text-xs sm:text-sm mt-2';
                
                if (type === 'success') {
                    bottomNotification.classList.add('text-green-300');
                } else if (type === 'error') {
                    bottomNotification.classList.add('text-red-300');
                } else {
                    bottomNotification.classList.add('text-blue-300');
                }
                
                bottomNotification.classList.remove('hidden');
            }

            // Function to hide bottom notification
            function hideBottomNotification() {
                setTimeout(function() {
                    bottomNotification.classList.add('hidden');
                }, 500);
            }

            // Auto-hide notifications after 4 seconds
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(function (notification) {
                if (notification.classList.contains('show')) {
                    setTimeout(function () {
                        notification.style.opacity = '0';
                        notification.style.transform = 'translateY(-10px)';
                        setTimeout(function () {
                            notification.remove();
                        }, 300);
                    }, 4000);
                }
            });

            // Simple form validation with mobile-friendly feedback
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
            inputs.forEach(function (input) {
                input.addEventListener('blur', function () {
                    if (!this.value.trim()) {
                        this.classList.add('border-red-400');
                        // Mobile-friendly vibration feedback if supported
                        if (navigator.vibrate) {
                            navigator.vibrate(100);
                        }
                    } else {
                        this.classList.remove('border-red-400');
                    }
                });

                input.addEventListener('input', function () {
                    if (this.value.trim()) {
                        this.classList.remove('border-red-400');
                    }
                });
            });

            // Touch-friendly enhancements for mobile
            if ('ontouchstart' in window) {
                // Add touch feedback for submit button
                submitBtn.addEventListener('touchstart', function() {
                    this.style.transform = 'scale(0.98)';
                });
                
                submitBtn.addEventListener('touchend', function() {
                    this.style.transform = 'scale(1)';
                });
            }

            // Prevent zoom on input focus for iOS
            const inputs2 = document.querySelectorAll('input, select, textarea');
            inputs2.forEach(function(input) {
                input.addEventListener('focus', function() {
                    const viewport = document.querySelector('meta[name=viewport]');
                    if (viewport) {
                        viewport.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no');
                    }
                });
                
                input.addEventListener('blur', function() {
                    const viewport = document.querySelector('meta[name=viewport]');
                    if (viewport) {
                        viewport.setAttribute('content', 'width=device-width, initial-scale=1.0');
                    }
                });
            });
        });
    </script>
@endsection