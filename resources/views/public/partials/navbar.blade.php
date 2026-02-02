{{-- resources/views/public/partials/navbar.blade.php --}}
<header class="navbar">
    @php
        // =========================
        // BRANDING (from settings + fallback dummy)
        // =========================
        $siteName  = setting('site_name') ?: 'KDMP WONOKERTO';

        // Disimpan di disk "public", contoh value di DB: "site/logo.png"
        $logoPath  = setting('site_logo');
        $logoUrl   = $logoPath ? asset('storage/' . ltrim($logoPath, '/')) : null;

        // URL beranda (kalau ada route name, silakan ganti)
        $homeUrl   = url('/');
    @endphp

    <div class="nav-container">

        {{-- BRAND: Logo + Nama (klik ke beranda) --}}
        <a href="{{ $homeUrl }}" class="brand" aria-label="Ke Beranda">
            @if ($logoUrl)
                <img
                    src="{{ $logoUrl }}"
                    alt="{{ $siteName }}"
                    class="brand-logo"
                    loading="lazy"
                    onerror="this.onerror=null;this.remove();"
                >
            @endif

            <div class="brand-name logo">
                {{ $siteName }}
            </div>
        </a>

        {{-- TOGGLE (Mobile) --}}
        <button class="nav-toggle" aria-label="Toggle Menu" type="button" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>

        {{-- MENU --}}
        <ul class="nav-menu">
            <li>
                <a href="{{ $homeUrl }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a>
            </li>

            @php $profilActive = request()->is('profil*'); @endphp
            <li class="nav-dropdown {{ $profilActive ? 'open' : '' }}">
                <button
                    class="dropdown-toggle {{ $profilActive ? 'active' : '' }}"
                    type="button"
                    aria-expanded="{{ $profilActive ? 'true' : 'false' }}"
                >
                    Profil <span class="arrow">▾</span>
                </button>

                <ul class="dropdown-menu">
                    <li>
                        <a href="/profil/tentang" class="{{ request()->is('profil/tentang') ? 'active' : '' }}">
                            Tentang
                        </a>
                    </li>
                    <li>
                        <a href="/profil/pengurus" class="{{ request()->is('profil/pengurus') ? 'active' : '' }}">
                            Pengurus
                        </a>
                    </li>
                    <li>
                        <a href="/profil/pengawas" class="{{ request()->is('profil/pengawas') ? 'active' : '' }}">
                            Pengawas
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="/unit-bisnis" class="{{ request()->is('unit-bisnis*') ? 'active' : '' }}">Unit Bisnis</a>
            </li>

            <li>
                <a href="/mitra" class="{{ request()->is('mitra*') ? 'active' : '' }}">Mitra</a>
            </li>

            @php
                $infoActive =
                    request()->is('informasi*') ||
                    request()->is('berita*') ||
                    request()->is('pengumuman*');
            @endphp
            <li class="nav-dropdown {{ $infoActive ? 'open' : '' }}">
                <button
                    class="dropdown-toggle {{ $infoActive ? 'active' : '' }}"
                    type="button"
                    aria-expanded="{{ $infoActive ? 'true' : 'false' }}"
                >
                    Informasi <span class="arrow">▾</span>
                </button>

                <ul class="dropdown-menu">
                    <li>
                        <a href="/informasi" class="{{ request()->is('informasi*') ? 'active' : '' }}">
                            Semua Informasi
                        </a>
                    </li>
                    <li>
                        <a href="/berita" class="{{ request()->is('berita*') ? 'active' : '' }}">
                            Berita
                        </a>
                    </li>
                    <li>
                        <a href="/pengumuman" class="{{ request()->is('pengumuman*') ? 'active' : '' }}">
                            Pengumuman
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="/transparansi" class="{{ request()->is('transparansi*') ? 'active' : '' }}">Transparansi</a>
            </li>
        </ul>
    </div>
</header>