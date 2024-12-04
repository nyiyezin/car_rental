@extends('layouts.app')

@section('content')
    <div class="authentication">
        <div class="authentication__form">
            <form action="{{ route('registerStore') }}" method="POST">
                @csrf
                <h1 class="h3 fw-normal mb-3">Please sign up</h1>

                <input name="role_id" type="hidden" value="2">

                <div class="mb-3">
                    <x-form.input name="name" label="Name" />
                </div>

                <div class="mb-3">
                    <x-form.input name="username" label="Username" />
                </div>

                <div class="mb-3">
                    <x-form.input name="email" type="email" label="Email" />
                </div>

                <div class="mb-3">
                    <x-form.input name="password" type="password" label="Password" />
                </div>

                <button class="btn btn-primary w-100 py-2" type="submit">Register</button>
            </form>
        </div>
    </div>
@endsection
