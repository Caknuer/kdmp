/* =========================================================
   KDMP UI - JS (Clean + Consistent)
   - Navbar: mobile toggle + dropdown
   - Shadow on scroll
   - Modal: org + mitra (match .modal-overlay.active)
   - Scroll reveal: IntersectionObserver (single version)
   - Finance chart: Chart.js safe init
========================================================= */

(function () {
    /* =========================
       NAVBAR
    ========================= */
    const navbar = document.querySelector('.navbar');
    const toggle = document.querySelector('.nav-toggle');
    const menu = document.querySelector('.nav-menu');
    const dropdowns = document.querySelectorAll('.nav-dropdown');

    // Safety: kalau navbar partial tidak ada di halaman tertentu
    if (navbar) {
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 10);
        });
    }

    if (toggle && menu) {
        const closeMobileMenu = () => {
            menu.classList.remove('open');
            toggle.classList.remove('active');
            toggle.setAttribute('aria-expanded', 'false');
            dropdowns.forEach(d => d.classList.remove('open'));
            dropdowns.forEach(d => {
                const btn = d.querySelector('.dropdown-toggle');
                if (btn) btn.setAttribute('aria-expanded', 'false');
            });
        };

        const openMobileMenu = () => {
            menu.classList.add('open');
            toggle.classList.add('active');
            toggle.setAttribute('aria-expanded', 'true');
        };

        // Toggle menu (mobile)
        if (toggle) {
            toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = menu.classList.contains('open');
                if (isOpen) closeMobileMenu();
                else openMobileMenu();
            });
        }

        // Dropdown behavior (mobile only)
        dropdowns.forEach(dropdown => {
            const toggleBtn = dropdown.querySelector('.dropdown-toggle');
            if (!toggleBtn) return;

            toggleBtn.addEventListener('click', (e) => {
                // Hanya aktif di layar kecil
                if (window.innerWidth > 768) return;

                e.preventDefault();
                e.stopPropagation(); // Stop bubbling agar tidak menutup menu utama

                // Toggle state dropdown ini
                const isCurrentlyOpen = dropdown.classList.contains('open');

                // Opsional: Tutup dropdown lain jika ingin accordion style (satu terbuka)
                // dropdowns.forEach(d => {
                //   if (d !== dropdown) {
                //     d.classList.remove('open');
                //     const btn = d.querySelector('.dropdown-toggle');
                //     if(btn) btn.setAttribute('aria-expanded', 'false');
                //   }
                // });

                if (isCurrentlyOpen) {
                    dropdown.classList.remove('open');
                    toggleBtn.setAttribute('aria-expanded', 'false');
                } else {
                    dropdown.classList.add('open');
                    toggleBtn.setAttribute('aria-expanded', 'true');
                }
            });
        });

        // Close menu when clicking links (mobile UX)
        menu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                // Cek apakah link ini BUKAN toggle dropdown
                if (!link.classList.contains('dropdown-toggle') && window.innerWidth <= 768) {
                    closeMobileMenu();
                }
            });
        });

        // Klik luar: tutup menu mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                // Jika klik terjadi di luar navbar, tutup
                if (!navbar.contains(e.target)) {
                    closeMobileMenu();
                }
            }
        });

        // Resize handler
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                closeMobileMenu();
            }
        });

    }

    /* =========================
       MODAL HELPERS (overlay-based)
       CSS: .modal-overlay + .modal + .modal-close
    ========================= */
    const lockScroll = (locked) => {
        document.documentElement.style.overflow = locked ? 'hidden' : '';
        document.body.style.overflow = locked ? 'hidden' : '';
    };

    function bindOverlayModal(overlayEl, { onOpen, onClose } = {}) {
        if (!overlayEl) return null;

        const closeBtn = overlayEl.querySelector('.modal-close');
        const close = () => {
            overlayEl.classList.remove('active');
            overlayEl.setAttribute('aria-hidden', 'true');
            lockScroll(false);
            if (typeof onClose === 'function') onClose();
        };

        const open = (payload) => {
            if (typeof onOpen === 'function') onOpen(payload);
            overlayEl.classList.add('active');
            overlayEl.setAttribute('aria-hidden', 'false');
            lockScroll(true);
        };

        if (closeBtn) closeBtn.addEventListener('click', close);

        // klik area gelap = tutup
        overlayEl.addEventListener('click', (e) => {
            if (e.target === overlayEl) close();
        });

        // ESC = tutup
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && overlayEl.classList.contains('active')) close();
        });

        return { open, close };
    }

    /* =========================
       MODAL: Pengurus & Pengawas
       Trigger: .org-card data-*
       Modal overlay id: #orgModal (sekarang harus modal-overlay)
       Element id: #modalPhoto #modalName #modalRole #modalBio
    ========================= */
    /* =========================
       MODAL: Pengurus & Pengawas
       Trigger: .org-card data-*
       Modal overlay id: #orgModal
       Element id: #modalPhoto (container), #modalName, #modalRole, #modalBio
       Action: #modalCloseBtnOrg
    ========================= */
    const orgOverlay = document.getElementById('orgModal');
    const orgModal = bindOverlayModal(orgOverlay, {
        onOpen: ({ photo, name, role, bio }) => {
            const elPhoto = document.getElementById('modalPhoto');
            const elName = document.getElementById('modalName');
            const elRole = document.getElementById('modalRole');
            const elBio = document.getElementById('modalBio');

            if (elName) elName.textContent = name || '-';
            if (elRole) elRole.textContent = role || '';
            if (elBio) elBio.textContent = bio || '-';

            // Photo / Logo logic (Org/People specifics)
            if (elPhoto) {
                elPhoto.innerHTML = '';
                if (photo && photo !== 'null') {
                    const img = document.createElement('img');
                    img.src = photo;
                    img.alt = name;
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '50%';
                    elPhoto.appendChild(img);
                } else {
                    // Fallback text avatar
                    elPhoto.textContent = (name || '?').charAt(0).toUpperCase();
                    elPhoto.style.fontSize = '32px';
                    elPhoto.style.display = 'grid';
                    elPhoto.style.placeItems = 'center';
                    elPhoto.style.color = '#0f172a';
                    elPhoto.style.fontWeight = 'bold';
                    elPhoto.style.backgroundColor = '#f1f5f9';
                }
            }
        }
    });

    // Close button for Org Modal
    const orgCloseBtn = document.getElementById('modalCloseBtnOrg');
    if (orgCloseBtn && orgModal) {
        orgCloseBtn.addEventListener('click', orgModal.close);
    }

    document.querySelectorAll('.org-card').forEach(card => {
        card.addEventListener('click', () => {
            if (!orgModal) return;
            orgModal.open({
                photo: card.dataset.photo || '',
                name: card.dataset.name || '',
                role: card.dataset.role || '',
                bio: card.dataset.bio || ''
            });
        });
    });

    /* =========================
       MODAL: Mitra/Partner
       Trigger: .mitra-card data-*
       Modal overlay id: #mitraModal
       Element id: #modalLogo #modalName #modalDesc #modalWebsiteText #modalWebsiteBtn
       Optional close button id: #modalCloseBtn
    ========================= */
    const mitraOverlay = document.getElementById('mitraModal');
    const mitraModal = bindOverlayModal(mitraOverlay, {
        onOpen: ({ name, desc, website, logo }) => {
            const elLogo = document.getElementById('modalLogo');
            const elName = document.getElementById('modalName');
            const elDesc = document.getElementById('modalDesc');
            const elWebsiteText = document.getElementById('modalWebsiteText');
            const elWebsiteBtn = document.getElementById('modalWebsiteBtn');

            if (elName) elName.textContent = name || 'Detail Mitra';
            if (elDesc) elDesc.textContent = desc || '';

            if (elWebsiteText) elWebsiteText.textContent = website || '';
            if (elWebsiteBtn) {
                if (website) {
                    elWebsiteBtn.style.display = 'inline-flex';
                    elWebsiteBtn.href = website;
                } else {
                    elWebsiteBtn.style.display = 'none';
                    elWebsiteBtn.href = '#';
                }
            }

            // Logo: URL gambar atau inisial
            if (elLogo) {
                elLogo.innerHTML = '';
                if (logo && /^https?:\/\//.test(logo)) {
                    const img = document.createElement('img');
                    img.src = logo;
                    img.alt = name || 'Mitra';
                    elLogo.appendChild(img);
                } else {
                    elLogo.textContent = logo || '';
                }
            }
        }
    });

    // Optional close button di body modal
    const mitraCloseBtn = document.getElementById('modalCloseBtn');
    if (mitraCloseBtn && mitraModal) {
        mitraCloseBtn.addEventListener('click', mitraModal.close);
    }

    document.querySelectorAll('.mitra-card').forEach(card => {
        const handler = () => {
            if (!mitraModal) return;
            mitraModal.open({
                name: card.dataset.name || '',
                desc: card.dataset.desc || '',
                website: card.dataset.website || '',
                logo: card.dataset.logo || ''
            });
        };

        card.addEventListener('click', handler);
        card.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                handler();
            }
        });
    });

    /* =========================
       SCROLL REVEAL (single version)
       class: .reveal -> add .active when visible
    ========================= */
    const reveals = document.querySelectorAll('.reveal');
    if (reveals.length) {
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        reveals.forEach(el => observer.observe(el));
    }

    /* =========================
       FINANCE CHART (Chart.js) - safe init
    ========================= */
    (function () {
        const canvas = document.getElementById('financeChart');
        if (!canvas || typeof Chart === 'undefined') return;

        const monthly = Array.isArray(window.financeMonthly) ? window.financeMonthly : [];
        if (!monthly.length) return;

        const sliced = monthly.slice(0, 12).reverse();
        const labels = sliced.map(x => x.month);
        const income = sliced.map(x => Number(x.income || 0));
        const expense = sliced.map(x => Number(x.expense || 0));
        const balance = sliced.map(x => Number(x.balance || (Number(x.income || 0) - Number(x.expense || 0))));

        const rupiah = (n) => {
            try { return 'Rp ' + Number(n).toLocaleString('id-ID'); }
            catch { return 'Rp ' + n; }
        };

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
                            callback: function (value) { return rupiah(value); },
                        },
                    },
                },
            },
        });
    })();

})();