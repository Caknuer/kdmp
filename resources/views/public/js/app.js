document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('menuToggle');
    const menu = document.getElementById('menu');

    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            menu.classList.toggle('show');
        });
    }
});

// untuk di hall pengurus
document.querySelectorAll('.pengurus-card').forEach(card => {
    card.addEventListener('click', () => {
        document.getElementById('modal-name').innerText = card.dataset.name;
        document.getElementById('modal-role').innerText = card.dataset.role;
        document.getElementById('modal-desc').innerText = card.dataset.desc;
        document.getElementById('modal').style.display = 'flex';
    });
});

document.querySelector('.modal .close').onclick = () => {
    document.getElementById('modal').style.display = 'none';
};

document.getElementById('modal').onclick = e => {
    if (e.target.id === 'modal') {
        e.target.style.display = 'none';
    }
};
