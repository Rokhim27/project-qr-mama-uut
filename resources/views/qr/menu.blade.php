@extends('layouts.app')

@section('title', 'Pemesanan - ' . $table->table_number)

@section('content')
    <h1>Menu Restoran</h1>

    <div class="notice">
        Anda memesan dari <strong>{{ $table->table_number }}</strong>.
    </div>

    <form id="order-form">
        <h2>Pilih Menu</h2>

        <div class="grid">
            @forelse ($categories as $category)
                @foreach ($category->menus as $menu)
                    
<article class="card menu-card">

    @if ($menu->image)
        <img
            class="menu-image"
            src="{{ asset('storage/' . $menu->image) }}"
            alt="{{ $menu->name }}"
            loading="lazy"
        >
    @else
        <div class="menu-image-placeholder">🍽️</div>
    @endif

    <div class="menu-card-body">

        <span class="menu-category">{{ $category->name }}</span>

        <h3>{{ $menu->name }}</h3>

        <p class="muted menu-description">
            {{ $menu->description ?: 'Menu pilihan restoran.' }}
        </p>

        <p class="price">
            Rp {{ number_format((float) $menu->price, 0, ',', '.') }}
        </p>

        <label>
            <input
                type="checkbox"
                class="menu-check"
                value="{{ $menu->id }}"
                style="width:auto"
            >
            Pilih menu
        </label>

        <label>
            Jumlah
            <input
                type="number"
                class="menu-quantity"
                data-menu-id="{{ $menu->id }}"
                min="1"
                max="100"
                value="1"
            >
        </label>

    </div>
</article>

                @endforeach
            @empty
                <p>Belum ada menu tersedia.</p>
            @endforelse
        </div>

        <section class="card" style="margin-top:25px">
            <h2>Informasi Pemesan</h2>

            <label>
                Nama pelanggan
                <input
                    type="text"
                    name="customer_name"
                    maxlength="255"
                    placeholder="Masukkan nama Anda"
                >
            </label>

            <label>
                Catatan pesanan
                <textarea
                    name="notes"
                    rows="3"
                    maxlength="2000"
                    placeholder="Contoh: tidak pedas"
                ></textarea>
            </label>

            <button type="submit" class="button" id="submit-order">
                Buat pesanan
            </button>

            <p id="order-message" role="status" aria-live="polite"></p>
        </section>
    </form>
@endsection

@push('scripts')
<script>
document.getElementById('order-form').addEventListener('submit', async function (event) {
    event.preventDefault();

    const form = this;
    const button = document.getElementById('submit-order');
    const message = document.getElementById('order-message');

    const items = [];

    document.querySelectorAll('.menu-check:checked').forEach(function (checkbox) {
        const input = document.querySelector(
            '.menu-quantity[data-menu-id="' + checkbox.value + '"]'
        );

        items.push({
            menu_id: Number(checkbox.value),
            quantity: Number(input.value)
        });
    });

    if (items.length === 0) {
        message.textContent = 'Pilih minimal satu menu terlebih dahulu.';
        return;
    }

    if (items.some(item =>
        !Number.isInteger(item.quantity) ||
        item.quantity < 1 ||
        item.quantity > 100
    )) {
        message.textContent = 'Jumlah setiap menu harus antara 1 dan 100.';
        return;
    }

    button.disabled = true;
    message.textContent = 'Mengirim pesanan...';

    try {
        const response = await fetch(
            @json(route('qr.orders.store', ['token' => $table->qr_token])),
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content
                },
                body: JSON.stringify({
                    customer_name: form.elements.customer_name.value,
                    notes: form.elements.notes.value,
                    items: items
                })
            }
        );

        const result = await response.json();

        if (!response.ok) {
            const errors = result.errors
                ? Object.values(result.errors).flat().join(' ')
                : result.message || 'Pesanan gagal dibuat.';

            throw new Error(errors);
        }

        message.textContent =
            'Pesanan berhasil dibuat. Nomor: ' +
            result.order.order_number;

        form.reset();
    } catch (error) {
        message.textContent = error.message ||
            'Terjadi kesalahan saat mengirim pesanan.';
    } finally {
        button.disabled = false;
    }
});
</script>
@endpush
