{{-- Toast Notification --}}
@if (session('success') || session('error') || session('warning') || session('info'))
    <div class="toast-container" id="toastContainer">
        @if (session('success'))
            <div class="toast toast--success" role="alert" aria-live="polite">
                <span class="toast__icon">✓</span>
                <span class="toast__message">{{ session('success') }}</span>
                <button type="button" class="toast__close" onclick="this.parentElement.remove()" aria-label="Tutup">×</button>
            </div>
        @endif

        @if (session('error'))
            <div class="toast toast--error" role="alert" aria-live="assertive">
                <span class="toast__icon">✕</span>
                <span class="toast__message">{{ session('error') }}</span>
                <button type="button" class="toast__close" onclick="this.parentElement.remove()" aria-label="Tutup">×</button>
            </div>
        @endif

        @if (session('warning'))
            <div class="toast toast--warning" role="alert" aria-live="polite">
                <span class="toast__icon">⚠</span>
                <span class="toast__message">{{ session('warning') }}</span>
                <button type="button" class="toast__close" onclick="this.parentElement.remove()" aria-label="Tutup">×</button>
            </div>
        @endif

        @if (session('info'))
            <div class="toast toast--info" role="alert" aria-live="polite">
                <span class="toast__icon">ℹ</span>
                <span class="toast__message">{{ session('info') }}</span>
                <button type="button" class="toast__close" onclick="this.parentElement.remove()" aria-label="Tutup">×</button>
            </div>
        @endif
    </div>

    <script>
        (function() {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(function(toast) {
                setTimeout(function() {
                    toast.classList.add('toast--fade-out');
                    setTimeout(function() {
                        toast.remove();
                    }, 300);
                }, 5000);
            });
        })();
    </script>
@endif

