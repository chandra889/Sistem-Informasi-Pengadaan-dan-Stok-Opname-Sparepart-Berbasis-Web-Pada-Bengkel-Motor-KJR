<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Bengkel Admin')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .main-content {
            flex: 1;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Header Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <!-- Logo / Judul Sistem -->
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                <i class="bi bi-wrench-adjustable text-primary fs-4"></i>
                <span>Bengkel Admin</span>
            </a>

            <!-- Tombol Toggle Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Navigasi -->
            <div class="collapse navbar-collapse" id="navbarNav">
                
                <!-- Menu Kiri -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('spareparts*') ? 'active fw-bold' : '' }}" href="{{ route('spareparts.index') }}">
                            <i class="bi bi-box-seam me-1"></i> Data Sparepart
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('stok-masuk*') ? 'active fw-bold' : '' }}" href="{{ route('stok_masuk.index') }}">
                            <i class="bi bi-arrow-down-right-circle me-1"></i> Stok Masuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('stok-keluar*') ? 'active fw-bold' : '' }}" href="{{ route('stok_keluar.index') }}">
                            <i class="bi bi-arrow-up-right-circle me-1"></i> Stok Keluar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('stok-opnam*') ? 'active fw-bold' : '' }}" href="{{ route('stok_opnam.index') }}">
                            <i class="bi bi-clipboard-check me-1"></i> Stok Opnam
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('laporan*') ? 'active fw-bold' : '' }}" href="{{ route('laporan.index') }}">
                            <i class="bi bi-file-earmark-text me-1"></i> Laporan
                        </a>
<                   /li>
                </ul>

                <!-- Menu Kanan (Profil Admin & Logout) -->
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-5"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="navbarUserDropdown">
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                                        <i class="bi bi-box-arrow-right"></i> Keluar (Logout)
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endauth
                </ul>

            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="main-content py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-top py-3 mt-auto">
        <div class="container text-center text-muted small">
            &copy; {{ date('Y') }} <strong>Bengkel Admin System</strong>. Hak Cipta Dilindungi.
        </div>
    </footer>

    <!-- JS Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>