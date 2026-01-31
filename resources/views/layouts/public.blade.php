<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ setting('site_name') }}</title>

    <!-- Load CSS Manual -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>

    @include('public.partials.navbar')

    <main>
      <section class="section">
          <div class="container">
              @yield('P')
          </div>
      </section>
  </main>

    @include('public.partials.footer')
    
    {{-- =========================
   MODAL: Pengurus / Pengawas
    ========================= --}}
    <div class="modal-overlay" id="orgModal" aria-hidden="true">

        <div class="modal">

            {{-- Header --}}
            <div class="modal-head">
                <h3 id="modalName">Detail Pengurus</h3>

                <button class="modal-close" type="button">
                    &times;
                </button>
            </div>

            {{-- Body --}}
            <div class="modal-body">

                <img id="modalPhoto"
                    src=""
                    alt="Foto Pengurus"
                    style="width:110px;height:110px;border-radius:50%;object-fit:cover;margin-bottom:14px;">

                <p id="modalRole"
                style="font-weight:600;margin-bottom:10px;color:#334155;">
                </p>

                <p id="modalBio" class="modal-desc"></p>

            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>