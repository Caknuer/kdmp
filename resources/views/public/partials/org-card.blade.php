@php
    $photoUrl = $item->photo ? asset('storage/'.$item->photo) : null;
    $initial = strtoupper(substr($item->name ?? '?', 0, 1));
@endphp

<div class="org-card"
     data-name="{{ e($item->name) }}"
     data-role="{{ e($item->role) }}"
     data-bio="{{ e($item->bio) }}"
     data-photo="{{ $photoUrl }}">

    @if($photoUrl)
        <img src="{{ $photoUrl }}" alt="{{ $item->name }}" class="org-photo">
    @else
        <div class="org-photo-placeholder" style="width: 110px; height: 110px; background: #f1f5f9; border-radius: 50%; color: #324b85; display: grid; place-items: center; font-size: 36px; font-weight: 700; margin: 0 auto 14px; border: 4px solid #f1f1f1;">
            {{ $initial }}
        </div>
    @endif

    <h3>{{ $item->name }}</h3>
    <span>{{ $item->role }}</span>
</div>