const toggle = document.querySelector('.nav-toggle');
const menu = document.querySelector('.nav-menu');
const dropdowns = document.querySelectorAll('.nav-dropdown');
const navbar = document.querySelector('.navbar');

document.addEventListener('click', (e) => {
    dropdowns.forEach(dropdown => {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('open');
        }
    });
});

dropdowns.forEach(dropdown => {
    const toggleBtn = dropdown.querySelector('.dropdown-toggle');

    toggleBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        dropdown.classList.toggle('open');
    });
});

toggle.addEventListener('click', () => {
    menu.classList.toggle('open');
    toggle.classList.toggle('active');

    if (!menu.classList.contains('open')) {
        dropdowns.forEach(d => d.classList.remove('open'));
    }
});

window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 10);
});
