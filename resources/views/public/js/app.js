document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('menuToggle');
    const menu = document.getElementById('menu');

    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            menu.classList.toggle('show');
        });
    }
});
