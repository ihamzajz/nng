function initializePublicPage() {
    const loadingPage = document.getElementById('loading-page');
    const mainContent = document.querySelector('.main-content');
    const navbar = document.querySelector('.navbar');
    const backBtn = document.getElementById('backToTop');

    setTimeout(() => {
        if (loadingPage) {
            loadingPage.classList.add('loaded');
            setTimeout(() => {
                loadingPage.style.display = 'none';
            }, 800);
        }

        if (mainContent) {
            mainContent.classList.add('show');
        }
    }, 1800);

    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 700, once: true, offset: 40, easing: 'ease-out' });
    }

    window.addEventListener('scroll', () => {
        if (window.scrollY > 80) {
            navbar?.classList.add('scrolled');
            backBtn?.classList.add('show');
        } else {
            navbar?.classList.remove('scrolled');
            backBtn?.classList.remove('show');
        }
    });

    backBtn?.addEventListener('click', (event) => {
        event.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

function initializeGalleryLightbox() {
    document.querySelectorAll('.gallery-item').forEach((item) => {
        item.addEventListener('click', function handleGalleryClick() {
            const image = this.querySelector('img');

            if (!image) {
                return;
            }

            const title = this.querySelector('h5')?.innerText || 'Gallery Image';
            const modalHTML = `
                <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content bg-transparent border-0">
                            <div class="modal-header border-0 pb-0">
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center p-0">
                                <img src="${image.src}" alt="${title}" class="img-fluid rounded-4 shadow-lg" style="border: 2px solid var(--accent-gold);">
                            </div>
                        </div>
                    </div>
                </div>`;

            document.body.insertAdjacentHTML('beforeend', modalHTML);
            const modalElement = document.getElementById('imageModal');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
            modalElement.addEventListener('hidden.bs.modal', () => modalElement.remove(), { once: true });
        });
    });
}

function initializeAnimatedCards() {
    const elements = document.querySelectorAll('.animate-on-scroll');

    if (!elements.length) {
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
            }
        });
    }, { threshold: 0.1 });

    elements.forEach((element) => observer.observe(element));
}

function initializeFeedbackForm() {
    const form = document.getElementById('feedbackForm');

    if (!form) {
        return;
    }

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

    const validateName = (name) => /^[A-Za-z\s]{5,}$/.test(name);
    const validateEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    const validateMessage = (message) => message.length >= 10;

    nameInput?.addEventListener('input', function onNameInput() {
        const valid = !this.value.trim() || validateName(this.value.trim());
        this.classList.toggle('invalid', !valid);
        nameError?.classList.toggle('show', !valid);
    });

    emailInput?.addEventListener('input', function onEmailInput() {
        const valid = !this.value.trim() || validateEmail(this.value.trim());
        this.classList.toggle('invalid', !valid);
        emailError?.classList.toggle('show', !valid);
    });

    messageInput?.addEventListener('input', function onMessageInput() {
        const valid = !this.value.trim() || validateMessage(this.value.trim());
        this.classList.toggle('invalid', !valid);
        messageError?.classList.toggle('show', !valid);
    });

    emojiItems.forEach((item) => {
        item.addEventListener('click', () => {
            emojiItems.forEach((entry) => entry.classList.remove('selected'));
            item.classList.add('selected');
            selectedEmoji = Number(item.dataset.rating || 0);
            emojiError?.classList.remove('show');
        });
    });

    stars.forEach((star) => {
        star.addEventListener('mouseover', () => {
            const rating = Number(star.dataset.rating || 0);
            stars.forEach((entry) => {
                entry.style.color = Number(entry.dataset.rating || 0) <= rating ? '#C5A028' : '#ddd';
            });
        });

        star.addEventListener('mouseout', () => {
            stars.forEach((entry) => {
                entry.style.color = Number(entry.dataset.rating || 0) <= selectedStar ? '#C5A028' : '#ddd';
            });
        });

        star.addEventListener('click', () => {
            selectedStar = Number(star.dataset.rating || 0);
            stars.forEach((entry) => {
                const active = Number(entry.dataset.rating || 0) <= selectedStar;
                entry.classList.toggle('selected', active);
                entry.style.color = active ? '#C5A028' : '#ddd';
            });
            if (ratingValue) {
                ratingValue.textContent = `${selectedStar}/5`;
            }
            starError?.classList.remove('show');
        });
    });

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        document.querySelectorAll('.error-message').forEach((element) => element.classList.remove('show'));
        let isValid = true;

        if (!nameInput || !validateName(nameInput.value.trim())) {
            nameInput?.classList.add('invalid');
            nameError?.classList.add('show');
            isValid = false;
        }

        if (!emailInput || !validateEmail(emailInput.value.trim())) {
            emailInput?.classList.add('invalid');
            emailError?.classList.add('show');
            isValid = false;
        }

        if (!typeSelect || !typeSelect.value) {
            typeSelect?.classList.add('invalid');
            typeError?.classList.add('show');
            isValid = false;
        }

        if (!messageInput || !validateMessage(messageInput.value.trim())) {
            messageInput?.classList.add('invalid');
            messageError?.classList.add('show');
            isValid = false;
        }

        if (selectedEmoji === 0) {
            emojiError?.classList.add('show');
            isValid = false;
        }

        if (selectedStar === 0) {
            starError?.classList.add('show');
            isValid = false;
        }

        if (!isValid || !submitBtn) {
            return;
        }

        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';

        setTimeout(() => {
            successMsg?.classList.add('show');
            form.reset();
            nameInput?.classList.remove('invalid');
            emailInput?.classList.remove('invalid');
            typeSelect?.classList.remove('invalid');
            messageInput?.classList.remove('invalid');
            emojiItems.forEach((entry) => entry.classList.remove('selected'));
            stars.forEach((entry) => {
                entry.classList.remove('selected');
                entry.style.color = '#ddd';
            });
            if (ratingValue) {
                ratingValue.textContent = '0/5';
            }
            selectedEmoji = 0;
            selectedStar = 0;
            submitBtn.disabled = false;
            submitBtn.textContent = 'Submit Feedback';

            setTimeout(() => {
                successMsg?.classList.remove('show');
            }, 5000);
        }, 1500);
    });
}

let selectedMembershipType = '';

function hideAlert() {
    document.getElementById('successAlert')?.classList.remove('show');
}

function showAlert() {
    const alert = document.getElementById('successAlert');

    if (!alert) {
        return;
    }

    alert.classList.remove('show');
    setTimeout(() => {
        alert.classList.add('show');
        setTimeout(hideAlert, 5000);
    }, 100);
}

function getMembershipDetails(type) {
    const details = {
        annual: { name: 'Annual Membership', price: 'Rs. 25,000' },
        'half-yearly': { name: 'Half-Yearly Membership', price: 'Rs. 15,000' },
        quarterly: { name: 'Quarterly Membership', price: 'Rs. 9,000' },
        monthly: { name: 'Monthly Membership', price: 'Rs. 3,500' },
    };

    return details[type] || { name: 'Not Selected', price: 'N/A' };
}

function submitAnother() {
    const formSection = document.getElementById('formSection');
    const confirmationSection = document.getElementById('confirmationSection');
    const form = document.getElementById('membershipForm');

    confirmationSection?.style.setProperty('display', 'none');
    formSection?.style.setProperty('display', 'block');
    form?.reset();
    document.querySelectorAll('.membership-card').forEach((card) => card.classList.remove('selected'));
    selectedMembershipType = '';

    const membershipTypeInput = document.getElementById('membershipType');
    if (membershipTypeInput) {
        membershipTypeInput.value = '';
    }
}

function downloadApp() {
    const appId = document.getElementById('appId')?.innerText || '';
    alert(`Application download feature coming soon. Please save your Application ID: ${appId}`);
}

function initializeMembershipForm() {
    const form = document.getElementById('membershipForm');

    if (!form) {
        return;
    }

    document.querySelectorAll('.name-field').forEach((field) => {
        field.addEventListener('input', function onNameFieldInput() {
            this.value = this.value.replace(/[0-9]/g, '');
        });
    });

    const cards = document.querySelectorAll('.membership-card');
    cards.forEach((card) => {
        card.addEventListener('click', () => {
            cards.forEach((entry) => entry.classList.remove('selected'));
            card.classList.add('selected');
            selectedMembershipType = card.dataset.type || '';
            const membershipTypeInput = document.getElementById('membershipType');
            if (membershipTypeInput) {
                membershipTypeInput.value = selectedMembershipType;
            }
            document.getElementById('membershipTypeError')?.classList.remove('show');
        });
    });

    const cnicInput = document.getElementById('cnic');
    cnicInput?.addEventListener('input', (event) => {
        const input = event.target;
        if (!(input instanceof HTMLInputElement)) {
            return;
        }

        const digits = input.value.replace(/\D/g, '').slice(0, 13);
        if (digits.length <= 5) {
            input.value = digits;
        } else if (digits.length <= 12) {
            input.value = `${digits.slice(0, 5)}-${digits.slice(5)}`;
        } else {
            input.value = `${digits.slice(0, 5)}-${digits.slice(5, 12)}-${digits.slice(12)}`;
        }
    });

    const phoneInputs = ['phone', 'emergencyPhone'];
    phoneInputs.forEach((id) => {
        const input = document.getElementById(id);
        input?.addEventListener('input', (event) => {
            const element = event.target;
            if (!(element instanceof HTMLInputElement)) {
                return;
            }

            let value = element.value.replace(/\D/g, '').slice(0, 11);
            if (value.length > 4) {
                value = `${value.slice(0, 4)}-${value.slice(4)}`;
            }
            if (value.length > 8) {
                value = `${value.slice(0, 8)}-${value.slice(8)}`;
            }
            element.value = value;
        });
    });

    const dobInput = document.getElementById('dob');
    if (dobInput instanceof HTMLInputElement) {
        const today = new Date();
        const maxDate = new Date(today.getFullYear() - 16, today.getMonth(), today.getDate());
        dobInput.max = maxDate.toISOString().split('T')[0];
    }

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        document.querySelectorAll('.error-message').forEach((element) => element.classList.remove('show'));
        document.querySelectorAll('.form-control, .form-select').forEach((element) => element.classList.remove('is-invalid'));

        let isValid = true;

        if (!selectedMembershipType) {
            document.getElementById('membershipTypeError')?.classList.add('show');
            isValid = false;
        }

        const agreeTerms = document.getElementById('agreeTerms');
        if (!(agreeTerms instanceof HTMLInputElement) || !agreeTerms.checked) {
            document.getElementById('termsError')?.classList.add('show');
            isValid = false;
        }

        const requiredIds = ['fullName', 'fatherName', 'email', 'phone', 'cnic', 'dob', 'gender', 'address', 'emergencyName', 'emergencyPhone'];
        requiredIds.forEach((id) => {
            const field = document.getElementById(id);
            if (!field || !('value' in field) || !String(field.value).trim()) {
                field?.classList.add('is-invalid');
                isValid = false;
            }
        });

        const emailInput = document.getElementById('email');
        if (emailInput instanceof HTMLInputElement) {
            const validEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim());
            if (!validEmail) {
                emailInput.classList.add('is-invalid');
                isValid = false;
            }
        }

        if (!isValid) {
            return;
        }

        const details = getMembershipDetails(selectedMembershipType);
        const fullName = document.getElementById('fullName');
        const confirmName = document.getElementById('confirmName');
        const confirmMembership = document.getElementById('confirmMembership');
        const confirmAmount = document.getElementById('confirmAmount');
        const confirmDate = document.getElementById('confirmDate');
        const appId = document.getElementById('appId');

        if (confirmName && fullName && 'value' in fullName) {
            confirmName.innerText = String(fullName.value);
        }
        if (confirmMembership) {
            confirmMembership.innerText = details.name;
        }
        if (confirmAmount) {
            confirmAmount.innerText = details.price;
        }
        if (confirmDate) {
            confirmDate.innerText = new Date().toLocaleDateString();
        }
        if (appId) {
            appId.innerText = `NNG-${new Date().getFullYear()}-${Math.floor(Math.random() * 10000)}`;
        }

        document.getElementById('formSection')?.style.setProperty('display', 'none');
        document.getElementById('confirmationSection')?.style.setProperty('display', 'block');
        showAlert();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initializeFeedbackForm();
    initializeMembershipForm();
    initializeAnimatedCards();
    initializeGalleryLightbox();
});

window.addEventListener('load', initializePublicPage);
