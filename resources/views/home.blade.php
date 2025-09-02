@extends('layouts.app')

@section('title', 'Pola Petro Development - Home')

{{-- STYLES SECTION --}}
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/3.1.2/fullpage.min.css">
    <style>
        /* GLOBAL STYLES */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap');

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        /* UTILITY CLASSES */
        .gradient-overlay {
            background: linear-gradient(135deg, rgba(57, 223, 165, 0.9) 0%, rgba(31, 189, 242, 0.9) 100%);
        }

        .parallax {
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: relative;
            z-index: 1;
        }

        .hero-bg {
            background-image: url('{{ asset('images/businis.jpg') }}');
        }

        .footer-half {
            min-height: 50vh;
        }

        .fp-auto-height {
            height: auto !important;
        }

        /* DESKTOP PAGINATION STYLES */
        #fp-nav {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px) !important;
            border-radius: 25px !important;
            padding: 15px 8px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
            right: 25px !important;
        }
        
        #fp-nav ul li a span,
        .fp-slidesNav ul li a span {
            background: #ffffff !important;
            border: 2px solid #e2e8f0 !important;
            width: 12px !important;
            height: 12px !important;
            margin: -6px 0 0 -6px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
        }

        #fp-nav ul li a.active span,
        #fp-nav ul li:hover a.active span,
        .fp-slidesNav ul li a.active span {
            background: #48D1CC !important;
            border-color: #48D1CC !important;
            transform: scale(1.4) !important;
            box-shadow: 0 4px 12px rgba(72, 209, 204, 0.4) !important;
        }

        #fp-nav ul li a:hover span {
            background: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
            transform: scale(1.2) !important;
        }

        /* TYPOGRAPHY */
        .hero-section h1 {
            font-weight: 200 !important;
            letter-spacing: 0.15em !important;
            line-height: 1.1 !important;
            text-transform: uppercase !important;
        }

        .hero-section p {
            font-weight: 300 !important;
            letter-spacing: 0.05em !important;
            line-height: 1.4 !important;
        }

        .hero-section a {
            font-weight: 500 !important;
            letter-spacing: 0.15em !important;
            text-transform: uppercase !important;
        }

        .section h2 {
            font-weight: 300 !important;
            letter-spacing: 0.05em !important;
            line-height: 1.2 !important;
        }

        .section h3 {
            font-weight: 500 !important;
            letter-spacing: 0.02em !important;
        }

        .section p {
            font-weight: 400 !important;
            letter-spacing: 0.01em !important;
            line-height: 1.6 !important;
        }

        /* FLIP CARDS */
        .flip-card {
            perspective: 1000px;
            height: 380px;
        }

        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s;
            transform-style: preserve-3d;
        }

        .flip-card-front,
        .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
        }

        .flip-card-back {
            transform: rotateY(180deg);
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        }

        /* MOBILE SWIPER STYLES */
        .subsidiaries-swiper {
            position: relative;
            overflow: hidden;
            margin-top: 2rem;
            width: 100%;
            max-width: 340px;
            margin-left: auto;
            margin-right: auto;
            padding: 0 15px;
        }

        .swiper-container {
            display: flex;
            transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            will-change: transform;
            gap: 25px;
        }

        .swiper-slide {
            flex: 0 0 calc(100% - 25px);
            width: calc(100% - 25px);
            filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.15));
        }

        /* MOBILE PAGINATION STYLES - NO BACKGROUND */
        .subsidiaries-swiper .swiper-pagination {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            margin-top: 2.5rem !important;
            gap: 1rem !important;
            padding: 0.75rem 0 !important;
            position: relative !important;
            z-index: 10 !important;
            width: fit-content !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        /* MOBILE PAGINATION DOTS - INACTIVE STATE */
        .subsidiaries-swiper .swiper-pagination .swiper-dot,
        .subsidiaries-swiper .swiper-pagination button,
        .subsidiaries-swiper .swiper-pagination button.swiper-dot,
        .swiper-pagination .swiper-dot,
        .swiper-dot,
        button.swiper-dot {
            width: 14px !important;
            height: 14px !important;
            border-radius: 50% !important;
            background-color: #ffffff !important;
            background: #ffffff !important;
            border: 2px solid #e2e8f0 !important;
            border-color: #e2e8f0 !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            outline: none !important;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.25) !important;
            opacity: 1 !important;
            display: inline-block !important;
            margin: 0 !important;
            padding: 0 !important;
            transform: scale(1) !important;
            appearance: none !important;
            -webkit-appearance: none !important;
        }

        /* MOBILE PAGINATION DOTS - ACTIVE STATE (#12e5f0) */
        .subsidiaries-swiper .swiper-pagination .swiper-dot.active,
        .subsidiaries-swiper .swiper-pagination button.active,
        .subsidiaries-swiper .swiper-pagination button.swiper-dot.active,
        .swiper-pagination .swiper-dot.active,
        .swiper-dot.active,
        button.swiper-dot.active {
            background-color: #12e5f0 !important;
            background: #12e5f0 !important;
            border-color: #12e5f0 !important;
            border: 2px solid #12e5f0 !important;
            transform: scale(1.3) !important;
            box-shadow: 0 4px 15px rgba(18, 229, 240, 0.6) !important;
        }

        /* MOBILE PAGINATION HOVER EFFECTS */
        .subsidiaries-swiper .swiper-pagination .swiper-dot:hover:not(.active),
        .swiper-dot:hover:not(.active) {
            background-color: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
            transform: scale(1.1) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
        }

        .subsidiaries-swiper .swiper-pagination .swiper-dot.active:hover,
        .swiper-dot.active:hover {
            background-color: #0dd4e0 !important;
            border-color: #0dd4e0 !important;
            box-shadow: 0 5px 18px rgba(18, 229, 240, 0.7) !important;
        }

        /* NAVIGATION BUTTONS */
        .swiper-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            font-size: 1.375rem;
            font-weight: 600;
        }

        .swiper-nav:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-50%) scale(1.1);
        }

        .swiper-nav-prev {
            left: -35px;
        }

        .swiper-nav-next {
            right: -35px;
        }

        /* DESKTOP STYLES */
        @media (min-width: 769px) {
            .flip-card:hover .flip-card-inner {
                transform: rotateY(180deg);
            }

            .subsidiaries-grid {
                display: grid !important;
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 2.5rem !important;
                max-width: 1200px !important;
                margin: 0 auto !important;
            }

            .desktop-only {
                display: grid !important;
            }

            .mobile-only {
                display: none !important;
            }
        }

        /* TABLET STYLES */
        @media (min-width: 769px) and (max-width: 1024px) {
            .subsidiaries-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 2rem !important;
            }

            .flip-card {
                height: 350px;
            }

            .section-padding {
                padding: 3rem 1.5rem !important;
            }
        }

        /* MOBILE STYLES */
        @media (max-width: 768px) {
            .parallax {
                background-attachment: scroll;
            }

            .flip-card.flipped .flip-card-inner {
                transform: rotateY(180deg);
            }

            .flip-card {
                height: 320px;
            }

            .flip-card-front,
            .flip-card-back {
                padding: 1.75rem;
            }

            .desktop-only {
                display: none !important;
            }

            .mobile-only {
                display: block !important;
            }

            .hero-section h1 {
                font-size: 2rem !important;
                line-height: 1.2;
                font-weight: 300 !important;
                letter-spacing: 0.08em !important;
            }

            .section-padding {
                padding: 2.5rem 1rem !important;
            }

            .footer-grid {
                grid-template-columns: 1fr !important;
                text-align: center !important;
                gap: 2rem !important;
            }

            .section h2 {
                font-size: 1.75rem !important;
            }

            .section h3 {
                font-size: 1.125rem !important;
            }

            .section p {
                font-size: 0.875rem !important;
            }

            .subsidiaries-swiper {
                max-width: 320px;
                padding: 0 20px;
            }

            .swiper-nav {
                width: 45px;
                height: 45px;
                font-size: 1.25rem;
            }

            .swiper-nav-prev {
                left: -30px;
            }

            .swiper-nav-next {
                right: -30px;
            }
        }

        /* SMALL MOBILE STYLES */
        @media (max-width: 480px) {
            .subsidiaries-swiper {
                max-width: 300px;
                padding: 0 18px;
            }

            .flip-card {
                height: 280px;
            }

            .swiper-nav {
                display: none;
            }

            .hero-section h1 {
                font-size: 1.75rem !important;
                letter-spacing: 0.05em !important;
            }

            .section-padding {
                padding: 2rem 0.75rem !important;
            }

            .section h2 {
                font-size: 1.5rem !important;
            }

            .section h3 {
                font-size: 1rem !important;
            }

            .section p {
                font-size: 0.8rem !important;
            }
        }

        /* EXTRA SMALL DEVICES */
        @media (max-width: 360px) {
            .hero-section h1 {
                font-size: 1.5rem !important;
            }

            .subsidiaries-swiper {
                max-width: 280px;
                padding: 0 10px;
            }

            .flip-card {
                height: 260px;
            }

            .section-padding {
                padding: 1.5rem 0.5rem !important;
            }

            .section h2 {
                font-size: 1.25rem !important;
            }

            .section h3 {
                font-size: 0.9rem !important;
            }

            .flip-card-front,
            .flip-card-back {
                padding: 1.25rem;
            }
        }

        /* LARGE SCREENS */
        @media (min-width: 1441px) {
            .container {
                max-width: 1400px;
            }

            .hero-section h1 {
                font-size: 4rem !important;
            }

            .section h2 {
                font-size: 2.5rem !important;
            }

            .flip-card {
                height: 420px;
            }

            .section-padding {
                padding: 4rem 2rem !important;
            }
        }

        /* ULTRA WIDE SCREENS */
        @media (min-width: 1920px) {
            .container {
                max-width: 1600px;
            }

            .hero-section h1 {
                font-size: 5rem !important;
            }

            .section h2 {
                font-size: 3rem !important;
            }

            .flip-card {
                height: 450px;
            }
        }

        /* BUTTONS AND ANIMATIONS */
        .btn-fill {
            position: relative;
            overflow: hidden;
        }

        .fill-bg {
            position: absolute;
            inset: 0;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s ease-out;
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

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .delay-300 {
            animation-delay: 0.3s;
            opacity: 0;
        }

        /* PERFORMANCE OPTIMIZATIONS */
        .section {
            overflow-x: hidden;
        }

        .lazy-bg {
            background-image: none !important;
        }

        .lazy-bg.loaded {
            background-image: inherit !important;
        }

        /* ACCESSIBILITY */
        @media (prefers-reduced-motion: reduce) {
            .animate-fade-in-up,
            .transition-all,
            .transform,
            .flip-card-inner {
                animation: none !important;
                transition: none !important;
            }
        }

        /* PRINT STYLES */
        @media print {
            .section {
                page-break-inside: avoid;
            }
            
            .parallax {
                background-attachment: scroll !important;
            }
            
            .swiper-nav,
            .swiper-pagination,
            #mobile-menu,
            #mobile-menu-toggle {
                display: none !important;
            }
        }

        /* HIGH DPI / RETINA DISPLAYS */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .flip-card-front,
            .flip-card-back {
                image-rendering: -webkit-optimize-contrast;
            }
        }

        /* LANDSCAPE MOBILE */
        @media (max-width: 768px) and (orientation: landscape) {
            .hero-section h1 {
                font-size: 1.8rem !important;
            }
            
            .section-padding {
                padding: 2rem 1rem !important;
            }
            
            .flip-card {
                height: 280px;
            }
        }
    </style>
@endpush

{{-- CONTENT SECTION --}}
@section('content')
    <div id="fullpage">

        {{-- HERO SECTION --}}
        <div class="section relative parallax hero-bg" data-anchor="intro">
            <div class="absolute inset-0 bg-black bg-opacity-10"></div>
            <div class="relative z-10 flex items-center justify-center min-h-screen text-center text-white">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 hero-section">
                    <h1 class="text-5xl font-light mb-6 leading-tight" style="text-transform: none !important;">
                        Delivering Professionalism <br>
                        to a Better Future
                    </h1>
                    <p class="text-xs sm:text-sm md:text-base mb-4 animate-fade-in-up delay-300 font-light tracking-wide">
                        We're changing the world
                    </p>
                    <a href="#about-us"
                        class="btn-fill relative inline-block mt-8 border-4 px-6 sm:px-8 py-3 rounded-md text-sm sm:text-base md:text-lg font-bold uppercase tracking-wide overflow-hidden"
                        style="border-color:#48D1CC; color:#ffffff;">
                        <span class="relative z-10">SHOW ME HOW</span>
                        <span
                            class="fill-bg absolute inset-0 bg-[#48D1CC] transform scale-x-0 origin-left transition-transform duration-500 ease-out"></span>
                    </a>
                </div>
            </div>
        </div>

        {{-- ABOUT US SECTION 1 --}}
        <div class="section relative parallax" data-anchor="about-us">
            <div class="container mx-auto px-4 sm:px-6 py-12 sm:py-20 section-padding">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <div class="order-2 lg:order-1 space-y-4 sm:space-y-6">
                        <img src="{{ asset('images/grid_foto-removebg-preview.png') }}" alt="Profil Distributor Kompresor"
                            class="w-full rounded-lg shadow-xl transform hover:scale-105 transition-transform duration-500">
                    </div>

                    <div class="order-1 lg:order-2 space-y-6 sm:space-y-8">
                        <div>
                            <h2 class="text-3xl sm:text-4xl md:text-5xl font-light mb-4 sm:mb-6 tracking-wide">
                                <span class="bg-clip-text text-[#48D1CC]">
                                    Story About PolaPetro
                                </span>
                            </h2>
                            <p
                                class="text-gray-600 text-base sm:text-lg leading-relaxed mb-4 sm:mb-6 font-normal tracking-wide">
                                Located in Jakarta, Indonesia Pola Petro Development (PPD) serves as the umbrella
                                organisation providing corporate services to its operating subsidiaries:
                            </p>
                        </div>

                        <div class="space-y-3 sm:space-y-4">
                            @php
                                $subsidiaries = [
                                    'PT Petrotec Air Power (PAP) including Cikarang factory authorised workshop and Batam fabrication and assembly plant.',
                                    'PT Petrotec Rekayasa Dinamika (Petrodyn)',
                                    'PT Smartpack Machinery (SMI)'
                                ];
                            @endphp

                            @foreach($subsidiaries as $subsidiary)
                                <div class="flex items-center space-x-2">
                                    <span class="text-[#48D1CC] font-bold text-lg flex-shrink-0">&gt;</span>
                                    <p class="text-gray-600 text-sm sm:text-base font-normal tracking-wide">
                                        {{ $subsidiary }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

                        <p class="text-gray-600 text-base sm:text-lg leading-relaxed font-normal tracking-wide">
                            Our satisfied customers comprises all the key players in respective industries: Textile and
                            Fibre, oil and gas, petrochemical, food and beverage, pharmaceuticals, plastic, packaging and
                            printing, electrical and electronics, power plants, cement and building materials, glass and
                            ceramics, wood based, air separation, pulp and paper, engineering and construction.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- VISION MISSION SECTION --}}
        <div class="section relative overflow-hidden bg-[#edf7ff]" data-anchor="vision-mission">
            <div class="hidden lg:block absolute top-0 right-0 w-1/2 h-full overflow-hidden">
                <img src="{{ asset('images/logo-compro3.png') }}" alt="Company Profile Logo"
                    class="absolute top-0 left-0 w-[150%] scale-[1] max-w-none h-full object-cover object-center">
            </div>

            <div class="container mx-auto px-4 sm:px-6 py-12 sm:py-20 relative z-10 section-padding">
                <div class="w-full lg:w-1/2 lg:pl-[100px] space-y-8 sm:space-y-10">
                    <div class="block lg:hidden mb-6">
                        <img src="{{ asset('images/logo-compro3.png') }}" alt="Company Profile Logo"
                            class="w-full max-w-md ml-0 rounded-lg shadow-lg">
                    </div>

                    @php
                        $visionMission = [
                            [
                                'number' => '1',
                                'title' => 'Vision',
                                'content' => 'Our Vision is to be a reputable holding company demonstrating professionalism in all conducts that drives continuous innovation, growth, and sustainable business operations.'
                            ],
                            [
                                'number' => '2',
                                'title' => 'Mission',
                                'content' => 'Our Mission is committed to provide excellent leadership, aspiration, resources, to support our Subsidiaries achieving their Company mission. In doing so, we are to strive for excellence and continually develop, act with integrity, and being well timed in any undertakings.'
                            ],
                            [
                                'number' => '3',
                                'title' => 'Goal',
                                'content' => 'Our Goal is total stakeholders satisfaction.'
                            ]
                        ];
                    @endphp

                    @foreach($visionMission as $item)
                        <div class="relative">
                            <div class="flex space-x-4 sm:space-x-6">
                                <div class="flex-shrink-0 relative z-10">
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 bg-white border border-gray-300 rounded-full flex items-center justify-center relative">
                                        <span class="font-normal text-xs sm:text-sm text-gray-600">{{ $item['number'] }}</span>
                                        @if(!$loop->last)
                                            <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-px bg-gray-300"
                                                style="height: 160px;"></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-1 pb-6 sm:pb-8">
                                    <h3 class="text-base sm:text-lg font-normal mb-2 sm:mb-3 text-gray-800">
                                        {{ $item['title'] }}
                                    </h3>
                                    <p class="leading-relaxed text-gray-600 text-xs sm:text-sm font-normal">
                                        {{ $item['content'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- SUBSIDIARIES SECTION --}}
        <div class="section relative parallax" data-anchor="subsidiaries"
            style="background-image: url('{{ asset('images/3people.jpg') }}'); background-position: center 10%; background-size: cover;">
            <div class="absolute inset-0 bg-black bg-opacity-10"></div>
            <div class="relative z-10 container mx-auto px-4 sm:px-6 py-12 sm:py-20 section-padding">

                <div class="text-center mb-4 sm:mb-6 -mt-6">
                    <h2 class="text-lg sm:text-xl md:text-2xl font-light text-white mb-1 tracking-wide">
                        Our Proud Subsidiaries
                    </h2>
                    <div class="w-16 sm:w-20 h-1 bg-[#48D1CC] mx-auto mb-1 sm:mb-2"></div>
                    <p
                        class="text-gray-300 text-[10px] sm:text-xs md:text-sm max-w-lg mx-auto px-2 sm:px-4 font-light tracking-wide">
                        There are countless reasons why our service is better than the rest, here you can learn what
                        makes us different. No matter the size of your business, you will be able to benefit from our
                        services.
                    </p>
                </div>

                @php
                    $companies = [
                        [
                            'name' => 'PT. Petrotec Air Power',
                            'description' => 'The leading provider of reliable uninterrupted supply of contaminent-free & energy efficient air system (kompresor udara) in Indonesia.',
                            'image' => 'petrotec-black.jpg',
                            'url' => 'http://www.airpower.co.id/'
                        ],
                        [
                            'name' => 'PT. Petrotec Rekayasa Dinamika',
                            'description' => 'Provider of high quality and tailored solution in the sales and services of engineered compressed air (kompresor angin) and gas systems.',
                            'image' => 'petrodyn-black.jpg',
                            'url' => 'http://www.petrodyn.co.id/'
                        ],
                        [
                            'name' => 'PT. Smartpack Machinery Indonesia',
                            'description' => 'Provider of best in class solution for bottling and packaging industries.',
                            'image' => 'SMI-new.jpg',
                            'url' => 'http://www.smartpack.co.id/'
                        ]
                    ];
                @endphp

                {{-- Desktop Grid Layout --}}
                <div
                    class="hidden md:grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 subsidiaries-grid desktop-only">
                    @foreach($companies as $index => $company)
                        <div class="flip-card" data-card="{{ $index }}">
                            <div class="flip-card-inner">
                                <div class="flip-card-front bg-cover bg-center"
                                    style="background-image: url('{{ asset('images/' . $company['image']) }}');">
                                </div>
                                <div class="flip-card-back text-white">
                                    <div class="space-y-3 sm:space-y-4">
                                        <h3 class="text-lg sm:text-xl font-semibold tracking-wide uppercase">
                                            {{ $company['name'] }}
                                        </h3>
                                        <p class="text-xs sm:text-sm leading-relaxed font-normal tracking-wide">
                                            {{ $company['description'] }}
                                        </p>
                                        <a href="{{ $company['url'] }}" target="_blank"
                                            class="inline-block bg-gradient-to-r from-[#48D1CC] to-[#48D1CC] text-white px-4 sm:px-6 py-2 rounded-full text-xs sm:text-sm font-medium hover:shadow-lg transform hover:scale-105 transition-all duration-300 tracking-wider uppercase">
                                            Show More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Mobile Swiper Layout --}}
                <div class="md:hidden subsidiaries-swiper mobile-only">
                    <button class="swiper-nav swiper-nav-prev">‹</button>
                    <div class="swiper-container">
                        @foreach($companies as $index => $company)
                            <div class="swiper-slide">
                                <div class="flip-card" data-card="{{ $index }}">
                                    <div class="flip-card-inner">
                                        <div class="flip-card-front bg-cover bg-center"
                                            style="background-image: url('{{ asset('images/' . $company['image']) }}');">
                                        </div>
                                        <div class="flip-card-back text-white">
                                            <div class="space-y-3 sm:space-y-4">
                                                <h3 class="text-lg sm:text-xl font-semibold tracking-wide uppercase">
                                                    {{ $company['name'] }}
                                                </h3>
                                                <p class="text-xs sm:text-sm leading-relaxed font-normal tracking-wide">
                                                    {{ $company['description'] }}
                                                </p>
                                                <a href="{{ $company['url'] }}" target="_blank"
                                                    class="inline-block bg-gradient-to-r from-[#48D1CC] to-[#48D1CC] text-white px-4 sm:px-6 py-2 rounded-full text-xs sm:text-sm font-medium hover:shadow-lg transform hover:scale-105 transition-all duration-300 tracking-wider uppercase">
                                                    Show More
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="swiper-nav swiper-nav-next">›</button>

                    <div class="swiper-pagination">
                        @foreach($companies as $index => $company)
                            <button class="swiper-dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTACT SECTION --}}
        <div class="section relative parallax" data-anchor="let-us-help-you"
            style="background-image: url('{{ asset('images/hi.jpg') }}'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-black bg-opacity-10"></div>
            <div class="relative z-10 flex items-center min-h-screen text-white">
                <div class="max-w-3xl px-6 sm:px-12 md:px-20 lg:ml-32 text-left">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-light mb-1 leading-snug">
                        Growing your business means
                    </h2>
                    <p class="text-sm sm:text-base md:text-lg font-light text-gray-200">
                        Growing together for a better nation
                    </p>
                    <a href="{{ route('contact') }}"
                        class="btn-fill relative inline-block mt-8 border-4 px-6 sm:px-8 py-3 rounded-md text-sm sm:text-base md:text-lg font-bold uppercase tracking-wide overflow-hidden"
                        style="border-color:#48D1CC; color:#ffffff;">
                        <span class="relative z-10">Let Us Help You</span>
                        <span
                            class="fill-bg absolute inset-0 bg-[#48D1CC] transform scale-x-0 origin-left transition-transform duration-500 ease-out"></span>
                    </a>
                </div>
            </div>
        </div>

        {{-- FOOTER SECTION --}}
        <div class="section gradient-overlay fp-auto-height" data-anchor="footer">
            <div class="container mx-auto px-15 sm:px-12 py-2 sm:py-3">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center text-white w-full footer-grid">
                    <div class="space-y-3 lg:pl-16 xl:pl-20">
                        <h2 class="text-lg sm:text-xl lg:text-2xl font-medium tracking-wide">
                            Have awesome experience with us
                        </h2>
                        <p class="text-sm sm:text-base text-gray-100 font-light tracking-wide">
                            Your dream work is waiting for you!
                        </p>
                    </div>
                    <div class="text-center lg:text-right lg:pr-16 xl:pr-20">
                        <a href="{{ route('careers') }}"
                            class="btn-fill relative inline-block mt-8 border-4 px-6 sm:px-8 py-3 rounded-md text-sm sm:text-base md:text-lg font-bold uppercase tracking-wide overflow-hidden"
                            style="border-color:#12e5f0; color:#ffffff;">
                            <span class="relative z-10">Join Us Now</span>
                            <span
                                class="fill-bg absolute inset-0 bg-[#12e5f0] transform scale-x-0 origin-left transition-transform duration-500 ease-out"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MOBILE NAVIGATION --}}
    <div class="fixed top-4 right-4 z-50 lg:hidden">
        <button id="mobile-menu-toggle" class="bg-white bg-opacity-20 backdrop-blur-sm text-white p-3 rounded-full">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div id="mobile-menu" class="fixed inset-0 bg-black bg-opacity-95 z-40 hidden lg:hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <nav class="text-center space-y-6">
                <a href="#intro" class="block text-white text-xl hover:text-green-400 transition-colors py-2">Home</a>
                <a href="#about-us" class="block text-white text-xl hover:text-green-400 transition-colors py-2">About
                    Us</a>
                <a href="#subsidiaries"
                    class="block text-white text-xl hover:text-green-400 transition-colors py-2">Subsidiaries</a>
                <a href="{{ route('contact') }}"
                    class="block text-white text-xl hover:text-green-400 transition-colors py-2">Contact</a>
                <a href="{{ route('careers') }}"
                    class="block text-white text-xl hover:text-green-400 transition-colors py-2">Careers</a>
            </nav>
        </div>
    </div>
@endsection

{{-- SCRIPTS SECTION --}}
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/3.1.2/fullpage.min.js"></script>
    <script>
        // DEVICE DETECTION
        const isMobile = window.matchMedia('(max-width: 1024px)').matches;
        const isTouch = 'ontouchstart' in window;

        // FULLPAGE.JS CONFIGURATION
        const fullpageConfig = {
            anchors: ['intro', 'about-us', 'vision-mission', 'subsidiaries', 'let-us-help-you', 'footer'],
            navigation: true,
            navigationPosition: 'right',
            navigationTooltips: ['Intro', 'Story About Us', 'vision-mission', 'Subsidiaries', 'Let Us Help You', 'Join Us'],
            responsiveWidth: 768,
            scrollingSpeed: isMobile ? 500 : 700,
            scrollBar: true,
            css3: false,
            fitToSection: false,
            ...(isMobile && {
                touchSensitivity: 5,
                normalScrollElementTouchThreshold: 5
            }),
            onLeave: function (origin, destination, direction) {
                if (isMobile) {
                    document.body.style.pointerEvents = 'none';
                    setTimeout(() => {
                        document.body.style.pointerEvents = 'auto';
                    }, 100);
                }
            }
        };

        // Initialize FullPage.js
        new fullpage('#fullpage', fullpageConfig);

        // HERO BUTTON INTERACTIONS
        function initHeroButtons() {
            document.querySelectorAll('.btn-fill').forEach(btn => {
                const bg = btn.querySelector('.fill-bg');

                btn.addEventListener('mouseenter', () => {
                    bg.style.transformOrigin = "left";
                    bg.style.transform = "scaleX(1)";
                    btn.style.color = "#ffffff";
                });

                btn.addEventListener('mouseleave', () => {
                    bg.style.transformOrigin = "right";
                    bg.style.transform = "scaleX(0)";
                    btn.style.color = "#ffffff";
                });

                if (btn.getAttribute('href') && btn.getAttribute('href').startsWith('#')) {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        if (typeof fullpage_api !== 'undefined') {
                            const anchor = btn.getAttribute('href').replace('#', '');
                            fullpage_api.moveTo(anchor);
                        }
                    });
                }
            });
        }

        // MOBILE PARALLAX FALLBACK
        function initMobileParallax() {
            if (!isMobile) return;

            const parallaxSections = document.querySelectorAll('.parallax');
            let ticking = false;

            function updateParallax() {
                const scrollY = window.scrollY || window.pageYOffset;
                parallaxSections.forEach((sec) => {
                    const speed = parseFloat(sec.getAttribute('data-parallax-speed') || '0.4');
                    sec.style.backgroundPosition = `center ${Math.round(scrollY * speed)}px`;
                });
                ticking = false;
            }

            function requestTick() {
                if (!ticking) {
                    requestAnimationFrame(updateParallax);
                    ticking = true;
                }
            }

            updateParallax();
            document.addEventListener('scroll', requestTick, { passive: true });
            window.addEventListener('resize', updateParallax, { passive: true });
        }

        // MOBILE SWIPER - Updated with #12e5f0 color and no background
        function initMobileSwiper() {
            if (window.innerWidth > 768) return;

            let currentSlide = 0;
            const slides = document.querySelectorAll('.swiper-slide');
            const container = document.querySelector('.swiper-container');
            const pagination = document.querySelector('.swiper-pagination');
            const prevBtn = document.querySelector('.swiper-nav-prev');
            const nextBtn = document.querySelector('.swiper-nav-next');

            if (!slides.length || !container || !pagination) return;

            // Create pagination dots
            function createDots() {
                pagination.innerHTML = '';
                slides.forEach((_, index) => {
                    const dot = document.createElement('button');
                    dot.className = 'swiper-dot';
                    dot.setAttribute('data-slide', index);

                    // Apply inactive styles
                    applyInactiveStyles(dot);

                    if (index === 0) {
                        dot.classList.add('active');
                        applyActiveStyles(dot);
                    }

                    dot.addEventListener('click', (e) => {
                        e.preventDefault();
                        goToSlide(index);
                    });

                    pagination.appendChild(dot);
                });
            }

            // Apply active styles (#12e5f0)
            function applyActiveStyles(dot) {
                dot.className = 'swiper-dot active';

                dot.style.cssText = '';
                dot.style.setProperty('width', '14px', 'important');
                dot.style.setProperty('height', '14px', 'important');
                dot.style.setProperty('border-radius', '50%', 'important');
                dot.style.setProperty('background-color', '#12e5f0', 'important');
                dot.style.setProperty('background', '#12e5f0', 'important');
                dot.style.setProperty('border', '2px solid #12e5f0', 'important');
                dot.style.setProperty('border-color', '#12e5f0', 'important');
                dot.style.setProperty('cursor', 'pointer', 'important');
                dot.style.setProperty('transition', 'all 0.3s ease', 'important');
                dot.style.setProperty('outline', 'none', 'important');
                dot.style.setProperty('box-shadow', '0 4px 15px rgba(18, 229, 240, 0.6)', 'important');
                dot.style.setProperty('opacity', '1', 'important');
                dot.style.setProperty('display', 'inline-block', 'important');
                dot.style.setProperty('margin', '0', 'important');
                dot.style.setProperty('padding', '0', 'important');
                dot.style.setProperty('transform', 'scale(1.3)', 'important');
                dot.style.setProperty('appearance', 'none', 'important');
                dot.style.setProperty('-webkit-appearance', 'none', 'important');
            }

            // Apply inactive styles (White)
            function applyInactiveStyles(dot) {
                dot.className = 'swiper-dot';

                dot.style.cssText = '';
                dot.style.setProperty('width', '14px', 'important');
                dot.style.setProperty('height', '14px', 'important');
                dot.style.setProperty('border-radius', '50%', 'important');
                dot.style.setProperty('background-color', '#ffffff', 'important');
                dot.style.setProperty('background', '#ffffff', 'important');
                dot.style.setProperty('border', '2px solid #e2e8f0', 'important');
                dot.style.setProperty('border-color', '#e2e8f0', 'important');
                dot.style.setProperty('cursor', 'pointer', 'important');
                dot.style.setProperty('transition', 'all 0.3s ease', 'important');
                dot.style.setProperty('outline', 'none', 'important');
                dot.style.setProperty('box-shadow', '0 3px 10px rgba(0, 0, 0, 0.25)', 'important');
                dot.style.setProperty('opacity', '1', 'important');
                dot.style.setProperty('display', 'inline-block', 'important');
                dot.style.setProperty('margin', '0', 'important');
                dot.style.setProperty('padding', '0', 'important');
                dot.style.setProperty('transform', 'scale(1)', 'important');
                dot.style.setProperty('appearance', 'none', 'important');
                dot.style.setProperty('-webkit-appearance', 'none', 'important');
            }

            // Update pagination
            function updatePagination() {
                const dots = pagination.querySelectorAll('.swiper-dot');

                dots.forEach((dot, index) => {
                    dot.classList.remove('active');

                    if (index === currentSlide) {
                        dot.classList.add('active');
                        applyActiveStyles(dot);
                    } else {
                        applyInactiveStyles(dot);
                    }
                });

                // Force update with timeout
                setTimeout(() => {
                    dots.forEach((dot, index) => {
                        if (index === currentSlide) {
                            applyActiveStyles(dot);
                        } else {
                            applyInactiveStyles(dot);
                        }
                    });
                }, 50);
            }

            // Go to specific slide
            function goToSlide(index) {
                if (index < 0 || index >= slides.length) return;

                currentSlide = index;
                container.style.transform = `translateX(-${index * 100}%)`;
                container.style.transition = 'transform 0.4s ease';
                updatePagination();
            }

            // Navigation functions
            function nextSlide() {
                const newIndex = currentSlide + 1 < slides.length ? currentSlide + 1 : 0;
                goToSlide(newIndex);
            }

            function prevSlide() {
                const newIndex = currentSlide - 1 >= 0 ? currentSlide - 1 : slides.length - 1;
                goToSlide(newIndex);
            }

            // Touch events
            let startX = 0;
            let isDragging = false;

            container.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                isDragging = true;
                container.style.transition = 'none';
            }, { passive: true });

            container.addEventListener('touchmove', (e) => {
                if (!isDragging) return;

                const currentX = e.touches[0].clientX;
                const diffX = currentX - startX;
                const translateX = -currentSlide * 100 + (diffX / container.offsetWidth * 100);

                container.style.transform = `translateX(${translateX}%)`;
            }, { passive: true });

            container.addEventListener('touchend', (e) => {
                if (!isDragging) return;

                const endX = e.changedTouches[0].clientX;
                const diffX = startX - endX;

                isDragging = false;
                container.style.transition = 'transform 0.4s ease';

                if (Math.abs(diffX) > 50) {
                    if (diffX > 0) {
                        nextSlide();
                    } else {
                        prevSlide();
                    }
                } else {
                    goToSlide(currentSlide);
                }
            }, { passive: true });

            // Navigation button events
            if (prevBtn) prevBtn.addEventListener('click', prevSlide);
            if (nextBtn) nextBtn.addEventListener('click', nextSlide);

            // Flip card touch events for mobile swiper
            const flipCards = document.querySelectorAll('.subsidiaries-swiper .flip-card');
            flipCards.forEach(card => {
                let isFlipped = false;
                let touchStartTime = 0;
                let startTouchX = 0;

                card.addEventListener('touchstart', (e) => {
                    touchStartTime = Date.now();
                    startTouchX = e.touches[0].clientX;
                }, { passive: true });

                card.addEventListener('touchend', (e) => {
                    const touchDuration = Date.now() - touchStartTime;
                    const endTouchX = e.changedTouches[0].clientX;
                    const touchDistance = Math.abs(endTouchX - startTouchX);

                    if (touchDuration < 200 && touchDistance < 10) {
                        e.stopPropagation();
                        isFlipped = !isFlipped;
                        card.classList.toggle('flipped', isFlipped);
                    }
                }, { passive: false });

                document.addEventListener('touchstart', (e) => {
                    if (!card.contains(e.target) && isFlipped) {
                        card.classList.remove('flipped');
                        isFlipped = false;
                    }
                }, { passive: true });
            });

            // Initialize
            createDots();
            updatePagination();
        }

        // MOBILE MENU HANDLER
        function initMobileMenu() {
            const menuToggle = document.getElementById('mobile-menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuLinks = document.querySelectorAll('#mobile-menu a');

            if (!menuToggle || !mobileMenu) return;

            menuToggle.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
                document.body.style.overflow = mobileMenu.classList.contains('hidden') ? 'auto' : 'hidden';
            });

            menuLinks.forEach(link => {
                link.addEventListener('click', function () {
                    mobileMenu.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                });
            });

            mobileMenu.addEventListener('click', function (e) {
                if (e.target === mobileMenu) {
                    mobileMenu.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            });
        }

        // LAZY LOADING
        function initLazyLoading() {
            const lazyBgs = document.querySelectorAll('.lazy-bg');

            if ('IntersectionObserver' in window) {
                const lazyBgObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('loaded');
                            lazyBgObserver.unobserve(entry.target);
                        }
                    });
                });

                lazyBgs.forEach(bg => {
                    lazyBgObserver.observe(bg);
                });
            } else {
                lazyBgs.forEach(bg => bg.classList.add('loaded'));
            }
        }

        // PERFORMANCE OPTIMIZATIONS
        function initPerformanceOptimizations() {
            let resizeTimeout;
            window.addEventListener('resize', function () {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function () {
                    if (typeof fullpage_api !== 'undefined') {
                        fullpage_api.reBuild();
                    }

                    if (window.innerWidth <= 768) {
                        setTimeout(() => {
                            initMobileSwiper();
                        }, 100);
                    }
                }, 250);
            }, { passive: true });

            if (isMobile) {
                const criticalImages = [
                    '{{ asset('images/businis.jpg') }}',
                    '{{ asset('images/logo-compro3.png') }}'
                ];

                criticalImages.forEach(src => {
                    const img = new Image();
                    img.src = src;
                });
            }
        }

        // INITIALIZE ALL FUNCTIONS
        document.addEventListener('DOMContentLoaded', function () {
            initHeroButtons();
            initMobileParallax();
            initMobileSwiper();
            initMobileMenu();
            initLazyLoading();
            initPerformanceOptimizations();
        });
    </script>
@endpush