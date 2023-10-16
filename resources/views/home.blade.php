@extends('layouts.main')

@section('title', 'Cinema-online')

@section('main')
    <h1>Welcome to home page, @if(auth()->check()) {{ auth()->user()->name }} @else guest @endif</h1>
@endsection
