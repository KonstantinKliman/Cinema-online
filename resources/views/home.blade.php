@extends('layouts.main')

@section('title', 'Cinema-online')

@section('main')
    <div class="d-flex justify-content-center my-3">
        <a href="{{ route('create-movie-form.page') }}" class="btn btn-outline-light">Add movie</a>
    </div>
@endsection
