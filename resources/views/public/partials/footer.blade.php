<footer class="footer">
    <div class="footer-inner">
        <div class="footer-grid">

            <!-- PROFIL -->
            <div>
                <h3>Koperasi Desa Merah Putih</h3>
                <p>{{ $setting->address ?? '-' }}</p>
            </div>

            <!-- KONTAK -->
            <div>
                <h4>Kontak</h4>
                <ul class="footer-contact">
                    <li>📞 {{ $setting->phone ?? '-' }}</li>
                    <li>✉️ {{ $setting->email ?? '-' }}</li>
                </ul>
            </div>

            <!-- MAPS -->
            <div class="footer-map">
                @if(!empty($setting?->google_maps_embed))
                    {!! $setting->google_maps_embed !!}
                @else
                    <p>Lokasi belum tersedia</p>
                @endif
            </div>

        </div>

        <small>
            © {{ date('Y') }} KDMP Wonokerto. All rights reserved.
        </small>
    </div>
</footer>
