@extends('layouts.main')

@section('title', 'Confirm your email')

@section('main')
    <div class="row h-100">
        <div class="col d-flex justify-content-center align-items-center flex-column">
            <p>Confirm your email</p>

            <a class="link" href="{{ route('verification.send') }}" onclick="event.preventDefault(); document.getElementById('verification-form').submit();">
                Click here to send verification link.
            </a>

            <form id="verification-form" method="POST" action="{{ route('verification.send') }}" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
@endsection
