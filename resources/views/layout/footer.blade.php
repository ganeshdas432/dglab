<!-- Footer Section -->
<footer class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-white mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Footer Content -->
        <div class="py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            <!-- Company Info -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-hospital text-white text-lg"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">DG Lab</h3>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed">
                    Your trusted partner in medical excellence, providing comprehensive healthcare management solutions
                    with cutting-edge technology and compassionate care.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-200">
                        <i class="fab fa-facebook-f text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-200">
                        <i class="fab fa-twitter text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-200">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-200">
                        <i class="fab fa-linkedin-in text-lg"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-link mr-2 text-blue-400"></i>
                    Quick Links
                </h4>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center">
                            <i class="fas fa-chevron-right mr-2 text-blue-400 text-xs"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctors.index') }}"
                            class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center">
                            <i class="fas fa-chevron-right mr-2 text-blue-400 text-xs"></i>
                            Our Doctors
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('appointments.index') }}"
                            class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center">
                            <i class="fas fa-chevron-right mr-2 text-blue-400 text-xs"></i>
                            Appointments
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.index') }}"
                            class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center">
                            <i class="fas fa-chevron-right mr-2 text-blue-400 text-xs"></i>
                            Medical Reports
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Services -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-stethoscope mr-2 text-blue-400"></i>
                    Our Services
                </h4>
                <ul class="space-y-2">
                    <li class="text-gray-300 flex items-center">
                        <i class="fas fa-chevron-right mr-2 text-blue-400 text-xs"></i>
                        General Medicine
                    </li>
                    <li class="text-gray-300 flex items-center">
                        <i class="fas fa-chevron-right mr-2 text-blue-400 text-xs"></i>
                        Diagnostic Services
                    </li>
                    <li class="text-gray-300 flex items-center">
                        <i class="fas fa-chevron-right mr-2 text-blue-400 text-xs"></i>
                        Laboratory Testing
                    </li>
                    <li class="text-gray-300 flex items-center">
                        <i class="fas fa-chevron-right mr-2 text-blue-400 text-xs"></i>
                        Digital Reports
                    </li>
                    <li class="text-gray-300 flex items-center">
                        <i class="fas fa-chevron-right mr-2 text-blue-400 text-xs"></i>
                        Online Consultation
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-phone mr-2 text-blue-400"></i>
                    Contact Us
                </h4>
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-map-marker-alt text-blue-400 mt-1"></i>
                        <div>
                            <p class="text-gray-300 text-sm">123 Healthcare Street</p>
                            <p class="text-gray-300 text-sm">Medical District, City 12345</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-phone text-blue-400"></i>
                        <a href="tel:+918100644924"
                            class="text-gray-300 hover:text-white transition-colors duration-200">
                            +91 8100644924
                        </a>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-envelope text-blue-400"></i>
                        <a href="mailto:doctorghoshsclinic@gmail.com"
                            class="text-gray-300 hover:text-white transition-colors duration-200">
                            doctorghoshsclinic@gmail.com
                        </a>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-clock text-blue-400"></i>
                        <div>
                            <p class="text-gray-300 text-sm">Mon - Sat: 7:00 AM - 5:00 PM</p>
                            <p class="text-gray-300 text-sm">Sunday: Emergency Only</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="border-t border-gray-700 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="flex items-center space-x-6">
                    <p class="text-gray-400 text-sm">
                        © {{ date('Y') }} DG Lab. All rights reserved.
                    </p>
                    <div class="flex items-center space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm">
                            Privacy Policy
                        </a>
                        <span class="text-gray-600">|</span>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm">
                            Terms of Service
                        </a>
                        <span class="text-gray-600">|</span>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm">
                            Support
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-gray-400 text-sm">Powered by</span>
                    <div class="flex items-center space-x-1">
                        <i class="fas fa-heart text-red-500 text-sm"></i>
                        <span class="text-white text-sm font-medium">Laravel</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button id="backToTop"
    class="fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-lg transition-all duration-300 opacity-0 transform translate-y-4 pointer-events-none z-50">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Emergency Contact Banner -->
<div id="emergencyBanner"
    class="fixed bottom-20 left-6 bg-red-600 text-white p-4 rounded-lg shadow-lg max-w-sm opacity-0 transform translate-x-[-100%] transition-all duration-500 z-40">
    <div class="flex items-center space-x-3">
        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
            <i class="fas fa-ambulance text-red-600"></i>
        </div>
        <div>
            <p class="font-semibold text-sm">Emergency?</p>
            <p class="text-xs">Call us immediately</p>
        </div>
        <a href="tel:+918100644924"
            class="bg-white text-red-600 px-3 py-1 rounded-full text-xs font-semibold hover:bg-gray-100 transition-colors">
            Call Now
        </a>
    </div>
    <button onclick="hideEmergencyBanner()" class="absolute top-1 right-1 text-white hover:text-gray-200">
        <i class="fas fa-times text-xs"></i>
    </button>
</div>

<!-- Scripts -->
@yield('scripts')

<script>
    // Common JavaScript functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Back to top button functionality
        const backToTopBtn = document.getElementById('backToTop');

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                backToTopBtn.classList.add('opacity-100', 'translate-y-0');
            } else {
                backToTopBtn.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
                backToTopBtn.classList.remove('opacity-100', 'translate-y-0');
            }
        });

        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Emergency banner functionality
        const emergencyBanner = document.getElementById('emergencyBanner');

        // Show emergency banner after 5 seconds
        setTimeout(function() {
            if (!localStorage.getItem('emergencyBannerHidden')) {
                emergencyBanner.classList.remove('opacity-0', 'translate-x-[-100%]');
                emergencyBanner.classList.add('opacity-100', 'translate-x-0');
            }
        }, 5000);

        // Enhanced file upload functionality (if needed)
        const fileInput = document.getElementById('file-input');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const fileInfo = document.getElementById('file-info');
                const fileName = document.getElementById('file-name');

                if (file) {
                    fileName.textContent = file.name;
                    fileInfo.classList.remove('hidden');
                } else {
                    fileInfo.classList.add('hidden');
                }
            });

            // Drag and drop functionality
            const fileDropArea = document.querySelector('.file-drop');
            if (fileDropArea) {
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    fileDropArea.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                ['dragenter', 'dragover'].forEach(eventName => {
                    fileDropArea.addEventListener(eventName, highlight, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    fileDropArea.addEventListener(eventName, unhighlight, false);
                });

                function highlight(e) {
                    fileDropArea.classList.add('border-blue-500', 'bg-blue-50');
                }

                function unhighlight(e) {
                    fileDropArea.classList.remove('border-blue-500', 'bg-blue-50');
                }

                fileDropArea.addEventListener('drop', handleDrop, false);

                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;

                    fileInput.files = files;

                    // Trigger change event
                    const event = new Event('change', {
                        bubbles: true
                    });
                    fileInput.dispatchEvent(event);
                }
            }
        }

        // Common form validation and UI enhancements
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
                }
            });
        });

        // Auto-hide success/error messages
        const messages = document.querySelectorAll('.bg-green-50, .bg-red-50');
        messages.forEach(message => {
            setTimeout(() => {
                message.style.transition = 'opacity 0.5s ease';
                message.style.opacity = '0';
                setTimeout(() => {
                    message.remove();
                }, 500);
            }, 5000);
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Enhanced table interactions
        const tableRows = document.querySelectorAll('.table-row');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(4px)';
            });

            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });

        // Loading animation for navigation links
        const navLinks = document.querySelectorAll('nav a');
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.href && this.href !== window.location.href) {
                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.className = 'fas fa-spinner fa-spin';
                    }
                }
            });
        });

        // Toast notification system
        window.showToast = function(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-6 right-6 z-50 px-6 py-4 rounded-lg shadow-lg text-white transform translate-x-full transition-all duration-300 ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 
                type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500'
            }`;
            toast.innerHTML = `
                <div class="flex items-center space-x-3">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);

            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 300);
        };
    });

    // Global functions
    function hideEmergencyBanner() {
        const banner = document.getElementById('emergencyBanner');
        banner.classList.add('opacity-0', 'translate-x-[-100%]');
        localStorage.setItem('emergencyBannerHidden', 'true');
    }

    // Page performance monitoring
    window.addEventListener('load', function() {
        const loadTime = performance.now();
        if (loadTime > 3000) {
            console.warn('Page load time is slow:', loadTime + 'ms');
        }
    });
</script>

</body>

</html>