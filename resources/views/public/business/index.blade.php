@extends('layouts.public')

@section('P')
    <h1 class="text-2xl font-bold mb-4">Daftar Unit Bisnis</h1>

    @foreach ($units as $unit)
        <div class="border p-4 mb-4 rounded">
            <h2 class="text-xl font-bold">{{ $unit->name }}</h2>
            <p>{{ $unit->description }}</p>

            <a href="{{ url('/unit-bisnis/' . $unit->slug) }}" class="text-blue-500">Lihat detail</a>
        </div>
    @endforeach
@endsection
