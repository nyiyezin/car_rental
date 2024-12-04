@extends('layouts.app')

@section('content')
    <div class="authentication">
        <div class="authentication__form">
            <form action="{{ route('sessionStore') }}" method="POST">
                @csrf
                <h1 class="h3 fw-normal mb-3">Please sign in</h1>

                <div class="mb-3">
                    <x-form.input name="email" type="email" label="Email" />
                </div>

                <div class="mb-3">
                    <x-form.input name="password" type="password" label="Password" />
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <div></div>
                    <a class="link-item" href="{{ route('registerCreate') }}">
                        Create New Account?
                    </a>
                </div>

                <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
            </form>
        </div>
    </div>
@endsection
