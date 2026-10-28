
@extends('layouts.app')

@section('title', 'Admin - Pesanan')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:20px;">
        
<div>
    <a href="{{ route('admin.dashboard') }}" class="btn-back">
        ← Kembali ke Dashboard
    </a>

    <h1>Daftar Pesanan</h1>

    <p class="muted">
        Kelola pesanan pelanggan yang masuk melalui QR meja.
    </p>
</div>


        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf

            <button type="submit" class="button">
                Logout Admin
            </button>
        </form>
    </div>

    @if (session('success'))
        <div class="notice">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="notice">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @forelse ($orders as $order)
        <article class="card" style="margin-bottom:20px;">
            <h2>{{ $order->order_number }}</h2>

            <p>
                <strong>Meja:</strong>
                {{ $order->restaurantTable->table_number }}
            </p>

            <p>
                <strong>Pelanggan:</strong>
                {{ $order->customer_name ?: 'Tidak disebutkan' }}
            </p>

            <p>
                <strong>Catatan:</strong>
                {{ $order->notes ?: '-' }}
            </p>

            <h3>Rincian pesanan</h3>

            <ul>
                @foreach ($order->orderItems as $item)
                    <li>
                        {{ $item->menu->name }}
                        × {{ $item->quantity }}
                        — Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                    </li>
                @endforeach
            </ul>

            <p>
                <strong>Total:</strong>
                Rp {{ number_format((float) $order->total_amount, 0, ',', '.') }}
            </p>

            <p>
                <strong>Status:</strong>
                {{ strtoupper($order->status) }}
            </p>

            <form
                method="POST"
                action="{{ route('admin.orders.update-status', $order) }}"
            >
                @csrf
                @method('PATCH')

                <label for="status-{{ $order->id }}">
                    Ubah status pesanan
                </label>

                <select
                    id="status-{{ $order->id }}"
                    name="status"
                    required
                >
                    @foreach ([
                        'pending' => 'Menunggu',
                        'confirmed' => 'Dikonfirmasi',
                        'preparing' => 'Sedang disiapkan',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ] as $value => $label)
                        <option
                            value="{{ $value }}"
                            @selected($order->status === $value)
                        >
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                <button
                    type="submit"
                    class="button"
                    style="margin-top:12px;"
                >
                    Simpan Status
                </button>
            </form>
        </article>
    @empty
        <p>Belum ada pesanan masuk.</p>
    @endforelse

    {{ $orders->links() }}
@endsection
