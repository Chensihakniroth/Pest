// GreenHome Pest Control - Main Application JavaScript
class GreenHomeApp {
    constructor() {
        this.init();
    }

    init() {
        this.initializeEventListeners();
        this.initializePasswordToggles();
        this.initializeFormValidations();
        this.initializeAutoRefresh();
        this.initializePageSpecificFeatures();
    }

    // Initialize all event listeners
    initializeEventListeners() {
        // Global form submission handlers
        document.addEventListener('submit', (e) => {
            this.handleFormSubmission(e);
        });

        // Global click handlers for toggle buttons
        document.addEventListener('click', (e) => {
            if (e.target.closest('.toggle-password')) {
                this.togglePasswordVisibility(e.target.closest('.toggle-password'));
            }
        });

        // Auto-refresh dashboard
        this.initializeAutoRefresh();
    }

    // Password strength checker
    static checkPasswordStrength(password, barId, textId) {
        const strengthBar = document.getElementById(barId);
        const strengthText = document.getElementById(textId);

        if (!strengthBar || !strengthText) return;

        let strength = 0;
        let tips = "";

        // Check password length
        if (password.length >= 8) {
            strength += 25;
        } else {
            tips += "Make the password at least 8 characters. ";
        }

        // Check for mixed case
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) {
            strength += 25;
        } else {
            tips += "Include both lowercase and uppercase letters. ";
        }

        // Check for numbers
        if (password.match(/\d/)) {
            strength += 25;
        } else {
            tips += "Include at least one number. ";
        }

        // Check for special characters
        if (password.match(/[^a-zA-Z\d]/)) {
            strength += 25;
        } else {
            tips += "Include at least one special character. ";
        }

        // Update progress bar
        strengthBar.style.width = strength + '%';

        // Update colors and text based on strength
        if (strength < 50) {
            strengthBar.className = 'progress-bar bg-danger';
            strengthText.textContent = 'Weak password';
            strengthText.className = 'text-danger';
        } else if (strength < 75) {
            strengthBar.className = 'progress-bar bg-warning';
            strengthText.textContent = 'Medium password';
            strengthText.className = 'text-warning';
        } else {
            strengthBar.className = 'progress-bar bg-success';
            strengthText.textContent = 'Strong password';
            strengthText.className = 'text-success';
        }

        // Show tips for weak passwords
        if (strength < 75 && password.length > 0) {
            strengthText.textContent += ' - ' + tips.trim();
        }
    }

    // Password match checker
    static checkPasswordMatch(passwordId, confirmId, textId) {
        const password = document.getElementById(passwordId)?.value;
        const confirmPassword = document.getElementById(confirmId)?.value;
        const matchText = document.getElementById(textId);

        if (!matchText) return;

        if (confirmPassword.length === 0) {
            matchText.textContent = '';
            matchText.className = 'text-muted';
        } else if (password === confirmPassword) {
            matchText.textContent = '✓ Passwords match';
            matchText.className = 'text-success';
        } else {
            matchText.textContent = '✗ Passwords do not match';
            matchText.className = 'text-danger';
        }
    }

    // Show error message
    static showError(message) {
        // Remove existing error alerts
        const existingAlerts = document.querySelectorAll('.alert-danger');
        existingAlerts.forEach(alert => alert.remove());

        // Create new error alert
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
        alertDiv.innerHTML = `
            <i class="fas fa-exclamation-circle me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Insert after the header or at the top of the form
        const header = document.querySelector('.text-center') || document.querySelector('.card-header');
        if (header) {
            header.parentNode.insertBefore(alertDiv, header.nextSibling);
        } else {
            document.body.insertBefore(alertDiv, document.body.firstChild);
        }
    }

    // Reset form with default values
    static resetForm(formId, defaults = {}) {
        const form = document.getElementById(formId);
        if (form) {
            form.reset();

            // Set default values if provided
            Object.keys(defaults).forEach(key => {
                const field = document.getElementById(key);
                if (field) {
                    field.value = defaults[key];
                }
            });
        }
    }

    // Toggle password visibility
    togglePasswordVisibility(button) {
        const target = button.getAttribute('data-target');
        const input = document.getElementById(target);
        const icon = button.querySelector('i');

        if (input && icon) {
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }
    }

    // Handle form submissions
    handleFormSubmission(e) {
        const form = e.target;
        const submitButton = form.querySelector('button[type="submit"]');

        if (submitButton) {
            // Show loading state
            submitButton.classList.add('btn-loading');
            submitButton.disabled = true;

            // Re-enable button after 5 seconds (in case of error)
            setTimeout(() => {
                submitButton.classList.remove('btn-loading');
                submitButton.disabled = false;
            }, 5000);
        }
    }

    // Initialize password toggle functionality
    initializePasswordToggles() {
        const toggleButtons = document.querySelectorAll('.toggle-password');
        toggleButtons.forEach(button => {
            button.addEventListener('click', () => {
                this.togglePasswordVisibility(button);
            });
        });
    }

    // Initialize form validations
    initializeFormValidations() {
        // Customer form validation
        const customerForm = document.getElementById('customerForm');
        if (customerForm) {
            customerForm.addEventListener('submit', (e) => {
                this.validateCustomerForm(e);
            });
        }

        // Login form validation
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', (e) => {
                this.validateLoginForm(e);
            });
        }

        // Register form validation
        const registerForm = document.getElementById('registerForm');
        if (registerForm) {
            registerForm.addEventListener('submit', (e) => {
                this.validateRegisterForm(e);
            });
        }
    }

    // Validate customer form
    validateCustomerForm(e) {
        const form = e.target;
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            GreenHomeApp.showError('Please fill in all required fields');
        }
    }

    // Validate login form
    validateLoginForm(e) {
        const email = document.getElementById('email')?.value;
        const password = document.getElementById('password')?.value;

        if (!email || !password) {
            e.preventDefault();
            GreenHomeApp.showError('Please fill in all required fields');
        }
    }

    // Validate register form
    validateRegisterForm(e) {
        const name = document.getElementById('name')?.value;
        const email = document.getElementById('email')?.value;
        const role = document.getElementById('role')?.value;
        const password = document.getElementById('password')?.value;
        const passwordConfirm = document.getElementById('password_confirmation')?.value;
        const terms = document.getElementById('terms')?.checked;

        if (!name || !email || !role || !password || !passwordConfirm || !terms) {
            e.preventDefault();
            GreenHomeApp.showError('Please fill in all required fields and accept the terms');
            return;
        }

        if (password !== passwordConfirm) {
            e.preventDefault();
            GreenHomeApp.showError('Passwords do not match');
        }
    }

    // Initialize auto-refresh for dashboard
    initializeAutoRefresh() {
        // Auto-refresh dashboard every 60 seconds
        if (window.location.pathname === '/dashboard' || window.location.pathname === '/') {
            setTimeout(() => {
                window.location.reload();
            }, 60000);
        }

        // Add smooth scrolling to alerts
        const alertContainers = document.querySelectorAll('.alert-container');
        alertContainers.forEach(container => {
            if (container.scrollHeight > container.clientHeight) {
                container.style.scrollBehavior = 'smooth';
            }
        });
    }

    // Initialize page-specific features
    initializePageSpecificFeatures() {
        // Welcome page specific initialization
        if (document.querySelector('.hero-section')) {
            this.initializeWelcomePage();
        }

        // Customer show page specific initialization
        if (document.querySelector('.mark-done-btn')) {
            this.initializeCustomerShowPage();
        }

        // Customer index page specific initialization
        if (document.querySelector('#customersTableBody')) {
            this.initializeCustomerIndexPage();
        }

        // Dashboard specific initialization
        if (window.location.pathname === '/dashboard') {
            this.initializeDashboard();
        }
    }

    // Welcome page initialization
    initializeWelcomePage() {
        // Mobile menu close on click
        const navLinks = document.querySelectorAll('.nav-link');
        const navbarToggler = document.querySelector('.navbar-toggler');
        const navbarCollapse = document.querySelector('.navbar-collapse');

        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                    navbarToggler.click();
                }
            });
        });

        // Animate stats counter
        this.animateStatsCounter();

        // Add scroll animations
        this.initializeScrollAnimations();
    }

    // Animate stats counter
    animateStatsCounter() {
        const statNumbers = document.querySelectorAll('.stat-number');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumber = entry.target;
                    const target = parseInt(statNumber.getAttribute('data-count'));
                    this.animateValue(statNumber, 0, target, 2000);
                    observer.unobserve(statNumber);
                }
            });
        }, { threshold: 0.5 });

        statNumbers.forEach(stat => observer.observe(stat));
    }

    // Animate value counter
    animateValue(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const value = Math.floor(progress * (end - start) + start);
            element.textContent = value;
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // Initialize scroll animations
    initializeScrollAnimations() {
        const animatedElements = document.querySelectorAll('.fade-in-up');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const delay = entry.target.style.animationDelay || '0s';
                    entry.target.style.animationDelay = delay;
                    entry.target.classList.add('fade-in-up');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        animatedElements.forEach(element => observer.observe(element));
    }

    // Customer show page initialization
    initializeCustomerShowPage() {
        // Auto-focus on notes field when maintenance modal opens
        const maintenanceModal = document.getElementById('maintenanceModal');
        if (maintenanceModal) {
            maintenanceModal.addEventListener('shown.bs.modal', function () {
                const notesField = document.getElementById('notes');
                if (notesField) notesField.focus();
            });
        }

        // Auto-focus on service price when renew modal opens
        const renewModal = document.getElementById('renewModal');
        if (renewModal) {
            renewModal.addEventListener('shown.bs.modal', function () {
                const servicePriceField = document.getElementById('service_price');
                if (servicePriceField) servicePriceField.focus();
            });
        }

        // Handle "Mark as Done" button clicks
        const markDoneButtons = document.querySelectorAll('.mark-done-btn');
        markDoneButtons.forEach(button => {
            button.addEventListener('click', function() {
                const maintenanceDate = this.getAttribute('data-date');

                // Set the date in the maintenance form
                const maintenanceDateField = document.getElementById('maintenance_date');
                if (maintenanceDateField) {
                    maintenanceDateField.value = maintenanceDate;
                }

                // Show the maintenance modal
                const maintenanceModalElement = document.getElementById('maintenanceModal');
                if (maintenanceModalElement) {
                    const maintenanceModal = new bootstrap.Modal(maintenanceModalElement);
                    maintenanceModal.show();
                }
            });
        });

        // Handle form submission for maintenance
        const maintenanceForm = document.getElementById('maintenanceForm');
        if (maintenanceForm) {
            maintenanceForm.addEventListener('submit', function(e) {
                // You can add any validation here if needed
                console.log('Submitting maintenance form with date:', document.getElementById('maintenance_date').value);
            });
        }
    }

    // Customer index page initialization
    initializeCustomerIndexPage() {
        // Add active state to current sort
        const currentSort = document.querySelector('[data-current-sort]')?.dataset.currentSort;
        const currentOrder = document.querySelector('[data-current-order]')?.dataset.currentOrder;

        if (currentSort) {
            const sortLinks = document.querySelectorAll(`a[href*="sort=${currentSort}"]`);
            sortLinks.forEach(link => {
                const icon = link.querySelector('i');
                if (icon) {
                    icon.className = currentOrder === 'asc' ? 'fas fa-sort-up' : 'fas fa-sort-down';
                    link.classList.add('text-white');
                }
            });
        }
    }

    // Dashboard initialization
    initializeDashboard() {
        // Auto-refresh dashboard every 60 seconds
        setTimeout(function() {
            window.location.reload();
        }, 60000);

        // Add smooth scrolling to alerts
        const alertContainers = document.querySelectorAll('.alert-container');
        alertContainers.forEach(container => {
            if (container.scrollHeight > container.clientHeight) {
                container.style.scrollBehavior = 'smooth';
            }
        });
    }

    // Dashboard initialization
initializeDashboard() {
    // Auto-refresh dashboard every 60 seconds
    setInterval(() => {
        this.refreshDashboardStats();
    }, 60000);

    // Add smooth scrolling to alerts
    const alertContainers = document.querySelectorAll('.alert-container');
    alertContainers.forEach(container => {
        if (container.scrollHeight > container.clientHeight) {
            container.style.scrollBehavior = 'smooth';
        }
    });

    // Initialize real-time stats updates
    this.initializeRealTimeStats();
}

// Refresh dashboard stats via AJAX
refreshDashboardStats() {
    if (window.location.pathname === '/dashboard' || window.location.pathname === '/') {
        fetch('/dashboard/stats')
            .then(response => response.json())
            .then(data => {
                this.updateDashboardStats(data);
            })
            .catch(error => {
                console.log('Auto-refresh failed, will reload page');
                window.location.reload();
            });
    }
}

// Update stats on the page without full reload
updateDashboardStats(stats) {
    // Update total customers
    const totalEl = document.querySelector('[data-stat="total-customers"]');
    if (totalEl) totalEl.textContent = stats.totalCustomers;

    // Update active customers
    const activeEl = document.querySelector('[data-stat="active-customers"]');
    if (activeEl) activeEl.textContent = stats.activeCustomers;

    // Update expiring contracts
    const expiringEl = document.querySelector('[data-stat="expiring-contracts"]');
    if (expiringEl) expiringEl.textContent = stats.expiringContracts;

    // Update maintenance alerts count
    const maintenanceEl = document.querySelector('[data-stat="maintenance-alerts"]');
    if (maintenanceEl) maintenanceEl.textContent = stats.maintenanceAlertsCount;

    // Update last updated time
    const lastUpdatedEl = document.querySelector('[data-stat="last-updated"]');
    if (lastUpdatedEl) {
        lastUpdatedEl.textContent = `Last updated: ${new Date().toLocaleTimeString()}`;
    }

    // Visual feedback for update
    this.showStatsUpdateIndicator();
}

// Show visual feedback when stats update
showStatsUpdateIndicator() {
    const indicators = document.querySelectorAll('.auto-refresh-indicator');
    indicators.forEach(indicator => {
        indicator.classList.add('updating');
        setTimeout(() => {
            indicator.classList.remove('updating');
        }, 1000);
    });
}

// Initialize real-time stats
initializeRealTimeStats() {
    // Add data attributes to stat elements for easy updating
    const statElements = {
        'total-customers': document.querySelector('.bg-gradient-primary .h3'),
        'active-customers': document.querySelector('.bg-gradient-success .h3'),
        'expiring-contracts': document.querySelector('.bg-gradient-warning .h3'),
        'maintenance-alerts': document.querySelector('.bg-gradient-info .h3')
    };

    Object.keys(statElements).forEach(stat => {
        if (statElements[stat]) {
            statElements[stat].setAttribute('data-stat', stat);
        }
    });
}

    // Initialize form validation with options
    static initFormValidation(formId, options = {}) {
        const form = document.getElementById(formId);
        const submitButton = document.getElementById(options.submitButtonId);

        if (form && submitButton) {
            form.addEventListener('submit', function(e) {
                if (options.validateDates) {
                    const startDate = document.getElementById('contract_start_date')?.value;
                    const endDate = document.getElementById('contract_end_date')?.value;

                    if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                        e.preventDefault();
                        GreenHomeApp.showError('Contract end date must be after start date');
                        return;
                    }
                }

                // Show loading state
                submitButton.classList.add('btn-loading');
                submitButton.disabled = true;
            });
        }
    }
}

// Initialize the application when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.GreenHome = new GreenHomeApp();
});

// Make functions globally available
window.GreenHomeApp = GreenHomeApp;
