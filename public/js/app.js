const toggle = document.querySelector('.nav-toggle');
const menu = document.querySelector('.nav-menu');
const dropdowns = document.querySelectorAll('.nav-dropdown');
const navbar = document.querySelector('.navbar');

toggle.addEventListener('click', () => {
    menu.classList.toggle('open');
    toggle.classList.toggle('active');
});

dropdowns.forEach(dropdown => {
    dropdown.querySelector('.dropdown-toggle')
        .addEventListener('click', () => {
            e.stopPropagation();
            dropdown.classList.toggle('open');
        });
});

window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 10);
});
