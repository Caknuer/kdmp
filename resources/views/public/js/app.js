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

// untuk hall mitra
document.querySelectorAll('.mitra-card').forEach(card => {
    card.addEventListener('click', () => {
        document.getElementById('modal-name').innerText = card.dataset.name;
        document.getElementById('modal-type').innerText = card.dataset.type;
        document.getElementById('modal-desc').innerText = card.dataset.desc;
        document.getElementById('modal-logo').innerText = card.dataset.logo;
        document.getElementById('mitraModal').style.display = 'flex';
    });
});

document.querySelectorAll('.modal .close').forEach(btn => {
    btn.onclick = () => btn.closest('.modal-overlay').style.display = 'none';
});

document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.onclick = e => {
        if (e.target.classList.contains('modal-overlay')) {
            e.target.style.display = 'none';
        }
    };
});

// untk unit bisnis
/* UNIT BISNIS */
document.querySelectorAll('.bisnis-card').forEach(card => {
    card.addEventListener('click', () => {
        document.getElementById('modal-name').innerText = card.dataset.name;
        document.getElementById('modal-category').innerText = card.dataset.category;
        document.getElementById('modal-desc').innerText = card.dataset.desc;
        document.getElementById('modal-icon').innerText = card.dataset.icon;
        document.getElementById('bisnisModal').style.display = 'flex';
    });
});
