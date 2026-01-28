<section class="hero">
    <div class="hero-container">
        <div class="hero-content">
            <span class="hero-badge">KDMP • Transparan • Profesional</span>

            <h1>
                Membangun Desa <br>
                <span>Mandiri & Berdaya</span>
            </h1>

            <p>
                KDMP berkomitmen mengelola potensi desa secara transparan,
                profesional, dan berkelanjutan demi kesejahteraan bersama.
            </p>

            <div class="hero-actions">
                {{-- ✅ Daftar Anggota --}}
                <a href="{{ route('member.register') }}" class="btn-primary">
                    Daftar Anggota
                </a>

                {{-- ✅ Cek Saldo --}}
                <a href="{{ route('member.balance.form') }}" class="btn-secondary">
                    Cek Saldo
                </a>
            </div>
        </div>

        <div class="hero-visual">
            <img src="{{ asset('images/bupati.jpeg') }}" alt="Kegiatan KDMP Wonokerto">
        </div>
    </div>
</section>
