<footer class="footer">
    <div class="footer-inner">
        <div class="footer-grid">

            <!-- PROFIL -->
            <div class="footer-item">
                <h3>{{ $setting->site_name ?? 'KDMP Wonokerto' }}</h3>

                @if(!empty($setting->address))
                    <p>{{ $setting->address }}</p>
                @endif

                @if(!empty($setting->footer_description))
                    <p>{{ $setting->footer_description }}</p>
                @endif
            </div>

            <!-- KONTAK -->
            <div class="footer-item">
                <h4>Kontak</h4>
                <ul class="footer-contact">
                    <li>
                        📞
                        @if(!empty($setting->phone))
                            <a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a>
                        @else
                            <span>-</span>
                        @endif
                    </li>

                    <li>
                        ✉️
                        @if(!empty($setting->email))
                            <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>
                        @else
                            <span>-</span>
                        @endif
                    </li>
                </ul>
            </div>

            <!-- MAPS (kecil) -->
            <!-- MAPS (kecil) -->
            <div class="footer-item footer-map">
                @if(!empty($setting->gmaps_embed_src))
                    <iframe
                        src="{{ $setting->gmaps_embed_src }}"
                        width="100%"
                        height="180"
                        style="border:0; border-radius:10px;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                @else
                    <p>Lokasi belum tersedia</p>
                @endif
            </div>

        </div>

        <small>
            © {{ date('Y') }} {{ $setting->site_name ?? 'KDMP Wonokerto' }}. @nr-01.26 . All rights reserved.
        </small>
    </div>
</footer>
