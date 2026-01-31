<header class="navbar">
    <div class="nav-container">
        <div class="logo">KDMP WONOKERTO</div>

        <button class="nav-toggle" aria-label="Toggle Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <ul class="nav-menu">
            <li>
                <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a>
            </li>

            {{-- PROFIL --}}
            @php
                $profilActive = request()->is('profil*');
            @endphp
            <li class="nav-dropdown {{ $profilActive ? 'open' : '' }}">
                <button class="dropdown-toggle" type="button">
                    Profil <span class="arrow">▾</span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="/profil/tentang" class="{{ request()->is('profil/tentang') ? 'active' : '' }}">Tentang</a></li>
                    <li><a href="/profil/pengurus" class="{{ request()->is('profil/pengurus') ? 'active' : '' }}">Pengurus</a></li>
                    <li><a href="/profil/pengawas" class="{{ request()->is('profil/pengawas') ? 'active' : '' }}">Pengawas</a></li>
                </ul>
            </li>

            <li>
                <a href="/unit-bisnis" class="{{ request()->is('unit-bisnis*') ? 'active' : '' }}">Unit Bisnis</a>
            </li>

            <li>
                <a href="/mitra" class="{{ request()->is('mitra*') ? 'active' : '' }}">Mitra</a>
            </li>

            {{-- INFORMASI (baru) --}}
            @php
                $infoActive = request()->is('informasi*') || request()->is('berita*') || request()->is('pengumuman*');
            @endphp
            <li class="nav-dropdown {{ $infoActive ? 'open' : '' }}">
                <button class="dropdown-toggle" type="button">
                    Informasi <span class="arrow">▾</span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="/informasi" class="{{ request()->is('informasi*') ? 'active' : '' }}">Semua Informasi</a></li>
                    <li><a href="/berita" class="{{ request()->is('berita*') ? 'active' : '' }}">Berita</a></li>
                    <li><a href="/pengumuman" class="{{ request()->is('pengumuman*') ? 'active' : '' }}">Pengumuman</a></li>
                </ul>
            </li>

            <li>
                <a href="/transparansi" class="{{ request()->is('transparansi*') ? 'active' : '' }}">Transparansi</a>
            </li>
        </ul>
    </div>
</header>
