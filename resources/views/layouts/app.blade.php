<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <!-- Meta Viewport Penting agar Skala di HP/Android Sesuai -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title ?? 'Bengkel Admin' }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden; /* Mencegah geser/scroll horizontal yang merusak layout */
        }
        
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* Penyesuaian padding tabel & card pada layar HP kecil */
        @media (max-width: 576px) {
            .container-fluid {
                padding-left: 12px;
                padding-right: 12px;
            }
            .card-body {
                padding: 1rem;
            }
            .table {
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body>

    <!-- Header Navigation Bar Responsif -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
        <div class="container-fluid px-lg-4">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-wrench-adjustable-circle me-2"></i>Bengkel Admin
            </a>
            
            <!-- Tombol Hamburger Menu untuk Android / Layar Kecil -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Navigasi -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active fw-bold' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('spareparts*') ? 'active fw-bold' : '' }}" href="{{ route('spareparts.index') }}">Data Sparepart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('stok-masuk*') ? 'active fw-bold' : '' }}" href="{{ route('stok_masuk.index') }}">Stok Masuk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('stok-keluar*') ? 'active fw-bold' : '' }}" href="{{ route('stok_keluar.index') }}">Stok Keluar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('stok-opnam*') ? 'active fw-bold' : '' }}" href="{{ route('stok_opnam.index') }}">Stok Opnam</a>
                </li>

            <!-- User Profile & Logout -->
            @auth
                <li class="nav-item dropdown ms-lg-3 mt-2 mt-lg-0">
                    <a class="nav-link dropdown-toggle btn btn-outline-light text-white btn-sm px-3" href="#" role="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                    </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li>
                    <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i> Keluar (Logout)
                    </button>
                </form>
            </li>
        </ul>
    </li>
    @endauth
</ul>

    <!-- Konten Utama Aplikasi -->
    <main class="pb-5">
        @yield('content')
    </main>

    <!-- Bootstrap 5 JavaScript Bundle (Wajib untuk dropdown, modal, dan hamburger navbar di HP) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>