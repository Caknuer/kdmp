@php
    // =========================
    // HERO DEFAULT / DUMMY DATA
    // =========================

    $heroBadge = setting('hero_badge') ?: 'KDMP • Transparan • Profesional';

    $heroTitle = setting('hero_title') ?: 'Membangun Desa';

    $heroSubtitle = setting('hero_subtitle') ?: 'Mandiri & Berdaya';

    $heroDesc = setting('hero_description') ?: '
        KDMP berkomitmen mengelola potensi desa secara transparan,
        profesional, dan berkelanjutan demi kesejahteraan bersama.
    ';

    // Hero Image Dummy
    $heroImagePath = setting('hero_image');

    $heroImageUrl = $heroImagePath
        ? asset('storage/' . ltrim($heroImagePath, '/'))
        : asset('images/bupati.jpeg'); // fallback dummy
@endphp


<section class="hero">
    <div class="hero-container">

        <div class="hero-content">
            <span class="hero-badge">
                {{ $heroBadge }}
            </span>

            <h1>
                {{ $heroTitle }} <br>
                <span>{{ $heroSubtitle }}</span>
            </h1>

            <p>
                {{ $heroDesc }}
            </p>

            <div class="hero-actions">
                <a href="{{ route('member.register') }}" class="btn-primary">
                    Daftar Anggota
                </a>

                <a href="{{ route('member.balance.form') }}" class="btn-secondary">
                    Cek Saldo
                </a>
            </div>
        </div>


        <div class="hero-visual">
            <img
                src="{{ $heroImageUrl }}"
                alt="Hero KDMP"
                loading="lazy"
                onerror="this.onerror=null;this.src='public/images/bupati.jpeg';"
            >
        </div>

    </div>
</section>
