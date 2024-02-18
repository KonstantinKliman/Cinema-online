@extends('layouts.main')

@section('title', 'Confirm your email')

@section('main')
    <p>Confirm your email</p>

    <a href="{{ route('verification.send') }}" onclick="event.preventDefault(); document.getElementById('verification-form').submit();">
        Отправить ссылку для подтверждения
    </a>

    <form id="verification-form" method="POST" action="{{ route('verification.send') }}" style="display: none;">
        @csrf
    </form>

@endsection
