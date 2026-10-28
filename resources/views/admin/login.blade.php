
@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
    <div class="card" style="max-width: 460px; margin: 40px auto;">
        <h1>Login Admin</h1>
        <p class="muted">Masuk untuk mengelola pesanan restoran.</p>

        @if ($errors->any())
            <div class="notice" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div style="margin-bottom: 16px;">
                <label for="email">Email admin</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    autocomplete="username"
                    required
                    autofocus
                    style="width: 100%; padding: 10px;"
                >
            </div>

            <div style="margin-bottom: 16px;">
                <label for="password">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    autocomplete="current-password"
                    required
                    style="width: 100%; padding: 10px;"
                >
            </div>

            <button class="button" type="submit">Masuk</button>
        </form>
    </div>
@endsection
