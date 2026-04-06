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
