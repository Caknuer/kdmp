@extends('layouts.public')

@section('content')

@include('public.partials.hero')

<!-- STATISTIK & HIGHLIGHT -->
<section class="section section--soft section--stats reveal">
    <div class="container">
        <div class="home-head">
            <div>
                <h2 class="home-title">Statistik & Highlight</h2>
                <p class="home-subtitle">Ikhtisar kinerja, jumlah anggota terdaftar, dan perkembangan KDMP secara transparan.</p>
            </div>
        </div>

        @php
            $latestCount = $latestInfo->count();
            $statItems = [
                [
                    'label' => 'Anggota Terdaftar',
                    'value' => number_format($memberStats['total'] ?? 0, 0, ',', '.') . ' Orang',
                    'note' => ($memberStats['active'] ?? 0) . ' terverifikasi aktif',
                    'tone' => 'primary'
                ],
                [
                    'label' => 'Total Mitra',
                    'value' => number_format($partnerCount ?? 0, 0, ',', '.') . ' Mitra',
                    'note' => 'Mitra bisnis KDMP',
                    'tone' => 'accent'
                ],
                [
                    'label' => 'Total Unit Usaha',
                    'value' => number_format($businessUnitCount ?? 0, 0, ',', '.') . ' Unit',
                    'note' => 'Unit usaha desa',
                    'tone' => 'accent'
                ],
                [
                    'label' => 'Publikasi Informasi',
                    'value' => number_format($latestCount, 0, ',', '.') . ' Berita',
                    'note' => 'Berita & pengumuman',
                    'tone' => 'muted'
                ],
            ];
        @endphp

        <div class="stat-grid">
            @foreach ($statItems as $item)
                <article class="stat-card stat-card--{{ $item['tone'] }}">
                    <span class="stat-label">{{ $item['label'] }}</span>
                    <strong class="stat-value">{{ $item['value'] }}</strong>
                    <small class="stat-note">{{ $item['note'] }}</small>
                </article>
            @endforeach
        </div>
    </div>
</section>

<!-- PRICELIST & DAFTAR ANGGOTA KEANGGOTAAN KDMP -->
<section class="section section--membership reveal">
    <div class="container">
        {{-- <div class="home-head home-head--center">
            <span class="badge-pill">🏷️ Struktur & Kategori Keanggotaan</span>
            <h2 class="home-title">Kategori & Hak Keanggotaan KDMP</h2>
            <p class="home-subtitle">Klasifikasi keanggotaan warga Koperasi Desa Merah Putih Wonokerto. Seluruh data anggota terdata dan dikelola langsung oleh admin koperasi.</p>
        </div>

        <!-- PRICELIST / TIER CARDS -->
        <div class="pricing-grid">
            <!-- TIER 1: PLATINUM -->
            <div class="pricing-card">
                <div class="pricing-header">
                    <div class="pricing-badge">🏆 Khusus Menabung</div>
                    <h3 class="pricing-name">Anggota Platinum</h3>
                    <p class="pricing-desc">Kategori keanggotaan bagi warga yang fokus menabung dan memanfaatkan transaksi simpan pinjam.</p>
                    <div class="pricing-price">
                        <span class="price-val">Bebas Biaya Masuk</span>
                        <span class="price-sub">Setoran awal simpanan fleksibel</span>
                    </div>
                </div>

                <div class="pricing-features">
                    <ul>
                        <li><span class="check-icon">✓</span> <strong>Layanan Tabungan & Simpan Pinjam</strong></li>
                        <li><span class="check-icon">✓</span> <strong>Pengelolaan Akun Terpadu</strong> oleh admin</li>
                        <li><span class="check-icon">✓</span> <strong>Catatan Transaksi Transparan</strong> dan akurat</li>
                        <li><span class="check-icon">✓</span> Kemudahan akses simpanan kapan saja</li>
                    </ul>
                </div>

                <div class="pricing-footer">
                    <div class="tier-info-badge">
                        <i class="fas fa-check-circle"></i> Terdaftar: {{ $memberStats['platinum'] ?? 0 }} Warga
                    </div>
                </div>
            </div>

            <!-- TIER 2: PREMIUM -->
            <div class="pricing-card pricing-card--featured">
                <div class="featured-ribbon">⭐ Anggota Resmi Penuh</div>
                <div class="pricing-header">
                    <div class="pricing-badge pricing-badge--gold">💎 Anggota Penuh</div>
                    <h3 class="pricing-name">Anggota Premium</h3>
                    <p class="pricing-desc">Keanggotaan resmi penuh dengan hak bagi hasil SHU tahunan dan partisipasi aktif koperasi.</p>
                    <div class="pricing-price">
                        <span class="price-val">Simpanan Pokok & Wajib</span>
                        <span class="price-sub">Investasi modal bersama koperasi desa</span>
                    </div>
                </div>

                <div class="pricing-features">
                    <ul>
                        <li><span class="check-icon">✓</span> <strong>Semua Fasilitas Anggota Platinum</strong></li>
                        <li><span class="check-icon">✓</span> <strong>Hak Bagi Hasil Sisa Hasil Usaha (SHU)</strong> tiap tahun</li>
                        <li><span class="check-icon">✓</span> <strong>Hak Suara Penuh</strong> dalam Rapat Anggota Tahunan (RAT)</li>
                        <li><span class="check-icon">✓</span> Prioritas permodalan usaha UMKM & program desa</li>
                        <li><span class="check-icon">✓</span> Terdaftar resmi dengan identitas keanggotaan KDMP</li>
                    </ul>
                </div>

                <div class="pricing-footer">
                    <div class="tier-info-badge tier-info-badge--gold">
                        <i class="fas fa-check-circle"></i> Terdaftar: {{ $memberStats['premium'] ?? 0 }} Warga
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- DAFTAR ANGGOTA TERDAFTAR (LIVE TRANSPARANSI) -->
        <div class="member-roster-box">
            <div class="member-roster-head">
                <div>
                    <h3 class="roster-title">
                        <span class="roster-icon">👥</span> Transparansi Data Anggota Terdaftar
                    </h3>
                    <p class="roster-subtitle">Rekap data anggota resmi yang tercatat dalam sistem administrasi Koperasi Desa Merah Putih.</p>
                </div>
                <div class="roster-stat-pills">
                    <span class="pill pill--total">Total: <strong>{{ $memberStats['total'] ?? 0 }}</strong> Anggota</span>
                    <span class="pill pill--active">Aktif: <strong>{{ $memberStats['active'] ?? 0 }}</strong></span>
                    <span class="pill pill--platinum">Platinum: <strong>{{ $memberStats['platinum'] ?? 0 }}</strong></span>
                    <span class="pill pill--premium">Premium: <strong>{{ $memberStats['premium'] ?? 0 }}</strong></span>
                </div>
            </div>

            <!-- TABEL / LIST DAFTAR ANGGOTA -->
            <div class="table-responsive">
                <table class="roster-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Anggota</th>
                            <th>Nama Anggota</th>
                            <th>Tipe Keanggotaan</th>
                            <th>Status</th>
                            <th>Tanggal Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentMembers as $index => $m)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="member-code-tag">
                                    {{ $m->code ? substr($m->code, 0, 4) . '****' . substr($m->code, -2) : 'KDMP-'.$m->id }}
                                </span>
                            </td>
                            <td>
                                <div class="member-profile-cell">
                                    <div class="member-avatar">
                                        {{ strtoupper(substr($m->name, 0, 1)) }}
                                    </div>
                                    <span class="member-name">{{ $m->name }}</span>
                                </div>
                            </td>
                            <td>
                                @if(!empty($m->role) && strtolower($m->role) === 'platinum')
                                    <span class="badge badge--platinum">🏆 Platinum</span>
                                @elseif(!empty($m->role) && strtolower($m->role) === 'premium')
                                    <span class="badge badge--premium">💎 Premium</span>
                                @else
                                    <span class="badge badge--general">{{ ucfirst($m->role ?? 'Anggota') }}</span>
                                @endif
                            </td>
                            <td>
                                @if(($m->status ?? '') === 'approved')
                                    <span class="badge badge--success">✓ Terverifikasi Aktif</span>
                                @elseif(($m->status ?? '') === 'pending')
                                    <span class="badge badge--warning">⏳ Proses Admin</span>
                                @else
                                    <span class="badge badge--muted">{{ ucfirst($m->status ?? 'Aktif') }}</span>
                                @endif
                            </td>
                            <td class="text-muted">
                                {{ !empty($m->registered_at) ? $m->registered_at->format('d M Y') : (!empty($m->created_at) ? $m->created_at->format('d M Y') : '-') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <p style="margin: 0;">Data anggota sedang dimutakhirkan oleh admin koperasi.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="roster-footer">
                <div class="roster-footer-info">
                    <span>💡 Seluruh pendaftaran dan pemutakhiran data anggota dikelola secara resmi oleh Pengurus & Admin KDMP Wonokerto.</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- INFORMASI TERBARU -->
<section class="section section--soft reveal">
    <div class="container">

        <div class="home-head">
            <div>
                <h2 class="home-title">Informasi Terbaru</h2>
                <p class="home-subtitle">Berita & pengumuman terbaru dari {{ $setting->site_name ?? 'KDMP Wonokerto' }}.</p>
            </div>

            <a href="{{ url('/informasi') }}" class="btn btn--primary">
                Lihat semua
            </a>
        </div>

        <div class="info-grid">
            @forelse ($latestInfo as $article)
                @php
                    $base = $article->type === 'pengumuman' ? 'pengumuman' : 'berita';
                @endphp

                <a href="{{ url('/'.$base.'/'.$article->slug) }}" class="info-card">
                    <div class="info-thumb">
                        @if ($article->thumbnail)
                            <img src="{{ asset('storage/'.$article->thumbnail) }}" alt="{{ $article->title }}">
                        @else
                            <div class="info-thumb-placeholder">
                                {{ strtoupper(substr($article->title,0,1)) }}
                            </div>
                        @endif
                    </div>

                    <div class="info-body">
                        <div class="info-meta">
                            <span class="info-tag {{ $article->type === 'pengumuman' ? 'is-ann' : 'is-news' }}">
                                {{ $article->type === 'pengumuman' ? 'Pengumuman' : 'Berita' }}
                            </span>
                            <span class="info-date">{{ $article->display_date->format('d M Y') }}</span>
                        </div>

                        <h3 class="info-title">{{ $article->title }}</h3>
                        <p class="info-excerpt">
                            {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 110) }}
                        </p>

                        <span class="info-cta">Baca selengkapnya →</span>
                    </div>
                </a>
            @empty
                <div class="info-empty">
                    <h3>Belum ada informasi</h3>
                    <p>Informasi terbaru akan tampil di sini setelah dipublikasikan.</p>
                    <a class="btn btn--primary" href="{{ url('/informasi') }}">Buka halaman Informasi</a>
                </div>
            @endforelse
        </div>

    </div>
</section>

@push('styles')
<style>
/* ===================================================
   MEMBERSHIP & PRICELIST SECTION STYLES
=================================================== */
.section--membership {
    padding: 70px 0;
    background: linear-gradient(180deg, #fcfaf8 0%, #f4eee7 100%);
}

.home-head--center {
    text-align: center;
    max-width: 680px;
    margin: 0 auto 48px auto;
}

.badge-pill {
    display: inline-block;
    padding: 6px 16px;
    font-size: 13px;
    font-weight: 700;
    color: #991b1b;
    background: #fee2e2;
    border-radius: 9999px;
    margin-bottom: 12px;
    letter-spacing: 0.02em;
}

/* Pricing Grid */
.pricing-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
}

.pricing-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 20px;
    padding: 36px 30px;
    display: flex;
    flex-direction: column;
    position: relative;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.pricing-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
}

.pricing-card--featured {
    border: 2px solid #b91c1c;
    background: #ffffff;
    box-shadow: 0 15px 45px rgba(185, 28, 28, 0.12);
}

.featured-ribbon {
    position: absolute;
    top: -14px;
    right: 28px;
    background: linear-gradient(135deg, #b91c1c, #991b1b);
    color: #ffffff;
    font-size: 12px;
    font-weight: 800;
    padding: 4px 14px;
    border-radius: 9999px;
    box-shadow: 0 4px 12px rgba(185, 28, 28, 0.3);
}

.pricing-badge {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    color: #1e40af;
    background: #dbeafe;
    padding: 4px 12px;
    border-radius: 8px;
    margin-bottom: 12px;
}

.pricing-badge--gold {
    color: #92400e;
    background: #fef3c7;
}

.pricing-name {
    font-size: 24px;
    font-weight: 800;
    color: #111827;
    margin-bottom: 8px;
}

.pricing-desc {
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 20px;
    line-height: 1.5;
}

.pricing-price {
    padding: 16px 0;
    border-top: 1px dashed #e5e7eb;
    border-bottom: 1px dashed #e5e7eb;
    margin-bottom: 24px;
}

.price-val {
    display: block;
    font-size: 22px;
    font-weight: 800;
    color: #b91c1c;
}

.price-sub {
    font-size: 12px;
    color: #6b7280;
    font-weight: 500;
}

.pricing-features {
    flex: 1;
    margin-bottom: 20px;
}

.pricing-features ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.pricing-features li {
    font-size: 14px;
    color: #374151;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    line-height: 1.4;
}

.check-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #dcfce7;
    color: #166534;
    font-size: 11px;
    font-weight: 800;
    flex-shrink: 0;
    margin-top: 2px;
}

.tier-info-badge {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
    padding: 10px 16px;
    border-radius: 10px;
    text-align: center;
    font-size: 13px;
    font-weight: 700;
}

.tier-info-badge--gold {
    background: #fefce8;
    border-color: #fef08a;
    color: #854d0e;
}

/* ROSTER / DAFTAR ANGGOTA BOX */
.member-roster-box {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.member-roster-head {
    padding: 24px 30px;
    background: #ffffff;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.roster-title {
    font-size: 18px;
    font-weight: 800;
    color: #111827;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.roster-subtitle {
    font-size: 13px;
    color: #6b7280;
}

.roster-stat-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.pill {
    display: inline-block;
    padding: 4px 12px;
    font-size: 12px;
    border-radius: 9999px;
    font-weight: 600;
}

.pill--total { background: #f3f4f6; color: #1f2937; }
.pill--active { background: #dcfce7; color: #166534; }
.pill--platinum { background: #dbeafe; color: #1e40af; }
.pill--premium { background: #fef3c7; color: #92400e; }

.table-responsive {
    width: 100%;
    overflow-x: auto;
}

.roster-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
    text-align: left;
}

.roster-table th {
    background: #f9fafb;
    color: #4b5563;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 14px 20px;
    border-bottom: 1px solid #e5e7eb;
}

.roster-table td {
    padding: 14px 20px;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}

.roster-table tr:hover {
    background: #fafafa;
}

.member-code-tag {
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    font-weight: 600;
    color: #4b5563;
    background: #f3f4f6;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 12px;
}

.member-profile-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}

.member-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #fee2e2;
    color: #991b1b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 13px;
    flex-shrink: 0;
}

.member-name {
    font-weight: 600;
    color: #111827;
}

.badge {
    display: inline-block;
    padding: 4px 10px;
    font-size: 11px;
    font-weight: 700;
    border-radius: 6px;
}

.badge--platinum { background: #dbeafe; color: #1e40af; }
.badge--premium { background: #fef3c7; color: #92400e; }
.badge--general { background: #f3f4f6; color: #374151; }
.badge--success { background: #dcfce7; color: #15803d; }
.badge--warning { background: #fef9c3; color: #854d0e; }
.badge--muted { background: #f3f4f6; color: #6b7280; }

.roster-footer {
    padding: 18px 24px;
    background: #fafafa;
    border-top: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    font-size: 13px;
    color: #6b7280;
}

@media (max-width: 768px) {
    .pricing-grid {
        grid-template-columns: 1fr;
    }
    .member-roster-head {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
@endpush

@endsection
