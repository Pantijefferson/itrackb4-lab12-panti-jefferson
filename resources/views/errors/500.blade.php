@extends('layouts.app')

@section('title', 'Internal Server Error')

@section('content')
    <h2 class="mb-3">Internal Server Error</h2>
    <p>An error occurred while processing your request.</p>
    <a href="{{ route('comics.index') }}">Back to the list</a>
@endsection