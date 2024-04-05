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
                <strong>Email: </strong>{{ $user->email }}
                @if($user->hasVerifiedEmail())
                    <span class="badge text-bg-success">Verified email</span>
                @else
                    <span class="badge text-bg-danger">Not verified email</span>
                @endif
            </p>
            <p>
                <strong>Role: </strong><span class="badge text-bg-success">{{ ucfirst($user->roles()->first()->name) }}</span>
            </p>
        </div>
    </div>
@endsection
