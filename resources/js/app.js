import './bootstrap';

// Initialize AOS (Animate On Scroll)
import AOS from 'aos';
import 'aos/dist/aos.css';

document.addEventListener('DOMContentLoaded', function () {
    AOS.init({
        duration: 800,
        easing: 'ease-out',
        once: true,
        offset: 100
    });
});

// Enhanced Navigation
class Navigation {
    constructor() {
        this.nav = document.getElementById('main-navigation');
        this.mobileBtn = document.getElementById('mobile-menu-btn');
        this.mobileMenu = document.getElementById('mobile-menu');
        this.init();
    }

    init() {
        if (this.nav) {
            this.handleScroll();
            window.addEventListener('scroll', () => this.handleScroll());
        }

        if (this.mobileBtn && this.mobileMenu) {
            this.mobileBtn.addEventListener('click', () => this.toggleMobileMenu());
        }

        // Close mobile menu on link click
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => this.closeMobileMenu());
        });
    }

    handleScroll() {
        if (window.scrollY > 100) {
            this.nav.classList.add('nav-scrolled');
        } else {
            this.nav.classList.remove('nav-scrolled');
        }
    }

    toggleMobileMenu() {
        this.mobileMenu.classList.toggle('-translate-y-full');
        this.mobileMenu.classList.toggle('opacity-0');
    }

    closeMobileMenu() {
        this.mobileMenu.classList.add('-translate-y-full');
        this.mobileMenu.classList.add('opacity-0');
    }
}

// Mobile submenu toggle
window.toggleMobileSubmenu = function (id) {
    const submenu = document.getElementById(id);
    if (submenu) {
        submenu.classList.toggle('hidden');
    }
};

// Form enhancements
class FormEnhancer {
    constructor() {
        this.init();
    }

    init() {
        // Add loading states
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => this.handleSubmit(e, form));
        });

        // Real-time validation
        document.querySelectorAll('input, textarea').forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearErrors(input));
        });

        // Auto-hide alerts
        this.hideAlerts();
    }

    handleSubmit(e, form) {
        const button = form.querySelector('button[type="submit"]');
        if (button) {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
            button.disabled = true;

            // Re-enable button after 10 seconds as fallback
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 10000);
        }
    }

    validateField(input) {
        const value = input.value.trim();
        const name = input.getAttribute('name');

        // Clear previous errors
        this.clearErrors(input);

        // Basic validation
        if (input.hasAttribute('required') && !value) {
            this.showError(input, `${this.getFieldLabel(name)} is required`);
            return false;
        }

        if (input.type === 'email' && value && !this.isValidEmail(value)) {
            this.showError(input, 'Please enter a valid email address');
            return false;
        }

        return true;
    }

    clearErrors(input) {
        const errorEl = input.parentNode.querySelector('.field-error');
        if (errorEl) {
            errorEl.remove();
        }
        input.classList.remove('border-red-500');
        input.classList.add('border-gray-300');
    }

    showError(input, message) {
        input.classList.add('border-red-500');
        input.classList.remove('border-gray-300');

        const errorEl = document.createElement('p');
        errorEl.className = 'field-error text-red-500 text-sm mt-1';
        errorEl.textContent = message;
        input.parentNode.appendChild(errorEl);
    }

    getFieldLabel(name) {
        const labels = {
            'name': 'Name',
            'email': 'Email',
            'phone': 'Phone',
            'subject': 'Subject',
            'message': 'Message'
        };
        return labels[name] || name;
    }

    isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    hideAlerts() {
        const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'all 0.5s ease-out';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
    }
}

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const targetId = this.getAttribute('href').substring(1);
        const target = document.getElementById(targetId);

        if (target) {
            const headerHeight = document.getElementById('main-navigation')?.offsetHeight || 80;
            const targetPosition = target.offsetTop - headerHeight;

            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        }
    });
});

// Initialize classes
new Navigation();
new FormEnhancer();

// Loading screen (optional)
window.addEventListener('load', function () {
    const loader = document.getElementById('page-loader');
    if (loader) {
        loader.style.opacity = '0';
        setTimeout(() => loader.remove(), 300);
    }
});



mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .options({
        processCssUrls: false
    });

// Add versioning for production
if (mix.inProduction()) {
    mix.version();
}

// Add source maps for development
if (!mix.inProduction()) {
    mix.sourceMaps();
}