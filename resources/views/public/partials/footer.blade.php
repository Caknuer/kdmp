<footer class="footer">
    <div class="footer-inner">
        <div class="footer-grid">

            <!-- PROFIL -->
            <div class="footer-item">
                <h3>{{ $setting->site_name ?? 'KDMP Wonokerto' }}</h3>
                <p>{{ $setting->address ?? '-' }}</p>
                @if(!empty($setting->footer_description))
                    <p>{{ $setting->footer_description }}</p>
                @endif
            </div>

            <!-- KONTAK -->
            <div class="footer-item">
                <h4>Kontak</h4>
                <ul class="footer-contact">
                    <li>📞 <a href="tel:{{ $setting->phone }}">{{ $setting->phone ?? '-' }}</a></li>
                    <li>✉️ <a href="mailto:{{ $setting->email }}">{{ $setting->email ?? '-' }}</a></li>
                    @if(!empty($setting->website))
                        <li>🌐 <a href="{{ $setting->website }}" target="_blank">{{ $setting->website }}</a></li>
                    @endif
                </ul>
            </div>

            <!-- MAPS -->
            <div class="footer-item footer-map">
                @if(!empty($setting->gmaps))
                    {!! $setting->gmaps !!}
                @else
                    <p>Lokasi belum tersedia</p>
                @endif
            </div>

        </div>

        <small>
            © {{ date('Y') }} {{ $setting->site_name ?? 'KDMP Wonokerto' }}. All rights reserved.
        </small>
    </div>
</footer>
