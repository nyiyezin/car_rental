@extends('layouts.app')

@section('authentication')
    <form action="{{ route('sessionStore') }}" method="POST">
        @csrf
        <h1 class="h3 fw-normal mb-3">Please sign in</h1>

        <div class="mb-3">
            <x-form.input name="email" label="Email" type="email" />
        </div>

        <div class="mb-3">
            <x-form.input name="password" label="Password" type="password" />
        </div>

        <div class="mb-3">
            <x-form.checkbox name="remember_me" label="Remember Me" />
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
    </form>
@endsection
