<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Pemesanan QR')</title>

    <style>
      
* {
    box-sizing: border-box;
}

:root {
    --green-dark: #064e3b;
    --green: #059669;
    --green-hover: #047857;
    --green-light: #d1fae5;
    --text: #1f2937;
    --muted: #6b7280;
    --border: #e5e7eb;
    --surface: #ffffff;
}

body {
    margin: 0;
    font-family: "Segoe UI", Arial, sans-serif;
    background: #f5f8f5;
    color: var(--text);
    line-height: 1.6;
}

header {
    background: var(--green-dark);
    color: white;
    padding: 20px 6%;
    box-shadow: 0 3px 12px rgba(6, 78, 59, 0.12);
}

header a {
    color: white;
    text-decoration: none;
    font-size: 21px;
    font-weight: 800;
    letter-spacing: 0.2px;
}

main {
    max-width: 1150px;
    margin: 38px auto;
    padding: 0 24px;
    min-height: 65vh;
}

h1 {
    font-size: clamp(26px, 4vw, 34px);
    line-height: 1.25;
    margin: 0 0 10px;
    color: var(--green-dark);
}

h2 {
    color: var(--green-dark);
    font-size: 23px;
    margin-bottom: 18px;
}

h3 {
    margin-top: 0;
    font-size: 18px;
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 22px;
}

.card {
    background: var(--surface);
    border-radius: 16px;
    padding: 22px;
    border: 1px solid var(--border);
    box-shadow: 0 5px 18px rgba(15, 23, 42, 0.04);
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px rgba(6, 78, 59, 0.09);
}

.price {
    color: var(--green);
    font-size: 18px;
    font-weight: 800;
    margin: 16px 0;
}

.button {
    display: inline-block;
    padding: 11px 17px;
    border: none;
    border-radius: 9px;
    background: var(--green);
    color: white;
    text-decoration: none;
    cursor: pointer;
    font-size: 14px;
    font-weight: 700;
    transition: background 0.2s, transform 0.2s;
}

.button:hover {
    background: var(--green-hover);
}

input,
textarea,
select {
    width: 100%;
    padding: 11px 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    margin-top: 6px;
    font: inherit;
    background: white;
}

input:focus,
textarea:focus,
select:focus {
    outline: 2px solid var(--green-light);
    border-color: var(--green);
}

label {
    display: block;
    margin: 12px 0;
    font-weight: 600;
}

.muted {
    color: var(--muted);
}

footer {
    text-align: center;
    padding: 25px 16px;
    color: var(--muted);
    font-size: 13px;
    border-top: 1px solid #e5e7eb;
    background: white;
}

.notice {
    padding: 18px 20px;
    border-radius: 12px;
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    margin: 20px 0;
}

@media (max-width: 600px) {
    header {
        padding: 17px 20px;
    }

    header a {
        font-size: 19px;
    }

    main {
        margin: 26px auto;
        padding: 0 16px;
    }

    .grid {
        grid-template-columns: repeat(auto-fit, minmax(155px, 1fr));
        gap: 12px;
    }

    .card {
        padding: 15px;
        border-radius: 12px;
    }

    .button {
        padding: 10px 12px;
    }
}

.menu-intro {
    margin-bottom: 30px;
}

.menu-eyebrow {
    display: inline-block;
    color: #059669;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 2px;
    margin-bottom: 10px;
}

.menu-intro .muted {
    max-width: 600px;
}

.menu-card {
    padding: 0;
    overflow: hidden;
}

.menu-image {
    display: block;
    width: 100%;
    height: 190px;
    object-fit: cover;
    background: #ecfdf5;
}

.menu-image-placeholder {
    display: grid;
    place-items: center;
    width: 100%;
    height: 190px;
    background: #ecfdf5;
    font-size: 54px;
}

.menu-card-body {
    padding: 20px;
}

.menu-category {
    display: inline-block;
    color: #047857;
    background: #d1fae5;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    margin-bottom: 12px;
}

.menu-card h3 {
    margin-bottom: 8px;
}

.menu-description {
    font-size: 13px;
    min-height: 42px;
}

.menu-card-bottom {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
    margin-top: 15px;
}

.menu-card-bottom .price {
    margin: 0 0 5px;
}

@media (max-width: 600px) {
    .menu-image,
    .menu-image-placeholder {
        height: 145px;
    }

    .menu-card-body {
        padding: 14px;
    }

    .menu-card-bottom .button {
        width: 100%;
        text-align: center;
    }
}

.btn-back {
    display: inline-block;
    margin-bottom: 12px;
    padding: 10px 16px;
    border-radius: 9px;
    background: #064e3b;
    color: white;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    transition: background 0.2s;
}

.btn-back:hover {
    background: #047857;
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
