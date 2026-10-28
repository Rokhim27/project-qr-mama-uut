@extends('layouts.app')

@section('title', 'Daftar Menu Restoran')

@section('content')
   <div class="menu-intro">
    <span class="menu-eyebrow">QR RESTAURANT</span>
    <h1>Temukan Menu Favorit Anda</h1>
    <p class="muted">
        Pilihan makanan dan minuman lezat untuk menemani hari Anda.
    </p>
</div>

    @if ($table)
        <div class="notice">
            <strong>Ingin memesan?</strong>
            <p>Masuk ke halaman pemesanan untuk memilih menu dan jumlah.</p>

            <a class="button"
               href="{{ route('qr.menu', ['token' => $table->qr_token]) }}">
                Pesan Sekarang
            </a>
        </div>
    @else
        <div class="notice">
            Belum ada meja aktif. Aktifkan meja terlebih dahulu untuk melakukan pemesanan.
        </div>
    @endif

    @forelse ($categories as $category)
        <section style="margin: 30px 0;">
            <h2>{{ $category->name }}</h2>

            <div class="grid">
                @forelse ($category->menus as $menu)
                    <article class="card">
                        
<article class="card menu-card">

    @if ($menu->image)
        <img
            class="menu-image"
            src="{{ asset('storage/' . $menu->image) }}"
            alt="{{ $menu->name }}"
            loading="lazy"
        >
    @else
        <div class="menu-image-placeholder">
            🍽️
        </div>
    @endif

    <div class="menu-card-body">

        <span class="menu-category">
            {{ $category->name }}
        </span>

        <h3>{{ $menu->name }}</h3>

        <p class="muted menu-description">
            {{ $menu->description ?: 'Menu pilihan restoran.' }}
        </p>

        <div class="menu-card-bottom">
            <p class="price">
                Rp {{ number_format((float) $menu->price, 0, ',', '.') }}
            </p>

            @if ($table)
                <a
                    class="button"
                    href="{{ route('qr.menu', ['token' => $table->qr_token]) }}"
                >
                    Pesan Menu →
                </a>
            @endif
        </div>

    </div>
                    </article>
                @empty
                    <p class="muted">Belum ada menu tersedia.</p>
                @endforelse
            </div>
        </section>
    @empty
        <p>Belum ada kategori aktif.</p>
    @endforelse
@endsection
