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

    // Hero Images (multiple for slideshow)
    $heroImagesJson = setting('hero_images');
    $heroImages = $heroImagesJson ? (is_array($heroImagesJson) ? $heroImagesJson : json_decode($heroImagesJson, true) ?? []) : [];

    $heroImageUrls = [];
    foreach ($heroImages as $image) {
        if ($image) {
            $heroImageUrls[] = asset('storage/' . ltrim($image, '/'));
        }
    }
@endphp

<style>
/* Hero Slideshow Animation */
.hero-slideshow {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.hero-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0;
    transition: opacity 1s ease-in-out;
    animation: heroSlideshow 16s infinite;
}

.hero-slide.active {
    opacity: 1;
}

@keyframes heroSlideshow {
    0%, 20% { opacity: 1; }
    25%, 100% { opacity: 0; }
}

.hero-slide:nth-child(1) { animation-delay: 0s; }
.hero-slide:nth-child(2) { animation-delay: 4s; }
.hero-slide:nth-child(3) { animation-delay: 8s; }
.hero-slide:nth-child(4) { animation-delay: 12s; }
.hero-slide:nth-child(5) { animation-delay: 16s; }
</style>

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
                <a href="/transparansi" class="btn-primary">
                    Lihat Transparansi
                </a>

                <a href="/informasi" class="btn-secondary">
                    Informasi
                </a>
            </div>
        </div>


        <div class="hero-visual">
            @if (!empty($heroImageUrls))
                <div class="hero-slideshow">
                    @foreach($heroImageUrls as $index => $imageUrl)
                        <img
                            src="{{ $imageUrl }}"
                            alt="Hero KDMP {{ $index + 1 }}"
                            loading="lazy"
                            class="hero-slide {{ $index === 0 ? 'active' : '' }}"
                            style="animation-delay: {{ $index * 4 }}s"
                        >
                    @endforeach
                </div>
            @else
                <div class="hero-placeholder">
                    <span>Foto belum tersedia</span>
                </div>
            @endif
        </div>

    </div>
</section>
