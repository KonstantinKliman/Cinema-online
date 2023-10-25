@extends('layouts.main')

@section('title', 'Cinema-online')

@section('main')
    <div>
        Home page, {{ auth()->user()->name }}
    </div>
@endsection
