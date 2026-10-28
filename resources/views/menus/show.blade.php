@extends('layouts.app')

@section('title', $menu->name)

@section('content')
    <p>
        <a href="{{ route('menus.index') }}">← Kembali ke daftar menu</a>
    </p>

    <article class="card" style="max-width:650px;margin:auto;">
        @if ($menu->image)
            <img
                src="{{ asset('storage/' . $menu->image) }}"
                alt="{{ $menu->name }}"
                style="width:100%;max-height:350px;object-fit:cover;border-radius:8px;"
            >
        @endif

        <p class="muted">
            {{ $menu->category->name }}
        </p>

        <h1>{{ $menu->name }}</h1>

        <p>{{ $menu->description ?: 'Belum ada deskripsi menu.' }}</p>

        <h2 class="price">
            Rp {{ number_format((float) $menu->price, 0, ',', '.') }}
        </h2>

        <p class="muted">
            Status: {{ $menu->is_available ? 'Tersedia' : 'Tidak tersedia' }}
        </p>
    </article>
@endsection
