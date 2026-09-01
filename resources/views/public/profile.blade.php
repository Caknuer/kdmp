@extends('layouts.public')

@section('content')
    <div class="container section">
        <h1 class="page-title">{{ $data->title }}</h1>
        <div class="content-body">{!! $data->content !!}</div>
    </div>
@endsection