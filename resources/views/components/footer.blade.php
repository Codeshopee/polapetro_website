<footer class="bg-gray-900 text-white">
    <div class="container mx-auto px-6 py-16">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo-ppd.png') }}" alt="Pola Petro Development" class="h-8 w-auto">
                    <span class="font-bold">PPD</span>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed">
                    Delivering professionalism to build a better future through innovative industrial solutions.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="font-bold text-lg mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors">Home</a>
                    </li>
                    <li><a href="#about-us" class="text-gray-300 hover:text-white transition-colors">About Us</a></li>
                    <li><a href="#subsidiaries"
                            class="text-gray-300 hover:text-white transition-colors">Subsidiaries</a></li>
                    <li><a href="{{ route('careers') }}"
                            class="text-gray-300 hover:text-white transition-colors">Careers</a></li>
                </ul>
            </div>

            <!-- Subsidiaries -->
            <div>
                <h3 class="font-bold text-lg mb-4">Our Companies</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="http://www.airpower.co.id/" target="_blank"
                            class="text-gray-300 hover:text-white transition-colors">PT Petrotec Air Power</a></li>
                    <li><a href="http://www.petrodyn.co.id/" target="_blank"
                            class="text-gray-300 hover:text-white transition-colors">PT Petrotec Rekayasa Dinamika</a>
                    </li>
                    <li><a href="http://www.smartpack.co.id/" target="_blank"
                            class="text-gray-300 hover:text-white transition-colors">PT Smartpack Machinery
                            Indonesia</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="font-bold text-lg mb-4">Contact Info</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start space-x-2">
                        <i class="fas fa-map-marker-alt text-green-400 mt-1"></i>
                        <span class="text-gray-300">Jakarta, Indonesia</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-phone text-green-400"></i>
                        <span class="text-gray-300">+62 21 XXXX XXXX</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-envelope text-green-400"></i>
                        <span class="text-gray-300">info@polapetro.co.id</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-12 pt-8 text-center text-sm text-gray-400">
            <p>&copy; {{ date('Y') }} Pola Petro Development. All rights reserved.</p>
        </div>
    </div>
</footer>