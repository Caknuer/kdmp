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

        modal.classList.add('active');
    });
});

modalClose.addEventListener('click', () => {
    modal.classList.remove('active');
});

modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.classList.remove('active');
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

// Home
/* =====================
   SCROLL REVEAL
===================== */
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('active');
            observer.unobserve(entry.target);
        }
    });
}, {
    threshold: 0.15
});

reveals.forEach(el => observer.observe(el));

/* =========================
   FINANCE CHART (Chart.js)
========================= */
(function () {
    const canvas = document.getElementById('financeChart');
    if (!canvas) return; // biar halaman lain tidak error

    // data dari blade: window.financeMonthly = [...]
    const monthly = Array.isArray(window.financeMonthly) ? window.financeMonthly : [];

    // kalau kosong, tidak usah render chart
    if (!monthly.length) return;

    // ambil 6-12 bulan terakhir biar chart tidak kepanjangan
    const sliced = monthly.slice(0, 12).reverse();

    const labels = sliced.map(x => x.month);
    const income = sliced.map(x => Number(x.income || 0));
    const expense = sliced.map(x => Number(x.expense || 0));
    const balance = sliced.map(x => Number(x.balance || (Number(x.income || 0) - Number(x.expense || 0))));

    // format rupiah tooltip
    const rupiah = (n) => {
        try {
            return 'Rp ' + Number(n).toLocaleString('id-ID');
        } catch {
            return 'Rp ' + n;
        }
    };

    // render chart
    new Chart(canvas, {
        type: 'line',
        data: {
            labels,
            datasets: [
                { label: 'Pemasukan', data: income, tension: 0.3 },
                { label: 'Pengeluaran', data: expense, tension: 0.3 },
                { label: 'Saldo Akhir', data: balance, tension: 0.3 },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: true },
                tooltip: {
                    callbacks: {
                        label: function (ctx) {
                            return `${ctx.dataset.label}: ${rupiah(ctx.parsed.y)}`;
                        },
                    },
                },
            },
            scales: {
                y: {
                    ticks: {
                        callback: function (value) {
                            return rupiah(value);
                        },
                    },
                },
            },
        },
    });
})();
