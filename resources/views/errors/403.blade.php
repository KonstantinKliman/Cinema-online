@extends('layouts.error')

@section('title', '403 error')

@section('main')
    <div class="w-100 vh-100 d-flex justify-content-center align-items-center flex-column">
        <h1 class="pb-3">{{ $exception->getStatusCode() }}</h1>
    </div>
@endsection
