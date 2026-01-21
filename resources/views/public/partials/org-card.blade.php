<div class="org-card"
     data-name="{{ e($item->name) }}"
     data-role="{{ e($item->role) }}"
     data-bio="{{ e($item->bio) }}"
     data-photo="{{ $item->photo_url }}">

    <img src="{{ $item->photo_url }}" alt="{{ $item->name }}">

    <h3>{{ $item->name }}</h3>
    <span>{{ $item->role }}</span>
</div>
