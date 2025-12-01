@extends('layouts.public')

@section('P')
    <div class="container mx-auto px-4 py-10 prose max-w-none">
    <h1 class="text-3xl font-bold mb-4">{{ $data->title }}</h1>

    <div class="prose max-w-none">
        {!! $data->content !!}
    </div>
@endsection