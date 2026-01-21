@php
    $photo = $item->photo
        ? asset('storage/'.$item->photo)
        : asset('images/avatar.png');
@endphp

<div class="org-card"
     data-name="{{ e($item->name) }}"
     data-role="{{ e($item->role) }}"
     data-bio="{{ e($item->bio) }}"
     data-photo="{{ $photo }}">

    <img src="{{ $photo }}" alt="{{ $item->name }}">
    <h3>{{ $item->name }}</h3>
    <span>{{ $item->role }}</span>
</div>
