const toggle = document.querySelector('.nav-toggle');
const menu = document.querySelector('.nav-menu');
const dropdowns = document.querySelectorAll('.nav-dropdown');
const navbar = document.querySelector('.navbar');

/* TOGGLE MENU MOBILE */
toggle.addEventListener('click', (e) => {
    e.stopPropagation();

    menu.classList.toggle('open');
    toggle.classList.toggle('active');

    if (!menu.classList.contains('open')) {
        dropdowns.forEach(d => d.classList.remove('open'));
    }
});

/* DROPDOWN */
dropdowns.forEach(dropdown => {
    const toggleBtn = dropdown.querySelector('.dropdown-toggle');

    toggleBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        dropdown.classList.toggle('open');
    });

    // Tutup menu setelah klik link (mobile UX)
    dropdown.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            menu.classList.remove('open');
            toggle.classList.remove('active');
            dropdowns.forEach(d => d.classList.remove('open'));
        });
    });
});

/* KLIK LUAR (HANYA MOBILE) */
document.addEventListener('click', () => {
    if (window.innerWidth <= 768) {
        dropdowns.forEach(d => d.classList.remove('open'));
        menu.classList.remove('open');
        toggle.classList.remove('active');
    }
});

/* SHADOW SAAT SCROLL */
window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 10);
});

// Pengurus & Pengawas
const cards = document.querySelectorAll('.org-card');
const modal = document.getElementById('orgModal');

const modalPhoto = document.getElementById('modalPhoto');
const modalName = document.getElementById('modalName');
const modalRole = document.getElementById('modalRole');
const modalBio = document.getElementById('modalBio');
const modalClose = document.querySelector('.modal-close');

cards.forEach(card => {
    card.addEventListener('click', () => {
        modalPhoto.src = card.dataset.photo;
        modalName.textContent = card.dataset.name;
        modalRole.textContent = card.dataset.role;
        modalBio.textContent = card.dataset.bio || '';

        modal.classList.add('show');
    });
});

modalClose.addEventListener('click', () => {
    modal.classList.remove('show');
});

modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.classList.remove('show');
    }
});

/* =========================
   SCROLL REVEAL
========================= */
const reveals = document.querySelectorAll('.reveal');

const revealOnScroll = () => {
    reveals.forEach(el => {
        const windowHeight = window.innerHeight;
        const elementTop = el.getBoundingClientRect().top;

        if (elementTop < windowHeight - 80) {
            el.classList.add('active');
        }
    });
};

window.addEventListener('scroll', revealOnScroll);
window.addEventListener('load', revealOnScroll);
