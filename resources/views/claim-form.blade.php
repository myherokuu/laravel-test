@extends('budi95.layout')
@section('title', 'Claim form')

@section('head')
@endsection

@section('content')
    <h1 class="text-2xl font-bold mb-4">Welcome To Claim</h1>
    <p class="text-gray-700 mb-4">This is sample claim module.</p>
    <a href="{{ url('/submit-claim') }}" class="text-blue-600 hover:underline">Buka laman lain</a>
@endsection
