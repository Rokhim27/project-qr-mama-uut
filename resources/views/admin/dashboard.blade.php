
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | QR Restaurant</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f4f7fb;
            color: #1e293b;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 245px;
            background: #064e3b;
            color: white;
            padding: 30px 18px;
            flex-shrink: 0;
        }

        .brand {
            font-size: 21px;
            font-weight: 800;
            margin-bottom: 42px;
            padding: 0 12px;
        }

        .brand span {
            color: #34d399;
        }

        .menu-label {
            color: #94a3b8;
            font-size: 11px;
            letter-spacing: 1.5px;
            margin: 25px 12px 12px;
        }

        .nav-link {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            padding: 13px 14px;
            border-radius: 10px;
            margin-bottom: 8px;
            font-size: 14px;
            transition: 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
             background: #059669;
            color: white;
        }

        .main {
            flex: 1;
            min-width: 0;
            padding: 30px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 30px;
        }

        .topbar h1 {
            font-size: 27px;
            margin-bottom: 7px;
        }

        .subtitle {
            color: #64748b;
            font-size: 14px;
        }

        .admin-label {
            background: white;
            border: 1px solid #e2e8f0;
            padding: 10px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            padding: 24px;
            background: white;
            border-radius: 16px;
            border: 1px solid #e8edf5;
            box-shadow: 0 5px 20px rgba(15, 23, 42, 0.035);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }

        .stat-title {
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
        }

        .stat-icon {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            font-size: 22px;
        }

        .blue {
             background: #d1fae5;
        }

        .orange {
            background: #ffedd5;
        }

        .green {
            background: #dcfce7;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
        }

        .stat-description {
            color: #94a3b8;
            font-size: 12px;
            margin-top: 8px;
        }

        .panel {
            background: white;
            border-radius: 16px;
            border: 1px solid #e8edf5;
            box-shadow: 0 5px 20px rgba(15, 23, 42, 0.035);
            overflow: hidden;
        }

        .panel-header {
            padding: 23px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #edf1f7;
        }

        .panel-header h2 {
            font-size: 18px;
            margin-bottom: 6px;
        }

        .panel-header p {
            color: #94a3b8;
            font-size: 12px;
        }

        .btn {
            display: inline-block;
            padding: 11px 16px;
            border-radius: 9px;
            background: #059669;
            color: white;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
           background: #047857;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
        }

        thead {
            background: #f8fafc;
        }

        th {
            padding: 15px 22px;
            color: #64748b;
            font-size: 11px;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 18px 22px;
            border-top: 1px solid #f1f5f9;
            font-size: 13px;
        }

        tbody tr:hover {
            background: #f8fbff;
        }

        .order-number {
            color: #059669;
            font-weight: 700;
        }

        .table-number {
            background: #f1f5f9;
            padding: 6px 10px;
            border-radius: 7px;
            font-size: 12px;
        }

        .amount {
            font-weight: 700;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-confirmed {
            background: #d1fae5;
            color: #1d4ed8;
        }

        .status-preparing {
            background: #ffedd5;
            color: #c2410c;
        }

        .status-completed {
            background: #dcfce7;
            color: #166534;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty {
            text-align: center;
            color: #94a3b8;
            padding: 35px;
        }

        .footer {
            color: #94a3b8;
            font-size: 12px;
            text-align: center;
            margin-top: 25px;
        }

        .logout-form {
            margin-top: 8px;
        }

        .logout-button {
            width: 100%;
            text-align: left;
            background: transparent;
            border: none;
            cursor: pointer;
            font: inherit;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 200px;
            }

            .main {
                padding: 22px;
            }

            .stats {
                gap: 12px;
            }

            .stat-card {
                padding: 18px;
            }
        }

        @media (max-width: 650px) {
            .layout {
                display: block;
            }

            .sidebar {
                width: 100%;
                padding: 18px;
            }

            .brand {
                margin-bottom: 16px;
            }

            .menu-label {
                display: none;
            }

            .sidebar nav {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }

            .nav-link {
                margin: 0;
                padding: 10px 12px;
            }

            .main {
                padding: 20px 14px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .topbar h1 {
                font-size: 23px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 20px;
            }

            .panel-header {
                padding: 18px;
                align-items: flex-start;
                flex-direction: column;
            }

            th, td {
                padding: 14px 16px;
            }
        }
    </style>
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <div class="brand">QR<span>Restaurant</span></div>

        <div class="menu-label">MENU UTAMA</div>

        <nav>
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link active">
                ▦ &nbsp; Dashboard
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="nav-link">
                ☷ &nbsp; Kelola Pesanan
            </a>
        </nav>

        <div class="menu-label">AKUN</div>

        <form action="{{ route('admin.logout') }}"
              method="POST"
              class="logout-form">
            @csrf

            <button type="submit"
                    class="nav-link logout-button">
                ↪ &nbsp; Logout
            </button>
        </form>
    </aside>

    <main class="main">

        <header class="topbar">
            <div>
                <h1>Dashboard Admin</h1>
                <p class="subtitle">
                    Selamat datang! Berikut ringkasan pesanan restoran Anda.
                </p>
            </div>

            <div class="admin-label">
                🛡️ Administrator
            </div>
        </header>

        <section class="stats">

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-title">Total Pesanan</span>
                    <div class="stat-icon blue">🧾</div>
                </div>

                <div class="stat-number">{{ $totalOrders }}</div>

                <p class="stat-description">
                    Seluruh pesanan yang tercatat
                </p>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-title">Pesanan Baru</span>
                    <div class="stat-icon orange">🔔</div>
                </div>

                <div class="stat-number">{{ $newOrders }}</div>

                <p class="stat-description">
                    Pesanan dengan status pending
                </p>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-title">Pesanan Selesai</span>
                    <div class="stat-icon green">✓</div>
                </div>

                <div class="stat-number">{{ $completedOrders }}</div>

                <p class="stat-description">
                    Pesanan yang telah diselesaikan
                </p>
            </div>

        </section>

        <section class="panel">

            <div class="panel-header">
                <div>
                    <h2>Pesanan Terbaru</h2>
                    <p>Ringkasan lima pesanan terakhir yang masuk.</p>
                </div>

                <a href="{{ route('admin.orders.index') }}"
                   class="btn">
                    Kelola Pesanan →
                </a>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Nomor Pesanan</th>
                        <th>Meja</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse ($recentOrders as $order)
                        <tr>
                            <td class="order-number">
                                {{ $order->order_number }}
                            </td>

                            <td>
                                <span class="table-number">
                                    {{ $order->restaurantTable->table_number
                                        ?? '-' }}
                                </span>
                            </td>

                            <td class="amount">
                                Rp{{ number_format(
                                    (float) $order->total_amount,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </td>

                            <td>
                                <span class="status status-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>

                            <td>
                                {{ $order->created_at->format('d-m-Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                Belum ada pesanan yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </section>

        <footer class="footer">
            © {{ date('Y') }} QR Restaurant · Sistem Pemesanan Digital
        </footer>

    </main>
</div>
</body>
</html>
