<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Pemesanan QR')</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f8f7f4;
            color: #292929;
        }

        header {
            background: #263b2d;
            color: white;
            padding: 18px 6%;
        }

        header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 20px;
        }

        main {
            max-width: 1100px;
            margin: 32px auto;
            padding: 0 20px;
            min-height: 65vh;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e7e4dd;
        }

        .price {
            color: #287344;
            font-weight: bold;
        }

        .button {
            display: inline-block;
            padding: 10px 16px;
            border: 0;
            border-radius: 7px;
            background: #287344;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 7px;
            margin-top: 6px;
        }

        label { display: block; margin: 12px 0; }

        .muted { color: #686868; }

        footer {
            text-align: center;
            padding: 22px;
            color: #686868;
        }

        .notice {
            padding: 12px;
            border-radius: 8px;
            background: #e7f5e9;
            margin: 15px 0;
        }

        @media (max-width: 600px) {
            main { margin-top: 22px; }
        }
    </style>
</head>
<body>
    <header>
        <a href="{{ route('menus.index') }}">Sistem Pemesanan QR</a>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        Sistem Pemesanan QR &copy; {{ date('Y') }}
    </footer>

    @stack('scripts')
</body>
</html>
