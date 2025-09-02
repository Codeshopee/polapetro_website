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
        /* ===== ADAPTIVE NAVBAR STYLES ===== */
        #main-header {
            background: transparent;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Light background sections - navbar tetap transparan */
        #main-header.navbar-light {
            background: transparent;
        }

        /* Dark background sections - navbar tetap transparan */
        #main-header.navbar-dark {
            background: transparent;
        }

        /* ===== LOGO STYLES ===== */
        .logo-original {
            transition: all 0.4s ease;
            filter: none;
        }

        /* Logo tetap menggunakan warna asli di semua kondisi */
        #main-header.navbar-dark .logo-original {
            filter: none;
        }

        /* ===== NAVIGATION LINK STYLES ===== */
        .nav-link {
            color: #1f2937;
            font-weight: 500;
            font-size: 0.95rem;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        /* Hover effect for light backgrounds */
        .nav-link:hover {
            color: #2DD4BF;
            transform: translateY(-1px);
        }

        .nav-link.active {
            color: #2DD4BF;
        }

        /* Dark background & Gradient background - light text */
        #main-header.navbar-dark .nav-link,
        #main-header.navbar-gradient .nav-link {
            color: #ffffff;
        }

        #main-header.navbar-dark .nav-link:hover,
        #main-header.navbar-gradient .nav-link:hover {
            color: #2DD4BF;
            transform: translateY(-1px);
        }

        #main-header.navbar-dark .nav-link.active,
        #main-header.navbar-gradient .nav-link.active {
            color: #2DD4BF;
        }

        /* ===== HAMBURGER ADAPTIVE COLORS ===== */
        .hamburger-line {
            width: 100%;
            height: 2px;
            background-color: #374151;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 1px;
        }

        /* Hamburger lines turn white for dark/gradient backgrounds */
        #main-header.navbar-dark .hamburger-line,
        #main-header.navbar-gradient .hamburger-line {
            background-color: #ffffff;
        }

        /* Hamburger Animation */
        .hamburger {
            width: 30px;
            height: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .hamburger:hover {
            background: rgba(45, 212, 191, 0.1);
        }

        #main-header.navbar-dark .hamburger:hover,
        #main-header.navbar-gradient .hamburger:hover {
            background: rgba(45, 212, 191, 0.2);
        }

        /* Active/clicked state */
        .hamburger.active .hamburger-line {
            background-color: #2DD4BF !important;
        }

        .hamburger.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }

        .hamburger.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        /* ===== MOBILE MENU TOGGLE BUTTON ===== */
        #mobile-menu-toggle {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 99999;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            transition: all 0.3s ease;
            min-height: 40px;
            min-width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Hide hamburger when sidebar is open */
        body.menu-open #mobile-menu-toggle {
            display: none;
        }

        /* Simple Hamburger Lines */
        .hamburger {
            width: 18px;
            height: 12px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .hamburger-line {
            width: 100%;
            height: 1.5px;
            background-color: white;
        }

        /* ===== SIDEBAR MOBILE MENU ===== */
        #mobile-menu {
            position: fixed;
            top: 0;
            right: 0;
            width: 50vw;
            height: 100vh;
            background: linear-gradient(135deg, #2DD4BF 0%, #14B8A6 50%, #0891B2 100%);
            z-index: 99998;
            /* PERBAIKAN: Default tersembunyi sempurna */
            transform: translateX(100%);
            visibility: hidden;
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            box-shadow: -4px 0 20px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        /* PERBAIKAN: Sidebar visible state yang lebih reliable */
        #mobile-menu.sidebar-open {
            transform: translateX(0);
            visibility: visible;
            opacity: 1;
        }

        /* Mobile Navigation Links */
        .mobile-nav-link {
            display: block;
            color: white;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 400;
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .mobile-nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: white;
        }

        .mobile-nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            border-left-color: white;
        }

        /* PERBAIKAN: Sidebar visible state yang lebih reliable */
        #mobile-menu.sidebar-open {
            transform: translateX(0);
            visibility: visible;
            opacity: 1;
        }

        /* Overlay untuk background gelap */
        #menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 99997;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            /* PERBAIKAN: Default tersembunyi */
            pointer-events: none;
        }

        #menu-overlay.overlay-visible {
            opacity: 1;
            visibility: visible;
            pointer-events: all;
        }

        /* ===== SIDEBAR HEADER WITH IMAGE ===== */
        .sidebar-header {
            padding: 1rem 1rem 0.75rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        /* Logo Image Container */
        .sidebar-logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.25rem;
        }

        .sidebar-logo-img {
            width: 24px;
            height: auto;
            max-height: 24px;
            object-fit: contain;
            filter: brightness(0) invert(1);
            transition: all 0.3s ease;
        }

        /* Company Name */
        .sidebar-title {
            color: white;
            font-size: 0.55rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            line-height: 1.1;
            margin: 0;
        }

        /* ===== SIDEBAR NAVIGATION ===== */
        #mobile-menu nav {
            padding: 1rem 0;
            flex: 1;
        }

        #mobile-menu nav a {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 400;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            position: relative;
            min-height: 44px;
        }

        #mobile-menu nav a:hover {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: white;
        }

        #mobile-menu nav a.active {
            background: rgba(255, 255, 255, 0.15);
            border-left-color: white;
        }

        /* ===== PAGE SPECIFIC STYLES ===== */
        /* Remove default body padding for home page */
        body.home-page {
            padding-top: 0;
        }

        /* Keep body padding for other pages */
        body:not(.home-page) {
            padding-top: 80px;
        }

        /* Non-home pages - navbar styling */
        body:not(.home-page) #main-header {
            background: transparent;
        }

        body:not(.home-page) #main-header .nav-link {
            color: #1f2937;
        }

        body:not(.home-page) #main-header .nav-link:hover,
        body:not(.home-page) #main-header .nav-link.active {
            color: #2DD4BF;
        }

        body:not(.home-page) #main-header .hamburger-line {
            background-color: #374151;
        }

        /* PERBAIKAN: Hide mobile elements on desktop secara sempurna */
        @media (min-width: 1024px) {

            #mobile-menu-toggle,
            #mobile-menu,
            #menu-overlay {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
            }
        }

        /* Mobile specific adjustments */
        @media (max-width: 1023px) {
            .desktop-nav {
                display: none !important;
            }

            body.menu-open {
                overflow: hidden;
            }
        }

        /* Touch-friendly buttons */
        @media (max-width: 1024px) {
            .btn-touch {
                min-height: 48px;
                min-width: 48px;
            }
        }

        /* Responsive sidebar width */
        @media (max-width: 480px) {
            #mobile-menu {
                width: 60vw;
            }

            .sidebar-logo-img {
                width: 50px;
                max-height: 50px;
            }

            .sidebar-title {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 320px) {
            #mobile-menu {
                width: 70vw;
            }

            .sidebar-logo-img {
                width: 45px;
                max-height: 45px;
            }

            .sidebar-title {
                font-size: 0.75rem;
            }
        }

        /* PERBAIKAN: Ensure proper initial state */
        .sidebar-hidden {
            transform: translateX(100%) !important;
            visibility: hidden !important;
            opacity: 0 !important;
        }
    </style>
</head>

<body class="font-sans antialiased @if(request()->routeIs('home')) home-page @endif">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" id="main-header">
        <div class="container mx-auto px-6 py-4">
            <nav class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo-final-ppd-1.png') }}" alt="Pola Petro Development"
                            class="h-12 w-auto logo-original">
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-2 desktop-nav">
                    <a href="{{ route('home') }}"
                        class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('contact') }}"
                        class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                    <a href="{{ route('careers') }}"
                        class="nav-link {{ request()->routeIs('careers') ? 'active' : '' }}">Careers</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Mobile Menu Toggle Button -->
    <button id="mobile-menu-toggle" class="lg:hidden btn-touch" aria-label="Toggle mobile menu">
        <div class="hamburger">
            <div class="hamburger-line"></div>
            <div class="hamburger-line"></div>
            <div class="hamburger-line"></div>
        </div>
    </button>

    <!-- Menu Overlay -->
    <div id="menu-overlay"></div>

    <!-- Mobile Sidebar Menu dengan Header yang Benar -->
    <div id="mobile-menu" class="sidebar-hidden lg:hidden">
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
            <a href="{{ route('home') }}"
                class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('contact') }}"
                class="mobile-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
            <a href="{{ route('careers') }}"
                class="mobile-nav-link {{ request()->routeIs('careers') ? 'active' : '' }}">Careers</a>
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

            // Detect if we're on home page for adaptive navbar
            const isHomePage = document.body.classList.contains('home-page');

            // Throttle function for performance
            function throttle(func, limit) {
                let inThrottle;
                return function () {
                    const args = arguments;
                    const context = this;
                    if (!inThrottle) {
                        func.apply(context, args);
                        inThrottle = true;
                        setTimeout(() => inThrottle = false, limit);
                    }
                }
            }

            // Function to detect if gradient/section should use white text
            function shouldUseWhiteText(element) {
                if (element.hasAttribute('data-white-text') ||
                    element.hasAttribute('data-dark-gradient') ||
                    element.hasAttribute('data-dark-bg')) {
                    return true;
                }

                if (element.classList.contains('dark-gradient') ||
                    element.classList.contains('gradient-dark') ||
                    element.classList.contains('bg-dark') ||
                    element.classList.contains('text-white')) {
                    return true;
                }

                const computedStyle = window.getComputedStyle(element);
                const backgroundImage = computedStyle.backgroundImage;

                if (backgroundImage && backgroundImage.includes('gradient')) {
                    const darkIndicators = [
                        'black', 'dark', 'navy', 'slate', 'gray-900', 'gray-800',
                        'rgb(0', 'rgb(1', 'rgb(2', 'rgb(3', 'rgb(4)', 'rgb(5)',
                        'rgba(0', 'rgba(1', 'rgba(2', 'rgba(3', 'rgba(4)', 'rgba(5)'
                    ];

                    const hasDarkColors = darkIndicators.some(indicator =>
                        backgroundImage.toLowerCase().includes(indicator)
                    );

                    const darkHexPattern = /#[0-4][0-9a-f]{5}|#[0-4][0-9a-f]{2}/gi;
                    const hasDarkHex = darkHexPattern.test(backgroundImage);

                    return hasDarkColors || hasDarkHex;
                }

                return false;
            }

            // Adaptive Navbar Function for Home Page
            function updateNavbarStyle() {
                if (!isHomePage) return;

                header.classList.remove('navbar-light', 'navbar-dark', 'navbar-gradient');

                if (typeof fullpage_api !== 'undefined') {
                    const currentSection = fullpage_api.getActiveSection();
                    if (currentSection) {
                        const sectionIndex = currentSection.index;
                        const sectionElement = currentSection.item;

                        if (shouldUseWhiteText(sectionElement)) {
                            header.classList.add('navbar-gradient');
                        } else {
                            const darkSections = [0, 3, 4];

                            if (darkSections.includes(sectionIndex)) {
                                header.classList.add('navbar-dark');
                            } else {
                                header.classList.add('navbar-light');
                            }
                        }
                    }
                } else {
                    const sections = document.querySelectorAll('section, .section');
                    let currentSectionElement = null;
                    let currentSectionIndex = 0;

                    sections.forEach((section, index) => {
                        const rect = section.getBoundingClientRect();
                        if (rect.top <= 100 && rect.bottom >= 100) {
                            currentSectionIndex = index;
                            currentSectionElement = section;
                        }
                    });

                    if (currentSectionElement) {
                        if (shouldUseWhiteText(currentSectionElement)) {
                            header.classList.add('navbar-gradient');
                        } else {
                            const darkSections = [0, 3, 4];

                            if (darkSections.includes(currentSectionIndex)) {
                                header.classList.add('navbar-dark');
                            } else {
                                header.classList.add('navbar-light');
                            }
                        }
                    }
                }
            }

            // Regular scroll effect for non-home pages
            function regularScrollEffect() {
                if (isHomePage) return;

                if (window.scrollY > 50) {
                    header.classList.add('nav-scrolled');
                } else {
                    header.classList.remove('nav-scrolled');
                }
            }

            // Initialize navbar style on load
            if (isHomePage) {
                header.classList.add('navbar-dark');
                updateNavbarStyle();
            }

            // Throttled scroll event listener for better performance
            const throttledUpdateNavbar = throttle(function () {
                if (isHomePage) {
                    updateNavbarStyle();
                } else {
                    regularScrollEffect();
                }
            }, 16);

            // Scroll Event Listener
            window.addEventListener('scroll', throttledUpdateNavbar, { passive: true });

            // FullPage.js callback integration (if available)
            if (isHomePage && typeof window.fullpage_api !== 'undefined') {
                const originalOnLeave = window.fullpageConfig?.onLeave;
                if (window.fullpageConfig) {
                    window.fullpageConfig.onLeave = function (origin, destination, direction) {
                        updateNavbarStyle();
                        if (originalOnLeave) originalOnLeave(origin, destination, direction);
                    };
                }
            }

            // ===== MOBILE SIDEBAR MENU FUNCTIONALITY (FIXED) =====
            const menuToggle = document.getElementById('mobile-menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuOverlay = document.getElementById('menu-overlay');
            const mobileClose = document.getElementById('mobile-close');
            const menuLinks = document.querySelectorAll('.mobile-nav-link');

            if (!menuToggle || !mobileMenu || !menuOverlay) {
                console.log('Mobile menu elements not found');
                return;
            }

            console.log('Mobile sidebar elements found successfully');

            // PERBAIKAN: Pastikan sidebar tersembunyi di awal
            function initializeSidebar() {
                mobileMenu.classList.add('sidebar-hidden');
                mobileMenu.classList.remove('sidebar-open');
                menuOverlay.classList.remove('overlay-visible');
                document.body.classList.remove('menu-open');
            }

            // Function to open sidebar
            function openSidebar() {
                console.log('Opening sidebar');
                mobileMenu.classList.remove('sidebar-hidden');
                // Small delay to ensure transition works
                setTimeout(() => {
                    mobileMenu.classList.add('sidebar-open');
                }, 10);
                menuOverlay.classList.add('overlay-visible');
                document.body.classList.add('menu-open');

                // Disable fullpage scrolling if exists
                if (typeof fullpage_api !== 'undefined') {
                    fullpage_api.setAllowScrolling(false);
                }
            }

            // Function to close sidebar
            function closeSidebar() {
                console.log('Closing sidebar');
                mobileMenu.classList.remove('sidebar-open');
                menuOverlay.classList.remove('overlay-visible');
                document.body.classList.remove('menu-open');

                // Wait for animation to complete before hiding completely
                setTimeout(() => {
                    mobileMenu.classList.add('sidebar-hidden');
                }, 400);

                // Re-enable fullpage scrolling if exists
                if (typeof fullpage_api !== 'undefined') {
                    fullpage_api.setAllowScrolling(true);
                }
            }

            // PERBAIKAN: Initialize sidebar pada page load
            initializeSidebar();

            // Toggle menu visibility
            menuToggle.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Mobile menu toggle clicked');

                if (mobileMenu.classList.contains('sidebar-open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });

            // Close menu when clicking close button
            if (mobileClose) {
                mobileClose.addEventListener('click', function (e) {
                    console.log('Close button clicked, closing sidebar');
                    closeSidebar();
                });
            }

            // Close menu when clicking overlay
            menuOverlay.addEventListener('click', function (e) {
                console.log('Clicked overlay, closing sidebar');
                closeSidebar();
            });

            // Close menu when clicking links
            menuLinks.forEach(link => {
                link.addEventListener('click', function () {
                    console.log('Menu link clicked, closing sidebar');
                    closeSidebar();
                });
            });

            // Close on Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && mobileMenu.classList.contains('sidebar-open')) {
                    console.log('Escape pressed, closing sidebar');
                    closeSidebar();
                }
            });

            // Close on window resize to desktop
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 1024 && mobileMenu.classList.contains('sidebar-open')) {
                    console.log('Resized to desktop, closing sidebar');
                    closeSidebar();
                }

                if (isHomePage) {
                    setTimeout(updateNavbarStyle, 100);
                }
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>