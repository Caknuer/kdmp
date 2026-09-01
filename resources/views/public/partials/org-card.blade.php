@php
    $photoP = $item->photo_url;
    $name = $item->name_p ?? '-';
    $role = $item->role ?? '';
    $bio  = $item->bio ?? '';

    // SAFE: tanpa mbstring (biar ga 500)
    $initial = strtoupper(substr($name, 0, 1));
@endphp

<div class="org-card"
     role="button"
     tabindex="0"
     aria-label="Buka detail {{ $name }}"
     data-name="{{ e($name) }}"
     data-role="{{ e($role) }}"
     data-bio="{{ e($bio) }}"
     data-photo="{{ $photoP }}"
     data-initial="{{ e($initial) }}">

    @if(!empty($photoP))
        <img
            src="{{ $photoP }}"
            alt="{{ e($name) }}"
            class="org-photo"
            loading="lazy"
            onerror="this.style.display='none'; this.parentElement.querySelector('.org-photo-placeholder').style.display='grid';"
        >
        <div class="org-photo-placeholder" style="display:none;">
            {{ $initial }}
        </div>
    @else
        <div class="org-photo-placeholder"
             style="background: #e5e7eb; color: #6b7280; display: grid; place-items: center;">
            {{ $initial }}
        </div>
    @endif

    <div class="org-meta">
        <h3>{{ $name }}</h3>
        <span>{{ $role }}</span>
    </div>
</div>
