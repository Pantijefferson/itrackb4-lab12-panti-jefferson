@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
    <h2 class="mb-3">Page not found</h2>
    <p>The page you are looking for could not be found.</p>
    <a href="{{ route('comics.index') }}">Back to the list</a>
@endsection