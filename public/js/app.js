/* =========================================================
   KDMP UI - app.js (Clean + Consistent)
   - Navbar: mobile toggle + dropdown
   - Shadow on scroll
   - Modal: org + mitra (overlay-based)
   - Scroll reveal: IntersectionObserver (single)
   - Finance chart: safe init
========================================================= */

(function () {
  /* =========================
     NAVBAR
  ========================= */
  const navbar = document.querySelector(".navbar");
  const toggle = document.querySelector(".nav-toggle");
  const menu = document.querySelector(".nav-menu");
  const dropdowns = document.querySelectorAll(".nav-dropdown");

  if (navbar) {
    window.addEventListener("scroll", () => {
      navbar.classList.toggle("scrolled", window.scrollY > 10);
    });
  }

  if (toggle && menu) {
    const closeMobileMenu = () => {
      menu.classList.remove("open");
      toggle.classList.remove("active");
      dropdowns.forEach((d) => d.classList.remove("open"));
      document.documentElement.style.overflow = "";
      document.body.style.overflow = "";
    };

    toggle.addEventListener("click", (e) => {
      e.stopPropagation();
      const isOpen = menu.classList.contains("open");
      if (isOpen) closeMobileMenu();
      else {
        menu.classList.add("open");
        toggle.classList.add("active");
      }
    });

    dropdowns.forEach((dropdown) => {
      const btn = dropdown.querySelector(".dropdown-toggle");
      if (!btn) return;

      btn.addEventListener("click", (e) => {
        if (window.innerWidth > 768) return;
        e.preventDefault();
        e.stopPropagation();
        dropdown.classList.toggle("open");
      });
    });

    document.addEventListener("click", (e) => {
      if (window.innerWidth <= 768 && navbar && !navbar.contains(e.target)) {
        closeMobileMenu();
      }
    });

    window.addEventListener("resize", () => {
      if (window.innerWidth > 768) closeMobileMenu();
    });
  }

  /* =========================
     MODAL UTIL
  ========================= */
  const lockScroll = (locked) => {
    document.documentElement.style.overflow = locked ? "hidden" : "";
    document.body.style.overflow = locked ? "hidden" : "";
  };

  function bindOverlayModal(overlayEl, onOpen) {
    if (!overlayEl) return null;

    const closeBtn = overlayEl.querySelector(".modal-close");

    const close = () => {
      overlayEl.classList.remove("active");
      overlayEl.setAttribute("aria-hidden", "true");
      lockScroll(false);
    };

    const open = (payload) => {
      if (typeof onOpen === "function") onOpen(payload);
      overlayEl.classList.add("active");
      overlayEl.setAttribute("aria-hidden", "false");
      lockScroll(true);
    };

    if (closeBtn) closeBtn.addEventListener("click", close);

    overlayEl.addEventListener("click", (e) => {
      if (e.target === overlayEl) close();
    });

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && overlayEl.classList.contains("active")) close();
    });

    return { open, close };
  }

  /* =========================
     MODAL: ORG (Pengurus/Pengawas)
  ========================= */
  const orgOverlay = document.getElementById("orgModal");

  const orgModal = bindOverlayModal(orgOverlay, ({ photo, name, role, bio, initial }) => {
    const elPhoto = document.getElementById("modalPhoto");
    const elName = document.getElementById("modalName");
    const elRole = document.getElementById("modalRole");
    const elBio = document.getElementById("modalBio");

    if (elName) elName.textContent = name || "-";
    if (elRole) elRole.textContent = role || "";
    if (elBio) {
      // biar newline dari DB tetap rapi
      const safeBio = (bio || "").toString();
      elBio.textContent = safeBio || "-";
    }

    // photo container selalu bersih
    if (elPhoto) {
      elPhoto.innerHTML = "";

      const showInitial = () => {
        elPhoto.textContent = (initial || name || "?").charAt(0).toUpperCase();
        elPhoto.style.display = "grid";
        elPhoto.style.placeItems = "center";
        elPhoto.style.fontSize = "22px";
        elPhoto.style.fontWeight = "900";
        elPhoto.style.color = "#0f172a";
        elPhoto.style.background = "rgba(255,255,255,0.12)";
      };

      if (photo) {
        const img = document.createElement("img");
        img.src = photo;
        img.alt = name || "Foto";
        img.loading = "lazy";
        img.onerror = showInitial;
        elPhoto.appendChild(img);
      } else {
        showInitial();
      }
    }
  });

  // trigger: click + keyboard
  document.querySelectorAll(".org-card").forEach((card) => {
    const payload = () => ({
      photo: card.dataset.photo || "",
      name: card.dataset.name || "",
      role: card.dataset.role || "",
      bio: card.dataset.bio || "",
      initial: card.dataset.initial || "",
    });

    card.addEventListener("click", () => {
      if (!orgModal) return;
      orgModal.open(payload());
    });

    card.addEventListener("keydown", (e) => {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        if (!orgModal) return;
        orgModal.open(payload());
      }
    });
  });

  /* =========================
     MODAL: MITRA (optional)
  ========================= */
  (function () {
  const overlay = document.getElementById('mitraModal');
  if (!overlay) return;

  const modalLogo = document.getElementById('mitraModalLogo');
  const modalTitle = document.getElementById('mitraModalTitle');
  const modalWebsiteText = document.getElementById('mitraModalWebsiteText');
  const modalDesc = document.getElementById('mitraModalDesc');
  const modalWebsiteBtn = document.getElementById('mitraModalWebsiteBtn');
  const closeBtn = overlay.querySelector('.mitra-modal-close');

  const lockScroll = (locked) => {
    document.documentElement.style.overflow = locked ? 'hidden' : '';
    document.body.style.overflow = locked ? 'hidden' : '';
  };

  const open = ({ name, desc, website, logoUrl, initials }) => {
    overlay.classList.add('active');
    overlay.setAttribute('aria-hidden', 'false');
    lockScroll(true);

    if (modalTitle) modalTitle.textContent = name || 'Detail Mitra';
    if (modalDesc) modalDesc.textContent = desc || '-';

    // website text + tombol
    if (modalWebsiteText) modalWebsiteText.textContent = website || '';
    if (modalWebsiteBtn) {
      if (website) {
        const normalized = website.match(/^https?:\/\//) ? website : `https://${website}`;
        modalWebsiteBtn.href = normalized;
        modalWebsiteBtn.style.display = 'inline-flex';
      } else {
        modalWebsiteBtn.href = '#';
        modalWebsiteBtn.style.display = 'none';
      }
    }

    // logo bulat / inisial
    if (modalLogo) {
      modalLogo.innerHTML = '';
      if (logoUrl) {
        const img = document.createElement('img');
        img.src = logoUrl;
        img.alt = name || 'Mitra';
        modalLogo.appendChild(img);
      } else {
        modalLogo.textContent = (initials || (name || '?').charAt(0)).toUpperCase();
      }
    }
  };

  const close = () => {
    overlay.classList.remove('active');
    overlay.setAttribute('aria-hidden', 'true');
    lockScroll(false);
  };

  // events
  if (closeBtn) closeBtn.addEventListener('click', close);

  overlay.addEventListener('click', (e) => {
    if (e.target === overlay) close();
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && overlay.classList.contains('active')) close();
  });

  document.querySelectorAll('.mitra-card').forEach((card) => {
    card.addEventListener('click', () => {
      open({
        name: card.dataset.mitraName || '',
        desc: card.dataset.mitraDesc || '',
        website: card.dataset.mitraWebsite || '',
        logoUrl: card.dataset.mitraLogo || '',
        initials: card.dataset.mitraInitials || '',
      });
    });
  });
})();

  /* =========================
     SCROLL REVEAL
  ========================= */
  const reveals = document.querySelectorAll(".reveal");
  if (reveals.length) {
    const observer = new IntersectionObserver(
      (entries, obs) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("active");
            obs.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15 }
    );
    reveals.forEach((el) => observer.observe(el));
  }

  /* =========================
     FINANCE CHART (optional)
  ========================= */
  (function () {
    const canvas = document.getElementById("financeChart");
    if (!canvas || typeof Chart === "undefined") return;

    const monthly = Array.isArray(window.financeMonthly) ? window.financeMonthly : [];
    if (!monthly.length) return;

    const sliced = monthly.slice(0, 12).reverse();
    const labels = sliced.map((x) => x.month);
    const income = sliced.map((x) => Number(x.income || 0));
    const expense = sliced.map((x) => Number(x.expense || 0));
    const balance = sliced.map((x) =>
      Number(x.balance || Number(x.income || 0) - Number(x.expense || 0))
    );

    const rupiah = (n) => {
      try {
        return "Rp " + Number(n).toLocaleString("id-ID");
      } catch {
        return "Rp " + n;
      }
    };

    new Chart(canvas, {
      type: "line",
      data: {
        labels,
        datasets: [
          { label: "Pemasukan", data: income, tension: 0.3 },
          { label: "Pengeluaran", data: expense, tension: 0.3 },
          { label: "Saldo Akhir", data: balance, tension: 0.3 },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: "index", intersect: false },
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
})();
