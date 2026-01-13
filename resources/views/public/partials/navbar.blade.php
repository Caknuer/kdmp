<header class="navbar">
    <a href="/" class="logo">
        <img src="{{ asset('storage/' . setting('logo')) }}" alt="{{ setting('site_name') }}" class="h-10">
    </a>

    <nav>
        <ul class="menu" id="menu">
            <li><a href="/">Beranda</a></li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle">
                    Profil <span class="arrow">▾</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="/profil/tentang">Tentang</a></li>
                    <li><a href="/profil/pengurus">Pengurus</a></li>
                    <li><a href="/profil/pengawas">Pengawas</a></li>
                    <li><a href="/profil/visi-misi">Visi & Misi</a></li>
                </ul>
            </li>

            <li><a href="/unit-bisnis">Unit Bisnis</a></li>
            <li><a href="/mitra">Mitra</a></li>
            <li><a href="/berita">Berita</a></li>
            <li><a href="/transparansi">Transparansi</a></li>
        </ul>

        <!-- tombol mobile -->
        <button class="menu-toggle" id="menuToggle">☰</button>
    </nav>
</header>
