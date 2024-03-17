@extends('layouts.admin')

@section('title', $user->name . ' user page')

@section('main')
    <div class="row d-flex flex-column border rounded-3 p-3 mx-1 my-3 bg-light-subtle">
        <div class="col">
            <x-header>
                {{ $user->name . ' user page' }}
            </x-header>
        </div>
        <div class="col">
            <p>
                <strong>Name: </strong>{{ $user->name }}
            </p>
            <p>
                <strong>Email: </strong>
                <span class="{{ $user->hasVerifiedEmail() ? 'text-success' : 'text-danger' }}">{{ $user->email }}</span>
            </p>
            <p>
                <strong>Role:</strong>
                @foreach($roles as $index => $role)
                    @if($index == $user->role)
                        <span>{{ $role }}</span>
                    @endif
                @endforeach
            </p>
        </div>
    </div>
@endsection
