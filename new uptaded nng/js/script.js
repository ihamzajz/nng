// INDEX
 
        window.addEventListener('load', function() {
            const loadingPage = document.getElementById('loading-page');
            const mainContent = document.querySelector('.main-content');
            
            setTimeout(function() {
                loadingPage.classList.add('loaded');
                mainContent.classList.add('show');
                setTimeout(function() {
                    loadingPage.style.display = 'none';
                }, 800);
            }, 1800);

            AOS.init({ duration: 700, once: true, offset: 40, easing: 'ease-out' });

            const navbar = document.querySelector('.navbar');
            const backBtn = document.getElementById('backToTop');
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 80) {
                    navbar?.classList.add('scrolled');
                    backBtn?.classList.add('show');
                } else {
                    navbar?.classList.remove('scrolled');
                    backBtn?.classList.remove('show');
                }
            });

            backBtn?.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // Gallery lightbox
            document.querySelectorAll('.gallery-item').forEach(item => {
                item.addEventListener('click', function() {
                    const imgSrc = this.querySelector('img').src;
                    const modalHTML = `
                        <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content bg-transparent border-0">
                                    <div class="modal-header border-0 pb-0">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center p-0">
                                        <img src="${imgSrc}" class="img-fluid rounded-4 shadow-lg" style="border: 2px solid var(--accent-gold);">
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    document.body.insertAdjacentHTML('beforeend', modalHTML);
                    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
                    modal.show();
                    document.getElementById('imageModal').addEventListener('hidden.bs.modal', function() { this.remove(); });
                });
            });
        });


        // ABOUT
          // Loading animation & AOS initialization
    window.addEventListener('load', function() {
        const loader = document.getElementById('loading-page');
        const main = document.querySelector('.main-content');
        
        setTimeout(() => {
            if(loader) loader.classList.add('loaded');
            if(main) main.classList.add('show');
            setTimeout(() => { if(loader) loader.style.display = 'none'; }, 800);
        }, 1800);

        AOS.init({ duration: 700, once: true, offset: 40, easing: 'ease-out' });

        // Navbar scroll effect + back to top
        const navbar = document.querySelector('.navbar');
        const backBtn = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if(window.scrollY > 80) {
                navbar?.classList.add('scrolled');
                backBtn?.classList.add('show');
            } else {
                navbar?.classList.remove('scrolled');
                backBtn?.classList.remove('show');
            }
        });

        if(backBtn) {
            backBtn.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        // subtle hover effect on member list items
        const memberItems = document.querySelectorAll('.members-list li');
        memberItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                item.style.cursor = 'default';
            });
        });
    });

    // additional page load security for any residual styles
    document.addEventListener('DOMContentLoaded', () => {
        document.body.style.background = '#F8F6F2';
    });




    // FACILLITES
     window.addEventListener('load', function() {
            const loadingPage = document.getElementById('loading-page');
            const mainContent = document.querySelector('.main-content');
            
            setTimeout(function() {
                loadingPage.classList.add('loaded');
                mainContent.classList.add('show');
                setTimeout(function() {
                    loadingPage.style.display = 'none';
                }, 800);
            }, 1800);

            AOS.init({ duration: 700, once: true, offset: 40, easing: 'ease-out' });

            const navbar = document.querySelector('.navbar');
            const backBtn = document.getElementById('backToTop');
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 80) {
                    navbar?.classList.add('scrolled');
                    backBtn?.classList.add('show');
                } else {
                    navbar?.classList.remove('scrolled');
                    backBtn?.classList.remove('show');
                }
            });

            backBtn?.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        // FEEDBACK
          window.addEventListener('load', function() {
            const loadingPage = document.getElementById('loading-page');
            const mainContent = document.querySelector('.main-content');
            
            setTimeout(function() {
                loadingPage.classList.add('loaded');
                mainContent.classList.add('show');
                setTimeout(function() {
                    loadingPage.style.display = 'none';
                }, 800);
            }, 1800);

            AOS.init({ duration: 700, once: true, offset: 40, easing: 'ease-out' });

            const navbar = document.querySelector('.navbar');
            const backBtn = document.getElementById('backToTop');
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 80) {
                    navbar?.classList.add('scrolled');
                    backBtn?.classList.add('show');
                } else {
                    navbar?.classList.remove('scrolled');
                    backBtn?.classList.remove('show');
                }
            });

            backBtn?.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        // Feedback Form Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('feedbackForm');
            const nameInput = document.getElementById('userName');
            const emailInput = document.getElementById('userEmail');
            const typeSelect = document.getElementById('feedbackType');
            const messageInput = document.getElementById('userMessage');
            const submitBtn = document.getElementById('submitBtn');
            const successMsg = document.getElementById('successMessage');
            
            const nameError = document.getElementById('nameError');
            const emailError = document.getElementById('emailError');
            const typeError = document.getElementById('typeError');
            const messageError = document.getElementById('messageError');
            const emojiError = document.getElementById('emojiError');
            const starError = document.getElementById('starError');
            
            const emojiItems = document.querySelectorAll('.emoji-item');
            const stars = document.querySelectorAll('.star');
            const ratingValue = document.getElementById('ratingValue');
            
            let selectedEmoji = 0;
            let selectedStar = 0;

            function validateName(name) {
                return /^[A-Za-z\s]{5,}$/.test(name);
            }

            function validateEmail(email) {
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            }

            function validateMessage(msg) {
                return msg.length >= 10;
            }

            nameInput.addEventListener('input', function() {
                if (this.value.trim() && !validateName(this.value.trim())) {
                    this.classList.add('invalid');
                    nameError.classList.add('show');
                } else {
                    this.classList.remove('invalid');
                    nameError.classList.remove('show');
                }
            });

            emailInput.addEventListener('input', function() {
                if (this.value.trim() && !validateEmail(this.value.trim())) {
                    this.classList.add('invalid');
                    emailError.classList.add('show');
                } else {
                    this.classList.remove('invalid');
                    emailError.classList.remove('show');
                }
            });

            messageInput.addEventListener('input', function() {
                if (this.value.trim() && !validateMessage(this.value.trim())) {
                    this.classList.add('invalid');
                    messageError.classList.add('show');
                } else {
                    this.classList.remove('invalid');
                    messageError.classList.remove('show');
                }
            });

            emojiItems.forEach(item => {
                item.addEventListener('click', function() {
                    emojiItems.forEach(i => i.classList.remove('selected'));
                    this.classList.add('selected');
                    selectedEmoji = parseInt(this.dataset.rating);
                    emojiError.classList.remove('show');
                });
            });

            stars.forEach(star => {
                star.addEventListener('mouseover', function() {
                    const rating = parseInt(this.dataset.rating);
                    stars.forEach(s => {
                        if (parseInt(s.dataset.rating) <= rating) {
                            s.style.color = '#C5A028';
                        } else {
                            s.style.color = '#ddd';
                        }
                    });
                });

                star.addEventListener('mouseout', function() {
                    stars.forEach(s => {
                        if (parseInt(s.dataset.rating) <= selectedStar) {
                            s.style.color = '#C5A028';
                        } else {
                            s.style.color = '#ddd';
                        }
                    });
                });

                star.addEventListener('click', function() {
                    selectedStar = parseInt(this.dataset.rating);
                    stars.forEach(s => {
                        if (parseInt(s.dataset.rating) <= selectedStar) {
                            s.classList.add('selected');
                            s.style.color = '#C5A028';
                        } else {
                            s.classList.remove('selected');
                            s.style.color = '#ddd';
                        }
                    });
                    ratingValue.textContent = selectedStar + '/5';
                    starError.classList.remove('show');
                });
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                document.querySelectorAll('.error-message').forEach(e => e.classList.remove('show'));
                let isValid = true;

                const name = nameInput.value.trim();
                const email = emailInput.value.trim();
                const type = typeSelect.value;
                const message = messageInput.value.trim();

                if (!validateName(name)) {
                    nameInput.classList.add('invalid');
                    nameError.classList.add('show');
                    isValid = false;
                }

                if (!validateEmail(email)) {
                    emailInput.classList.add('invalid');
                    emailError.classList.add('show');
                    isValid = false;
                }

                if (!type) {
                    typeSelect.classList.add('invalid');
                    typeError.classList.add('show');
                    isValid = false;
                }

                if (!validateMessage(message)) {
                    messageInput.classList.add('invalid');
                    messageError.classList.add('show');
                    isValid = false;
                }

                if (selectedEmoji === 0) {
                    emojiError.classList.add('show');
                    isValid = false;
                }

                if (selectedStar === 0) {
                    starError.classList.add('show');
                    isValid = false;
                }

                if (!isValid) return;

                submitBtn.disabled = true;
                submitBtn.textContent = 'Submitting...';

                setTimeout(() => {
                    successMsg.classList.add('show');
                    
                    form.reset();
                    nameInput.classList.remove('invalid');
                    emailInput.classList.remove('invalid');
                    typeSelect.classList.remove('invalid');
                    messageInput.classList.remove('invalid');
                    
                    emojiItems.forEach(i => i.classList.remove('selected'));
                    stars.forEach(s => {
                        s.classList.remove('selected');
                        s.style.color = '#ddd';
                    });
                    
                    ratingValue.textContent = '0/5';
                    selectedEmoji = 0;
                    selectedStar = 0;
                    
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Submit Feedback';
                    
                    setTimeout(() => {
                        successMsg.classList.remove('show');
                    }, 5000);
                }, 1500);
            });
        });


        // MEMBERSHIP
          // Loading & AOS
        window.addEventListener('load', function() {
            const loadingPage = document.getElementById('loading-page');
            const mainContent = document.querySelector('.main-content');
            
            setTimeout(function() {
                loadingPage.classList.add('loaded');
                mainContent.classList.add('show');
                setTimeout(function() {
                    loadingPage.style.display = 'none';
                }, 800);
            }, 1800);

            AOS.init({ duration: 700, once: true, offset: 40, easing: 'ease-out' });

            const navbar = document.querySelector('.navbar');
            const backBtn = document.getElementById('backToTop');
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 80) {
                    navbar?.classList.add('scrolled');
                    backBtn?.classList.add('show');
                } else {
                    navbar?.classList.remove('scrolled');
                    backBtn?.classList.remove('show');
                }
            });

            backBtn?.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        // ===== NAME FIELD RESTRICTION - NO NUMBERS ALLOWED =====
        function restrictNameInput(inputElement) {
            // Remove any numbers on input
            inputElement.addEventListener('input', function(e) {
                this.value = this.value.replace(/[0-9]/g, '');
            });
            
            // Prevent number keys from being typed
            inputElement.addEventListener('keydown', function(e) {
                // Allow: backspace, delete, tab, escape, enter, arrow keys, space
                if (e.key === 'Backspace' || e.key === 'Delete' || e.key === 'Tab' || 
                    e.key === 'Escape' || e.key === 'Enter' || e.key === 'ArrowLeft' || 
                    e.key === 'ArrowRight' || e.key === 'ArrowUp' || e.key === 'ArrowDown' ||
                    e.key === ' ' || e.key === 'Space') {
                    return;
                }
                // Prevent numbers
                if (/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
            });
        }

        // Apply name restriction to all name fields
        document.addEventListener('DOMContentLoaded', function() {
            const nameFields = document.querySelectorAll('.name-field');
            nameFields.forEach(field => {
                restrictNameInput(field);
            });
        });

        // Membership Card Selection
        let selectedType = '';
        const cards = document.querySelectorAll('.membership-card');
        cards.forEach(card => {
            card.addEventListener('click', function() {
                cards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                selectedType = this.dataset.type;
                document.getElementById('membershipType').value = selectedType;
                document.getElementById('membershipTypeError').classList.remove('show');
            });
        });

        // Hide Alert
        function hideAlert() {
            document.getElementById('successAlert').classList.remove('show');
        }

        function showAlert() {
            const alert = document.getElementById('successAlert');
            alert.classList.remove('show');
            setTimeout(() => {
                alert.classList.add('show');
                setTimeout(() => hideAlert(), 5000);
            }, 100);
        }

        // Get Membership Details
        function getMembershipDetails(type) {
            const details = {
                annual: { name: 'Annual Membership', price: 'Rs. 25,000' },
                'half-yearly': { name: 'Half-Yearly Membership', price: 'Rs. 15,000' },
                quarterly: { name: 'Quarterly Membership', price: 'Rs. 9,000' },
                monthly: { name: 'Monthly Membership', price: 'Rs. 3,500' }
            };
            return details[type] || { name: 'Not Selected', price: 'N/A' };
        }

        // Submit Another
        function submitAnother() {
            document.getElementById('confirmationSection').style.display = 'none';
            document.getElementById('formSection').style.display = 'block';
            document.getElementById('membershipForm').reset();
            cards.forEach(c => c.classList.remove('selected'));
            selectedType = '';
            document.getElementById('membershipType').value = '';
        }

        // Download (placeholder)
        function downloadApp() {
            alert('Application download feature coming soon. Please save your Application ID: ' + document.getElementById('appId').innerText);
        }

        // Form Submission
        document.getElementById('membershipForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Reset errors
            document.querySelectorAll('.error-message').forEach(el => el.classList.remove('show'));
            document.querySelectorAll('.form-control, .form-select').forEach(el => el.classList.remove('is-invalid'));
            
            let isValid = true;
            
            // Check membership type
            if (!selectedType) {
                document.getElementById('membershipTypeError').classList.add('show');
                isValid = false;
            }
            
            // Check terms
            if (!document.getElementById('agreeTerms').checked) {
                document.getElementById('termsError').classList.add('show');
                isValid = false;
            }
            
            // Check required fields
            const required = ['fullName', 'fatherName', 'email', 'phone', 'cnic', 'dob', 'gender', 'address', 'emergencyName', 'emergencyPhone'];
            required.forEach(id => {
                const field = document.getElementById(id);
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                }
            });
            
            // Email validation
            const email = document.getElementById('email').value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email && !emailPattern.test(email)) {
                document.getElementById('email').classList.add('is-invalid');
                isValid = false;
            }
            
            if (!isValid) return;
            
            // Get form data
            const formData = {
                fullName: document.getElementById('fullName').value,
                membershipType: selectedType
            };
            
            const details = getMembershipDetails(selectedType);
            
            // Update confirmation
            document.getElementById('confirmName').innerText = formData.fullName;
            document.getElementById('confirmMembership').innerText = details.name;
            document.getElementById('confirmAmount').innerText = details.price;
            document.getElementById('confirmDate').innerText = new Date().toLocaleDateString();
            document.getElementById('appId').innerText = 'NNG-' + new Date().getFullYear() + '-' + Math.floor(Math.random() * 10000);
            
            // Show confirmation
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('confirmationSection').style.display = 'block';
            showAlert();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // CNIC Formatting
        document.getElementById('cnic').addEventListener('input', function(e) {
            let val = e.target.value.replace(/\D/g, '');
            if (val.length > 13) val = val.slice(0, 13);
            if (val.length <= 5) e.target.value = val;
            else if (val.length <= 12) e.target.value = val.slice(0,5) + '-' + val.slice(5);
            else e.target.value = val.slice(0,5) + '-' + val.slice(5,12) + '-' + val.slice(12);
        });
        
        // Phone Formatting
        document.getElementById('phone').addEventListener('input', function(e) {
            let val = e.target.value.replace(/\D/g, '');
            if (val.length > 11) val = val.slice(0, 11);
            if (val.length <= 4) e.target.value = val;
            else if (val.length <= 7) e.target.value = val.slice(0,4) + '-' + val.slice(4);
            else e.target.value = val.slice(0,4) + '-' + val.slice(4,7) + '-' + val.slice(7);
        });
        
        // Date of Birth limits (min 16 years)
        const today = new Date();
        const maxDate = new Date(today.getFullYear() - 16, today.getMonth(), today.getDate());
        document.getElementById('dob').max = maxDate.toISOString().split('T')[0];



        // GALLERY
         window.addEventListener('load', function() {
            const loadingPage = document.getElementById('loading-page');
            const mainContent = document.querySelector('.main-content');
            
            setTimeout(function() {
                loadingPage.classList.add('loaded');
                mainContent.classList.add('show');
                setTimeout(function() {
                    loadingPage.style.display = 'none';
                }, 800);
            }, 1800);

            AOS.init({ duration: 700, once: true, offset: 40, easing: 'ease-out' });

            const navbar = document.querySelector('.navbar');
            const backBtn = document.getElementById('backToTop');
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 80) {
                    navbar?.classList.add('scrolled');
                    backBtn?.classList.add('show');
                } else {
                    navbar?.classList.remove('scrolled');
                    backBtn?.classList.remove('show');
                }
            });

            backBtn?.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // Gallery lightbox modal
            document.querySelectorAll('.gallery-item').forEach(item => {
                item.addEventListener('click', function() {
                    const imgSrc = this.querySelector('img').src;
                    const imgAlt = this.querySelector('.gallery-overlay h5')?.innerText || 'Gallery Image';
                    const modalHTML = `
                        <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content bg-transparent border-0">
                                    <div class="modal-header border-0 pb-0">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center p-0">
                                        <img src="${imgSrc}" alt="${imgAlt}" class="img-fluid rounded-4 shadow-lg" style="border: 2px solid var(--accent-gold);">
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    document.body.insertAdjacentHTML('beforeend', modalHTML);
                    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
                    modal.show();
                    document.getElementById('imageModal').addEventListener('hidden.bs.modal', function() { this.remove(); });
                });
            });
        });



        // CONTACT
         window.addEventListener('load', function() {
            const loadingPage = document.getElementById('loading-page');
            const mainContent = document.querySelector('.main-content');
            
            setTimeout(function() {
                loadingPage.classList.add('loaded');
                mainContent.classList.add('show');
                setTimeout(function() {
                    loadingPage.style.display = 'none';
                }, 800);
            }, 1800);

            AOS.init({ duration: 700, once: true, offset: 40, easing: 'ease-out' });

            const navbar = document.querySelector('.navbar');
            const backBtn = document.getElementById('backToTop');
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 80) {
                    navbar?.classList.add('scrolled');
                    backBtn?.classList.add('show');
                } else {
                    navbar?.classList.remove('scrolled');
                    backBtn?.classList.remove('show');
                }
            });

            backBtn?.addEventListener('click', (e) => {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // Animation on scroll observer
            const elements = document.querySelectorAll('.animate-on-scroll');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                    }
                });
            }, { threshold: 0.1 });
            elements.forEach(element => observer.observe(element));
        });