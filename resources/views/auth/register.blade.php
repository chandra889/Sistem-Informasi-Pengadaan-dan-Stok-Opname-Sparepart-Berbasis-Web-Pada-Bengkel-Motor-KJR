<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Bengkel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-register {
            max-width: 450px;
            width: 100%;
            border-radius: 15px;
        }
    </style>
</head>
<body>

<div class="container p-3">
    <div class="card card-register border-0 shadow-lg mx-auto p-3 p-md-4 bg-white">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-dark">Registrasi Akun Admin</h4>
            <p class="text-muted small">Buat akun untuk mengakses sistem pengelolaan bengkel</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Nama Anda" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Alamat Email</label>
                <input type="email" name="email" class="form-control" placeholder="admin@bengkel.com" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 6 Karakter" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi Password" required>
            </div>

            <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm">
                <i class="bi bi-person-check me-1"></i> Daftar Akun
            </button>
        </form>

        <div class="text-center mt-4 border-top pt-3">
            <p class="small text-muted mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Login ke Sistem</a></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>