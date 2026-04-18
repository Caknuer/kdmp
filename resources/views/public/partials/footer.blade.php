<footer class="footer">
    <div class="footer-inner">
        <div class="footer-grid">

            <!-- PROFIL -->
            <div class="footer-item">
                <h3>{{ $setting->site_name ?? 'KDMP Wonokerto' }}</h3>

                @if(!empty($setting->address))
                    <p>{{ $setting->address }}</p>
                @else
                    <p>Alamat belum diatur. Silakan tambahkan di admin panel.</p>
                @endif

                @if(!empty($setting->footer_description))
                    <p>{{ $setting->footer_description }}</p>
                @else
                    <p>KDMP Wonokerto hadir untuk mendukung pertumbuhan ekonomi desa secara transparan dan profesional.</p>
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

                    <li>
                        💬
                        @if(!empty($setting->whatsapp))
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $setting->whatsapp) }}" target="_blank" rel="noopener noreferrer">
                                {{ $setting->whatsapp }}
                            </a>
                        @else
                            <span>-</span>
                        @endif
                    </li>
                </ul>
            </div>

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
                    <div class="footer-placeholder">
                        <h5>Lokasi belum tersedia</h5>
                        <p>Informasi lokasi akan ditambahkan oleh admin.</p>
                    </div>
                @endif
            </div>

            <!-- SOSIAL MEDIA -->
            <div class="footer-item footer-socials">
                <h4>Sosial Media</h4>
                @php
                    $socials = [
                        'facebook' => $setting->facebook ?? null,
                        'instagram' => $setting->instagram ?? null,
                        'twitter' => $setting->twitter ?? null,
                        'youtube' => $setting->youtube ?? null,
                    ];
                @endphp

                @if(collect($socials)->filter()->isNotEmpty())
                    <ul class="footer-social-list">
                        @foreach($socials as $network => $url)
                            @if(!empty($url))
                                <li>
                                    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer">
                                        @if($network === 'facebook') 📘 @endif
                                        @if($network === 'instagram') 📸 @endif
                                        @if($network === 'twitter') 🐦 @endif
                                        @if($network === 'youtube') ▶️ @endif
                                        {{ ucfirst($network) }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <div class="footer-placeholder">
                        <h5>Informasi sosial belum tersedia</h5>
                        <p>Lengkapi profil sosial media di panel admin untuk tampilan yang lebih lengkap.</p>
                    </div>
                @endif
            </div>

        </div>

        <small>
            © {{ date('Y') }} {{ $setting->site_name ?? 'KDMP Wonokerto' }}. @nr-01.26 . All rights reserved.
        </small>
    </div>
</footer>
