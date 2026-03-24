// index
(() => {
    if (!document.body.classList.contains('page-index')) return;

    window.addEventListener('load', function () {
                const loadingPage = document.getElementById('loading-page');
                const mainContent = document.querySelector('.main-content');
                setTimeout(() => {
                    loadingPage.classList.add('loaded');
                    mainContent.classList.add('show');
                    setTimeout(() => loadingPage.style.display = 'none', 700);
                }, 2000);

                AOS.init({
                    duration: 800,
                    once: true,
                    offset: 50,
                    easing: 'ease-out'
                });

                const navbar = document.querySelector('.navbar');
                const backBtn = document.getElementById('backToTop');

                window.addEventListener('scroll', function () {
                    if (window.scrollY > 100) {
                        navbar.classList.add('scrolled');
                        backBtn.classList.add('show');
                    } else {
                        navbar.classList.remove('scrolled');
                        backBtn.classList.remove('show');
                    }
                });

                backBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });

                // Gallery lightbox
                document.querySelectorAll('.gallery-item').forEach(item => {
                    item.addEventListener('click', function () {
                        const imgSrc = this.querySelector('img').src;
                        const title = this.querySelector('h5')?.innerText || 'Gallery Image';
                        const modalHTML = `
                            <div class="modal fade" id="imageModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content bg-transparent border-0">
                                        <div class="modal-header border-0">
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-0">
                                            <img src="${imgSrc}" class="img-fluid rounded-4 gallery-modal-image" alt="${title}">
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        document.body.insertAdjacentHTML('beforeend', modalHTML);
                        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
                        modal.show();
                        document.getElementById('imageModal').addEventListener('hidden.bs.modal', function () { this.remove(); });
                    });
                });
            });
})();

// about
(() => {
    if (!document.body.classList.contains('page-about')) return;

    // ===== LOADING PAGE FUNCTIONALITY =====
            window.addEventListener('load', function() {
                const loadingPage = document.getElementById('loading-page');
                const mainContent = document.querySelector('.main-content');
            
                setTimeout(function() {
                    loadingPage.classList.add('loaded');
                    mainContent.classList.add('show');
                
                    setTimeout(function() {
                        loadingPage.style.display = 'none';
                    }, 700);
                }, 2000);

                // Initialize AOS animations
                AOS.init({ 
                    duration: 800, 
                    once: true, 
                    offset: 50,
                    easing: 'ease-out'
                });

                // Navbar scroll effect
                const navbar = document.querySelector('.navbar');
                const backBtn = document.getElementById('backToTop');
            
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 100) {
                        navbar.classList.add('scrolled');
                        backBtn.classList.add('show');
                    } else {
                        navbar.classList.remove('scrolled');
                        backBtn.classList.remove('show');
                    }
                });

                backBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });

            // Commitment section observer
            const commitment = document.querySelector('.commitment');

            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        commitment.classList.add('show');
                    }
                });
            }, { threshold: 0.3 });

            observer.observe(commitment);
        
            // Animate child sections on scroll
            const children = document.querySelectorAll('.child2, .child3, .child4');

            const childObserver = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if(entry.isIntersecting){
                        entry.target.classList.add('show');
                    }
                });
            }, { threshold: 0.3 });

            children.forEach(child => {
                childObserver.observe(child);
            });
})();

// contactus
(() => {
    if (!document.body.classList.contains('page-contactus')) return;

    // ===== LOADING PAGE FUNCTIONALITY =====
            window.addEventListener('load', function() {
                const loadingPage = document.getElementById('loading-page');
                const mainContent = document.querySelector('.main-content');
            
                setTimeout(function() {
                    loadingPage.classList.add('loaded');
                    mainContent.classList.add('show');
                
                    setTimeout(function() {
                        loadingPage.style.display = 'none';
                    }, 700);
                }, 2000);

                // Initialize AOS
                AOS.init({
                    duration: 800,
                    once: true,
                    offset: 50,
                    easing: 'ease-out'
                });

                // Navbar scroll effect
                const navbar = document.querySelector('.navbar');
                const backBtn = document.getElementById('backToTop');
            
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 100) {
                        navbar.classList.add('scrolled');
                        backBtn.classList.add('show');
                    } else {
                        navbar.classList.remove('scrolled');
                        backBtn.classList.remove('show');
                    }
                });

                backBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });

            // ===== ANIMATION ON SCROLL =====
            document.addEventListener('DOMContentLoaded', function() {
                const elements = document.querySelectorAll('.animate-on-scroll');
            
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animated');
                        }
                    });
                }, {
                    threshold: 0.1
                });
            
                elements.forEach(element => {
                    observer.observe(element);
                });
            });
})();

// facilllities
(() => {
    if (!document.body.classList.contains('page-facilllities')) return;

    // ===== LOADING PAGE FUNCTIONALITY =====
            window.addEventListener('load', function() {
                const loadingPage = document.getElementById('loading-page');
                const mainContent = document.querySelector('.main-content');
            
                setTimeout(function() {
                    loadingPage.classList.add('loaded');
                    mainContent.classList.add('show');
                
                    setTimeout(function() {
                        loadingPage.style.display = 'none';
                    }, 700);
                }, 2000);

                // Initialize AOS
                AOS.init({
                    duration: 800,
                    once: true,
                    offset: 50,
                    easing: 'ease-out'
                });

                // Navbar scroll effect
                const navbar = document.querySelector('.navbar');
                const backBtn = document.getElementById('backToTop');
            
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 100) {
                        navbar.classList.add('scrolled');
                        backBtn.classList.add('show');
                    } else {
                        navbar.classList.remove('scrolled');
                        backBtn.classList.remove('show');
                    }
                });

                backBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });
})();

// feedback
(() => {
    if (!document.body.classList.contains('page-feedback')) return;

    // ===== LOADING PAGE FUNCTIONALITY =====
            window.addEventListener('load', function() {
                const loadingPage = document.getElementById('loading-page');
                const mainContent = document.querySelector('.main-content');
            
                setTimeout(function() {
                    loadingPage.classList.add('loaded');
                    mainContent.classList.add('show');
                
                    setTimeout(function() {
                        loadingPage.style.display = 'none';
                    }, 700);
                }, 2000);

                // Initialize AOS animations
                AOS.init({ 
                    duration: 800, 
                    once: true, 
                    offset: 20,
                    easing: 'ease-out'
                });

                // Navbar scroll effect
                const navbar = document.querySelector('.navbar');
                const backBtn = document.getElementById('backToTop');
            
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 100) {
                        navbar.classList.add('scrolled');
                        backBtn.classList.add('show');
                    } else {
                        navbar.classList.remove('scrolled');
                        backBtn.classList.remove('show');
                    }
                });

                backBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });

            // ===== EXISTING FORM VALIDATION CODE (KEPT EXACTLY THE SAME) =====
            document.addEventListener('DOMContentLoaded', function () {
                // Form Elements
                const feedbackForm = document.getElementById('feedbackForm');
                const userNameInput = document.getElementById('userName');
                const userEmailInput = document.getElementById('userEmail');
                const feedbackTypeSelect = document.getElementById('feedbackType');
                const userMessageInput = document.getElementById('userMessage');
                const submitBtn = document.getElementById('submitBtn');
                const successMessage = document.getElementById('successMessage');

                // Validation Elements
                const nameValidation = document.getElementById('nameValidation');
                const emailValidation = document.getElementById('emailValidation');
                const messageValidation = document.getElementById('messageValidation');
                const emojiValidation = document.getElementById('emojiValidation');
                const starValidation = document.getElementById('starValidation');

                // Rating Variables
                const emojiOptions = document.querySelectorAll('.emoji-option');
                const stars = document.querySelectorAll('.star');
                const ratingValue = document.getElementById('ratingValue');
                let selectedEmojiRating = 0;
                let selectedStarRating = 0;

                // Validation Functions
                function validateName(name) {
                    const nameRegex = /^[A-Za-z\s]{5,}$/;
                    return nameRegex.test(name);
                }

                function validateEmail(email) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return emailRegex.test(email);
                }

                function validateMessage(message) {
                    return message.length >= 10;
                }

                // Name Validation
                let nameValidationShown = false;

                userNameInput.addEventListener('focus', function () {
                    if (!nameValidationShown) {
                        nameValidation.textContent = 'Please enter only alphabets (minimum 5 characters)';
                        nameValidation.classList.add('error');
                        nameValidation.style.display = 'block';
                        nameValidationShown = true;
                    }
                });

                userNameInput.addEventListener('input', function () {
                    const name = this.value.trim();

                    if (name === '') {
                        this.classList.remove('valid', 'invalid');
                        nameValidation.textContent = 'Please enter only alphabets (minimum 5 characters)';
                        nameValidation.classList.add('error');
                        nameValidation.style.display = 'block';
                        return;
                    }

                    if (validateName(name)) {
                        this.classList.remove('invalid');
                        this.classList.add('valid');
                        nameValidation.style.display = 'none';
                        nameValidation.classList.remove('error', 'success');
                    } else {
                        this.classList.remove('valid');
                        this.classList.add('invalid');
                        nameValidation.textContent = 'Please enter only alphabets (minimum 5 characters)';
                        nameValidation.classList.remove('success');
                        nameValidation.classList.add('error');
                        nameValidation.style.display = 'block';
                    }
                });

                // Email Validation
                let emailValidationShown = false;

                userEmailInput.addEventListener('focus', function () {
                    if (!emailValidationShown) {
                        emailValidation.textContent = 'Please enter a valid email address';
                        emailValidation.classList.add('error');
                        emailValidation.style.display = 'block';
                        emailValidationShown = true;
                    }
                });

                userEmailInput.addEventListener('input', function () {
                    const email = this.value.trim();

                    if (email === '') {
                        this.classList.remove('valid', 'invalid');
                        emailValidation.textContent = 'Please enter a valid email address';
                        emailValidation.classList.add('error');
                        emailValidation.style.display = 'block';
                        return;
                    }

                    if (validateEmail(email)) {
                        this.classList.remove('invalid');
                        this.classList.add('valid');
                        emailValidation.style.display = 'none';
                        emailValidation.classList.remove('error', 'success');
                    } else {
                        this.classList.remove('valid');
                        this.classList.add('invalid');
                        emailValidation.textContent = 'Please enter a valid email address';
                        emailValidation.classList.remove('success');
                        emailValidation.classList.add('error');
                        emailValidation.style.display = 'block';
                    }
                });

                // Message Validation
                let messageValidationShown = false;

                userMessageInput.addEventListener('focus', function () {
                    if (!messageValidationShown) {
                        messageValidation.textContent = 'Please enter your feedback (minimum 10 characters)';
                        messageValidation.classList.add('error');
                        messageValidation.style.display = 'block';
                        messageValidationShown = true;
                    }
                });

                userMessageInput.addEventListener('input', function () {
                    const message = this.value.trim();

                    if (message === '') {
                        this.classList.remove('valid', 'invalid');
                        messageValidation.textContent = 'Please enter your feedback (minimum 10 characters)';
                        messageValidation.classList.add('error');
                        messageValidation.style.display = 'block';
                        return;
                    }

                    if (validateMessage(message)) {
                        this.classList.remove('invalid');
                        this.classList.add('valid');
                        messageValidation.style.display = 'none';
                        messageValidation.classList.remove('error', 'success');
                    } else {
                        this.classList.remove('valid');
                        this.classList.add('invalid');
                        messageValidation.textContent = 'Please enter your feedback (minimum 10 characters)';
                        messageValidation.classList.remove('success');
                        messageValidation.classList.add('error');
                        messageValidation.style.display = 'block';
                    }
                });

                // Emoji Rating Selection
                emojiOptions.forEach(option => {
                    option.addEventListener('click', function () {
                        emojiOptions.forEach(opt => opt.classList.remove('selected'));
                        this.classList.add('selected');
                        selectedEmojiRating = parseInt(this.dataset.rating);
                        emojiValidation.classList.remove('error');
                        console.log('Emoji Rating Selected:', selectedEmojiRating);
                    });
                });

                // Star Rating Selection
                stars.forEach(star => {
                    star.addEventListener('mouseover', function () {
                        const rating = parseInt(this.dataset.rating);
                        highlightStars(rating);
                    });

                    star.addEventListener('mouseout', function () {
                        highlightStars(selectedStarRating);
                    });

                    star.addEventListener('click', function () {
                        selectedStarRating = parseInt(this.dataset.rating);
                        highlightStars(selectedStarRating);
                        ratingValue.textContent = `${selectedStarRating}/5`;
                        starValidation.classList.remove('error');
                        console.log('Star Rating Selected:', selectedStarRating);
                    });
                });

                function highlightStars(rating) {
                    stars.forEach(star => {
                        const starRating = parseInt(star.dataset.rating);
                        star.classList.remove('selected', 'hovered');

                        if (starRating <= rating) {
                            star.classList.add('hovered');
                        }

                        if (starRating <= selectedStarRating) {
                            star.classList.add('selected');
                            star.classList.remove('hovered');
                        }
                    });
                }

                // Form Submission
                feedbackForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Reset all validation messages
                    nameValidation.classList.remove('error', 'success');
                    emailValidation.classList.remove('error', 'success');
                    messageValidation.classList.remove('error', 'success');
                    emojiValidation.classList.remove('error');
                    starValidation.classList.remove('error');

                    // Get form values
                    const name = userNameInput.value.trim();
                    const email = userEmailInput.value.trim();
                    const feedbackType = feedbackTypeSelect.value;
                    const message = userMessageInput.value.trim();

                    let isValid = true;

                    // Validate Name
                    if (!validateName(name)) {
                        userNameInput.classList.add('invalid');
                        nameValidation.textContent = 'Please enter only alphabets (minimum 5 characters)';
                        nameValidation.classList.add('error');
                        isValid = false;
                    }

                    // Validate Email
                    if (!validateEmail(email)) {
                        userEmailInput.classList.add('invalid');
                        emailValidation.textContent = 'Please enter a valid email address';
                        emailValidation.classList.add('error');
                        isValid = false;
                    }

                    // Validate Feedback Type
                    if (!feedbackType) {
                        feedbackTypeSelect.classList.add('invalid');
                        isValid = false;
                    }

                    // Validate Message
                    if (!validateMessage(message)) {
                        userMessageInput.classList.add('invalid');
                        messageValidation.textContent = 'Please enter your feedback (minimum 10 characters)';
                        messageValidation.classList.add('error');
                        isValid = false;
                    }

                    // Validate Emoji Rating
                    if (selectedEmojiRating === 0) {
                        emojiValidation.textContent = 'Please select your satisfaction level';
                        emojiValidation.classList.add('error');
                        isValid = false;
                    }

                    // Validate Star Rating
                    if (selectedStarRating === 0) {
                        starValidation.textContent = 'Please provide an overall rating';
                        starValidation.classList.add('error');
                        isValid = false;
                    }

                    // If validation fails, stop submission
                    if (!isValid) {
                        const firstError = document.querySelector('.validation-message.error');
                        if (firstError) {
                            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                        return;
                    }

                    // Prepare feedback data
                    const feedbackData = {
                        name: name,
                        email: email,
                        feedbackType: feedbackType,
                        emojiRating: selectedEmojiRating,
                        starRating: selectedStarRating,
                        message: message,
                        timestamp: new Date().toISOString()
                    };

                    console.log('Feedback Submitted:', feedbackData);

                    // Disable submit button and show loading state
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Submitting...';

                    // Simulate API call
                    setTimeout(() => {
                        // Show success message
                        successMessage.classList.add('show');

                        // Reset form
                        feedbackForm.reset();

                        // Reset all input styles
                        userNameInput.classList.remove('valid', 'invalid');
                        userEmailInput.classList.remove('valid', 'invalid');
                        feedbackTypeSelect.classList.remove('invalid');
                        userMessageInput.classList.remove('valid', 'invalid');

                        // Reset ratings
                        emojiOptions.forEach(opt => opt.classList.remove('selected'));
                        stars.forEach(star => star.classList.remove('selected', 'hovered'));
                        ratingValue.textContent = '0/5';
                        selectedEmojiRating = 0;
                        selectedStarRating = 0;

                        // Reset dropdown
                        feedbackTypeSelect.selectedIndex = 0;

                        // Reset validation messages
                        nameValidation.classList.remove('error', 'success');
                        emailValidation.classList.remove('error', 'success');
                        messageValidation.classList.remove('error', 'success');
                        emojiValidation.classList.remove('error');
                        starValidation.classList.remove('error');

                        // Re-enable submit button
                        setTimeout(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="bi bi-send me-2"></i> Submit Feedback';

                            // Hide success message after 5 seconds
                            setTimeout(() => {
                                successMessage.classList.remove('show');
                            }, 5000);
                        }, 1000);

                        // Scroll to success message
                        successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });

                    }, 1500);
                });

                // Smooth scrolling for navigation links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function (e) {
                        const href = this.getAttribute('href');
                        if (href === '#' || href.startsWith('#contact')) {
                            e.preventDefault();
                            const target = document.querySelector(href);
                            if (target) {
                                window.scrollTo({
                                    top: target.offsetTop - 80,
                                    behavior: 'smooth'
                                });
                            }
                        }
                    });
                });
            });
})();

// gallery
(() => {
    if (!document.body.classList.contains('page-gallery')) return;

    window.addEventListener('load', function() {
                const loadingPage = document.getElementById('loading-page');
                const mainContent = document.querySelector('.main-content');
            
                setTimeout(function() {
                    loadingPage.classList.add('loaded');
                    mainContent.classList.add('show');
                
                    setTimeout(function() {
                        loadingPage.style.display = 'none';
                    }, 700);
                }, 2000);

                AOS.init({ 
                    duration: 800, 
                    once: true, 
                    offset: 20,
                    easing: 'ease-out'
                });

                const navbar = document.querySelector('.navbar');
                const backBtn = document.getElementById('backToTop');
            
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 100) {
                        navbar.classList.add('scrolled');
                        backBtn.classList.add('show');
                    } else {
                        navbar.classList.remove('scrolled');
                        backBtn.classList.remove('show');
                    }
                });

                backBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });

                const currentPage = window.location.pathname.split('/').pop() || './';
            
                document.querySelectorAll('.nav-link').forEach(link => {
                    const linkPage = link.getAttribute('href');
                    if (linkPage === currentPage || 
                        (currentPage === '' && linkPage === './') ||
                        (currentPage === './' && linkPage === './')) {
                        link.classList.add('active');
                    }
                });

                function animateOnScroll() {
                    const elements = document.querySelectorAll('.animate-on-scroll');
                    elements.forEach(element => {
                        const elementTop = element.getBoundingClientRect().top;
                        const elementVisible = 150;
                        if (elementTop < window.innerHeight - elementVisible) {
                            element.classList.add('animated');
                        }
                    });
                }
            
                window.addEventListener('scroll', animateOnScroll);
                window.addEventListener('load', animateOnScroll);

                // Gallery lightbox
                document.querySelectorAll('.gallery-item').forEach(item => {
                    item.addEventListener('click', function() {
                        const imgSrc = this.querySelector('img').src;
                        const imgAlt = this.querySelector('h5')?.innerText || 'Gallery Image';
                        const modalHTML = `
                            <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content bg-transparent border-0">
                                        <div class="modal-header border-0">
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center p-0">
                                            <img src="${imgSrc}" alt="${imgAlt}" class="img-fluid rounded-4 shadow-lg style-gallery-004">
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        document.body.insertAdjacentHTML('beforeend', modalHTML);
                        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
                        modal.show();
                        document.getElementById('imageModal').addEventListener('hidden.bs.modal', function(){ this.remove(); });
                    });
                });
            });
})();

// auth pages
(() => {
    if (!document.body.classList.contains('page-login') && !document.body.classList.contains('page-register')) return;

    const pw = document.getElementById('password');
    const btn = document.getElementById('togglePw');

    if (!pw || !btn) return;

    btn.addEventListener('click', () => {
        const hidden = pw.type === 'password';
        pw.type = hidden ? 'text' : 'password';
        btn.textContent = hidden ? 'Hide' : 'Show';
    });
})();


// membership
(() => {
    if (!document.body.classList.contains('page-membership')) return;

    // ===== LOADING PAGE FUNCTIONALITY =====
            window.addEventListener('load', function() {
                const loadingPage = document.getElementById('loading-page');
                const mainContent = document.querySelector('.main-content');
            
                setTimeout(function() {
                    loadingPage.classList.add('loaded');
                    mainContent.classList.add('show');
                
                    setTimeout(function() {
                        loadingPage.style.display = 'none';
                    }, 700);
                }, 2000);

                // Initialize AOS animations
                AOS.init({ 
                    duration: 800, 
                    once: true, 
                    offset: 20,
                    easing: 'ease-out'
                });

                // Navbar scroll effect
                const navbar = document.querySelector('.navbar');
                const backBtn = document.getElementById('backToTop');
            
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 100) {
                        navbar.classList.add('scrolled');
                        backBtn.classList.add('show');
                    } else {
                        navbar.classList.remove('scrolled');
                        backBtn.classList.remove('show');
                    }
                });

                backBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });

            // ===== EXISTING JAVASCRIPT (KEPT EXACTLY THE SAME) =====
            // Global variable to store selected membership type
            let selectedMembershipCard = null;
            let selectedMembershipType = '';
        
            // Select Membership Type
            function selectMembershipType(type, element) {
                // Remove selected class from all cards
                document.querySelectorAll('.membership-type-card').forEach(card => {
                    card.classList.remove('selected');
                });
            
                // Add selected class to clicked card
                element.classList.add('selected');
                selectedMembershipCard = element;
                selectedMembershipType = type;
            
                // Set the hidden input value
                document.getElementById('membershipType').value = type;
            
                // Hide error message
                document.getElementById('membershipTypeError').classList.add('d-none');
            }

            // Show Alert
            function showAlert() {
                const alert = document.getElementById('successAlert');
                alert.classList.remove('d-none');
                alert.classList.add('show');
            
                // Auto-hide after 3 seconds
                setTimeout(() => {
                    hideAlert();
                }, 3000);
            }

            // Hide Alert
            function hideAlert() {
                const alert = document.getElementById('successAlert');
                alert.classList.remove('show');
                setTimeout(() => {
                    alert.classList.add('d-none');
                }, 300);
            }

            // Show Confirmation Section - FIXED
            function showConfirmationSection(formData) {
                // Hide original form
                document.getElementById('membershipFormSection').classList.add('d-none');
            
                // Update confirmation details
                document.getElementById('confirmName').textContent = formData.fullName;
                document.getElementById('confirmMembership').textContent = getMembershipTypeName(formData.membershipType);
                document.getElementById('confirmAmount').textContent = getMembershipPrice(formData.membershipType);
                document.getElementById('confirmDate').textContent = new Date().toLocaleDateString();
                document.getElementById('appId').textContent = 'NNGK-' + new Date().getFullYear() + '-' + Math.floor(Math.random() * 1000);
            
                // Show confirmation section immediately
                document.getElementById('confirmationSection').classList.remove('d-none');
            
                // Show alert after confirmation is visible
                setTimeout(() => {
                    showAlert();
                }, 100);
            
                // Scroll to top to show confirmation
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            // Get Membership Type Name
            function getMembershipTypeName(type) {
                const types = {
                    'annual': 'Annual Membership',
                    'half-yearly': 'Half-Yearly Membership',
                    'quarterly': 'Quarterly Membership',
                    'monthly': 'Monthly Membership'
                };
                return types[type] || 'Not Selected';
            }

            // Get Membership Price
            function getMembershipPrice(type) {
                const prices = {
                    'annual': 'Rs. 25,000',
                    'half-yearly': 'Rs. 15,000',
                    'quarterly': 'Rs. 9,000',
                    'monthly': 'Rs. 3,500'
                };
                return prices[type] || 'N/A';
            }

            // Submit Another Application
            function submitAnotherApplication() {
                // Hide confirmation section
                document.getElementById('confirmationSection').classList.add('d-none');
            
                // Hide alert
                hideAlert();
            
                // Show original form
                document.getElementById('membershipFormSection').classList.remove('d-none');
            
                // Reset form
                document.getElementById('membershipForm').reset();
                if (selectedMembershipCard) {
                    selectedMembershipCard.classList.remove('selected');
                }
                selectedMembershipType = '';
                document.getElementById('membershipType').value = '';
            }

            // Download Application (placeholder)
            function downloadApplication() {
                alert('Application download feature would be implemented here. For now, please save your application ID: ' + document.getElementById('appId').textContent);
            }

            // Go to Home
            function goToHome() {
                window.location.href = './';
            }

            // Form Validation and Submission
            document.getElementById('membershipForm').addEventListener('submit', function(event) {
                event.preventDefault();
            
                // Reset error messages
                document.getElementById('membershipTypeError').classList.add('d-none');
                document.getElementById('termsError').classList.add('d-none');
            
                let isValid = true;
            
                // Check if membership type is selected
                if (!selectedMembershipType) {
                    document.getElementById('membershipTypeError').classList.remove('d-none');
                    isValid = false;
                }
            
                // Check if terms are agreed
                if (!document.getElementById('agreeTerms').checked) {
                    document.getElementById('termsError').classList.remove('d-none');
                    isValid = false;
                }
            
                // Basic form validation
                const requiredFields = this.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
            
                if (!isValid) {
                    return;
                }
            
                // Collect form data
                const formData = {
                    fullName: document.getElementById('fullName').value,
                    fatherName: document.getElementById('fatherName').value,
                    email: document.getElementById('email').value,
                    phone: document.getElementById('phone').value,
                    cnic: document.getElementById('cnic').value,
                    dob: document.getElementById('dob').value,
                    gender: document.getElementById('gender').value,
                    address: document.getElementById('address').value,
                    membershipType: selectedMembershipType,
                    emergencyName: document.getElementById('emergencyName').value,
                    emergencyPhone: document.getElementById('emergencyPhone').value
                };
            
                console.log('Form Submitted:', formData);
            
                // Show confirmation section
                showConfirmationSection(formData);
            });

            // CNIC formatting
            document.getElementById('cnic').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 13) value = value.substring(0, 13);
            
                if (value.length <= 5) {
                    e.target.value = value;
                } else if (value.length <= 12) {
                    e.target.value = value.substring(0, 5) + '-' + value.substring(5);
                } else {
                    e.target.value = value.substring(0, 5) + '-' + value.substring(5, 12) + '-' + value.substring(12);
                }
            });

            // Phone number formatting
            document.getElementById('phone').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.substring(0, 11);
            
                if (value.length <= 4) {
                    e.target.value = value;
                } else if (value.length <= 7) {
                    e.target.value = value.substring(0, 4) + '-' + value.substring(4);
                } else {
                    e.target.value = value.substring(0, 4) + '-' + value.substring(4, 7) + '-' + value.substring(7);
                }
            });

            // Set max date for date of birth (minimum 16 years old)
            const today = new Date();
            const minDate = new Date(today.getFullYear() - 80, today.getMonth(), today.getDate());
            const maxDate = new Date(today.getFullYear() - 16, today.getMonth(), today.getDate());
            document.getElementById('dob').min = minDate.toISOString().split('T')[0];
            document.getElementById('dob').max = maxDate.toISOString().split('T')[0];
})();
