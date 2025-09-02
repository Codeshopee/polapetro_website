<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Pola Petro Development'))</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Styles -->
    @stack('styles')

    <!-- Meta Tags -->
    <meta name="description"
        content="@yield('description', 'Pola Petro Development - Delivering Professionalism to a Better Future')">
    <meta name="keywords" content="@yield('keywords', 'pola petro, development, indonesia, kompresor, petrotec')">

    <style>
        /* ===== NAVBAR STYLES ===== */
        #main-header {
            background-color: transparent;
            transition: all 0.3s ease;
        }

        /* Navigation Links */
        .nav-link {
            color: rgb(199, 196, 196);
            font-weight: 500;
            transition: color 0.3s ease;
            font-size: 0.95rem;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #4ade80;
        }

        /* Logo - NO COLOR CHANGE */
        .logo-image {
            transition: transform 0.3s ease;
        }

        /* Navbar Scrolled */
        #main-header.scrolled {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(6px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        #main-header.scrolled .nav-link {
            color: #374151;
        }

        #main-header.scrolled .nav-link:hover,
        #main-header.scrolled .nav-link.active {
            color: #16a34a;
        }

        #main-header.scrolled .logo-image {
            transform: scale(0.9);
        }

        /* ===== HAMBURGER ===== */
        .hamburger {
            width: 24px;
            height: 18px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .hamburger-line {
            width: 100%;
            height: 2px;
            background-color: white;
            transition: all 0.3s ease;
        }

        #main-header.scrolled .hamburger-line {
            background-color: #374151;
        }

        /* Hamburger Animation */
        .hamburger.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }

        .hamburger.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        /* ===== MOBILE MENU - TEAL SIDEBAR LIKE IMAGE ===== */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: 0;
            width: 60%;
            max-width: 350px;
            height: 100vh;
            background: linear-gradient(135deg, #14b8a6, #06b6d4);
            z-index: 9999;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            box-shadow: -4px 0 20px rgba(0, 0, 0, 0.15);
        }

        .mobile-menu.open {
            transform: translateX(0);
        }

        /* Responsive width for smaller screens */
        @media (max-width: 640px) {
            .mobile-menu {
                width: 75%;
                max-width: 300px;
            }
        }

        @media (max-width: 480px) {
            .mobile-menu {
                width: 85%;
                max-width: 280px;
            }
        }

        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .mobile-overlay.open {
            opacity: 1;
            visibility: visible;
        }

        /* Mobile Nav Links - White text for teal background */
        .mobile-nav-link {
            display: block;
            padding: 1.5rem 2rem;
            color: white;
            text-decoration: none;
            font-size: 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .mobile-nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            padding-left: 2.5rem;
        }

        /* Hide mobile menu on desktop */
        @media (min-width: 1024px) {

            .mobile-menu,
            .mobile-overlay {
                display: none !important;
            }
        }
    </style>
</head>

<body class="font-sans antialiased">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50" id="main-header">
        <div class="container mx-auto px-4 sm:px-6 py-3 sm:py-4">
            <nav class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo-final-ppd-1.png') }}" alt="Pola Petro Development"
                            class="h-8 sm:h-10 md:h-12 w-auto logo-image">
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-6 xl:space-x-8">
                    <a href="{{ route('home') }}"
                        class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('contact') }}"
                        class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                    <a href="{{ route('careers') }}"
                        class="nav-link {{ request()->routeIs('careers') ? 'active' : '' }}">Careers</a>
                </div>

                <!-- Mobile Menu Button -->
                <button class="lg:hidden p-2 rounded-md" id="mobile-toggle">
                    <div class="hamburger" id="hamburger">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </div>
                </button>
            </nav>
        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-overlay" id="mobile-overlay"></div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobile-menu">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-white border-opacity-20">
            <img src="{{ asset('images/logo-final-ppd-1.png') }}" alt="Pola Petro Development"
                class="h-8 w-auto filter brightness-0 invert">
            <button class="p-2 text-white hover:bg-white hover:bg-opacity-10 rounded-full transition-all duration-200"
                id="mobile-close">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <div class="py-6">
            <a href="{{ route('home') }}" class="mobile-nav-link">Home</a>
            <a href="{{ route('contact') }}" class="mobile-nav-link">Contact</a>
            <a href="{{ route('careers') }}" class="mobile-nav-link">Careers</a>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const header = document.getElementById('main-header');
            const mobileToggle = document.getElementById('mobile-toggle');
            const mobileClose = document.getElementById('mobile-close');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileOverlay = document.getElementById('mobile-overlay');
            const hamburger = document.getElementById('hamburger');

            // Scroll Effect
            window.addEventListener('scroll', function () {
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });

            // Open Mobile Menu
            function openMenu() {
                mobileMenu.classList.add('open');
                mobileOverlay.classList.add('open');
                hamburger.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            // Close Mobile Menu
            function closeMenu() {
                mobileMenu.classList.remove('open');
                mobileOverlay.classList.remove('open');
                hamburger.classList.remove('active');
                document.body.style.overflow = '';
            }

            // Event Listeners
            mobileToggle.addEventListener('click', function (e) {
                e.preventDefault();
                if (mobileMenu.classList.contains('open')) {
                    closeMenu();
                } else {
                    openMenu();
                }
            });

            mobileClose.addEventListener('click', closeMenu);
            mobileOverlay.addEventListener('click', closeMenu);

            // Close on nav link click
            document.querySelectorAll('.mobile-nav-link').forEach(function (link) {
                link.addEventListener('click', closeMenu);
            });

            // Close on Escape
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && mobileMenu.classList.contains('open')) {
                    closeMenu();
                }
            });

            // Close on window resize
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 1024) {
                    closeMenu();
                }
            });
        });
    </script>
</body>

</html>