@extends('layouts.dashboard')

@section('title', 'Cinema-online dashboard dashboard')

@section('main')
    <div class="row h-100">
        <div class="col d-flex justify-content-center align-items-center flex-column">
            <h1>Hello, {{\Illuminate\Support\Facades\Request::user()->name}}!</h1>
            <p>Welcome to dashboard</p>
        </div>
    </div>
@endsection
