// Main JavaScript for Superior Dairy website

document.addEventListener('DOMContentLoaded', function() {
    // Initialize mobile menu
    initializeMobileMenu();
    
    // Initialize login form validation
    initializeLoginForm();
    
    // Initialize smooth scroll for anchor links
    initializeSmoothScroll();
    
    // Initialize sliders if they exist
    initializeSliders();
    
    // Newsletter form submission
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get email input
            const emailInput = this.querySelector('input[type="email"]');
            const email = emailInput.value;
            
            // Validate email (basic validation)
            if (email.trim() !== '') {
                // In a real application, this would send the data to a server
                alert('Thank you for subscribing to our newsletter!');
                
                // Reset the form
                emailInput.value = '';
            }
        });
    }
    
    // Animation on scroll
    const animatedElements = document.querySelectorAll('.product-card, .about-content, .map-content, .sustainability-content');
    
    if (animatedElements.length > 0) {
        // Check if element is in viewport
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.8 &&
                rect.bottom >= 0
            );
        }
        
        // Add animations to elements when they come into view
        function animateOnScroll() {
            animatedElements.forEach(element => {
                if (isInViewport(element) && !element.classList.contains('animated')) {
                    element.classList.add('animated');
                }
            });
        }
        
        // Run on scroll
        window.addEventListener('scroll', animateOnScroll);
        
        // Run once on page load
        animateOnScroll();
    }
    
    // Product filtering (if applicable)
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productItems = document.querySelectorAll('.product-item');
    
    if (filterButtons.length > 0 && productItems.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Get filter value
                const filter = this.getAttribute('data-filter');
                
                // Show/hide products based on filter
                productItems.forEach(item => {
                    if (filter === 'all') {
                        item.style.display = 'block';
                    } else if (item.classList.contains(filter)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }
    
    // Accordion for FAQs (if applicable)
    const accordionButtons = document.querySelectorAll('.accordion-button');
    
    if (accordionButtons.length > 0) {
        accordionButtons.forEach(button => {
            button.addEventListener('click', function() {
                this.classList.toggle('active');
                
                const content = this.nextElementSibling;
                if (content.style.maxHeight) {
                    content.style.maxHeight = null;
                } else {
                    content.style.maxHeight = content.scrollHeight + 'px';
                }
            });
        });
    }
});

/**
 * Initialize login form validation and submission
 */
function initializeLoginForm() {
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const region = document.getElementById('region').value;
            const loginMessage = document.getElementById('loginMessage');
            
            // Simple validation (in a real app, this would be server-side)
            if (username === '') {
                showLoginError('Please enter your username');
                return;
            }
            
            if (password === '') {
                showLoginError('Please enter your password');
                return;
            }
            
            // Show loading message
            loginMessage.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';
            loginMessage.className = 'login-message info';
            
            // In a real app, this would be an API call to Laravel backend
            // This is a simulation for demonstration purposes
            
            // Simulate API request with fetch
            setTimeout(function() {
                // For demo purposes, any credentials are accepted
                const authToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImFkbWluIiwicm9sZSI6Im1hbmFnZXIiLCJyZWdpb24iOiJhbGwiLCJleHAiOjE3MTg1Njc2ODF9.ZV8uH2lq6Z2Z3x7JQgRzBJl2_BhKQUL4KTYtqQzyGc0';
                
                // Store the auth token and selected region in localStorage
                localStorage.setItem('authToken', authToken);
                localStorage.setItem('selectedRegion', region);
                
                // Redirect to dashboard with region parameter
                window.location.href = `dashboard.html?region=${region}`;
            }, 1000);
            
            // In production, the code would be:
            /*
            fetch('http://localhost:8000/api/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    username: username,
                    password: password
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Login failed');
                }
                return response.json();
            })
            .then(data => {
                if (data.token) {
                    // Store auth token
                    localStorage.setItem('authToken', data.token);
                    localStorage.setItem('selectedRegion', region);
                    
                    // Redirect to dashboard
                    window.location.href = `dashboard.html?region=${region}`;
                } else {
                    showLoginError('Authentication failed');
                }
            })
            .catch(error => {
                console.error('Login error:', error);
                showLoginError('Login failed. Please check your credentials.');
            });
            */
        });
    }
}

/**
 * Show login error message
 */
function showLoginError(message) {
    const loginMessage = document.getElementById('loginMessage');
    if (loginMessage) {
        loginMessage.textContent = message;
        loginMessage.className = 'login-message error';
    }
}

/**
 * Initialize mobile menu toggle
 */
function initializeMobileMenu() {
    const menuToggle = document.querySelector('.menu-toggle');
    const mainNav = document.querySelector('.main-nav');
    
    if (menuToggle && mainNav) {
        menuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });
    }
}

/**
 * Initialize smooth scrolling for anchor links
 */
function initializeSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            // Skip links with href="#" and href="#" + anything
            if (this.getAttribute('href') === '#' || 
                this.getAttribute('href') === '#help' || 
                this.getAttribute('href') === '#contact') {
                return;
            }
            
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });
}

/**
 * Initialize sliders/slideshows
 */
function initializeSliders() {
    // Example slider initialization
    // In a real app, this would initialize any carousel or slideshow components
}

// Function to initialize slideshows
function initSlideshow() {
    const slideshows = document.querySelectorAll('.slideshow');
    
    if (slideshows.length > 0) {
        slideshows.forEach(slideshow => {
            const slides = slideshow.querySelectorAll('.slide');
            const prevBtn = slideshow.querySelector('.prev-btn');
            const nextBtn = slideshow.querySelector('.next-btn');
            
            let currentSlide = 0;
            
            // Show the first slide
            if (slides.length > 0) {
                slides[0].classList.add('active');
            }
            
            // Function to change slide
            function changeSlide(n) {
                // Hide current slide
                slides[currentSlide].classList.remove('active');
                
                // Calculate next slide index
                currentSlide = (currentSlide + n + slides.length) % slides.length;
                
                // Show new slide
                slides[currentSlide].classList.add('active');
            }
            
            // Set up event listeners for controls
            if (prevBtn) {
                prevBtn.addEventListener('click', () => changeSlide(-1));
            }
            
            if (nextBtn) {
                nextBtn.addEventListener('click', () => changeSlide(1));
            }
            
            // Auto-rotate slides every 5 seconds
            setInterval(() => changeSlide(1), 5000);
        });
    }
} 