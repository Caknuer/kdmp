<x-filament::section>
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-500 via-rose-600 to-red-700 text-white shadow-2xl">
        <!-- Decorative animated elements -->
        <div class="absolute -right-16 -top-16 h-64 w-64 rounded-full bg-white/10 blur-3xl transition-all duration-500"></div>
        <div class="absolute -left-16 -bottom-16 h-64 w-64 rounded-full bg-white/10 blur-3xl transition-all duration-500"></div>
        
        <div class="relative px-8 py-10">
            <!-- Header -->
            <div class="mb-8">
                <div class="mb-3 flex items-center gap-2">
                    <div class="h-2 w-2 rounded-full bg-white/80 animate-pulse"></div>
                    <span class="text-xs font-bold uppercase tracking-widest text-white/75">Dashboard</span>
                </div>
                <div>
                    <h2 class="text-4xl font-bold">{{ $this->getGreeting() }}</h2>
                    <p class="mt-2 text-sm text-white/80">Kelola KDMP Wonokerto Secara Profesional</p>
                </div>
            </div>

            <!-- Info Grid with Icons -->
            <div class="grid grid-cols-3 gap-3">
                <!-- Status Card -->
                <div class="group rounded-xl bg-white/[0.08] p-4 backdrop-blur-md transition-all duration-300 hover:bg-white/[0.12]">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-xs font-semibold uppercase tracking-wider text-white/60">Status</div>
                            <div class="mt-2 flex items-center gap-1">
                                <span class="h-2 w-2 rounded-full bg-green-400 animate-pulse"></span>
                                <span class="text-lg font-bold">Aktif</span>
                            </div>
                        </div>
                        <svg class="h-8 w-8 text-white/40 transition-transform group-hover:scale-110" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                </div>

                <!-- Date Card -->
                <div class="group rounded-xl bg-white/[0.08] p-4 backdrop-blur-md transition-all duration-300 hover:bg-white/[0.12]">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-xs font-semibold uppercase tracking-wider text-white/60">Tanggal</div>
                            <div class="mt-2 text-sm font-bold">{{ $this->getCurrentDate() }}</div>
                        </div>
                        <svg class="h-8 w-8 text-white/40 transition-transform group-hover:scale-110" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                        </svg>
                    </div>
                </div>

                <!-- Time Card -->
                <div class="group rounded-xl bg-white/[0.08] p-4 backdrop-blur-md transition-all duration-300 hover:bg-white/[0.12]">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-xs font-semibold uppercase tracking-wider text-white/60">Jam WIB</div>
                            <div class="mt-2 text-lg font-bold">{{ $this->getCurrentTime() }}</div>
                        </div>
                        <svg class="h-8 w-8 text-white/40 transition-transform group-hover:scale-110" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.2 3.2.8-1.3-5-3V7z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Footer info -->
            <div class="mt-6 border-t border-white/10 pt-4">
                <p class="text-xs text-white/60">
                    💡 <span class="ml-1">Gunakan menu navigasi untuk mengelola data KDMP Wonokerto. Untuk bantuan, hubungi administrator.</span>
                </p>
            </div>
        </div>
    </div>
</x-filament::section>
