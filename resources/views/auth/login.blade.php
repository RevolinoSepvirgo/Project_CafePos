<!-- filepath: resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/daftar.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('aset/logo/logo db.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('aset/logo/logo .png') }}" sizes="16x16" />
</head>

<body>
    <!-- Latar belakang -->
    <div class="background-container"></div>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
            <div class="text-center mb-4">
                <img src="{{ asset('aset/logo/logo db.png') }}" alt="Logo" style="width: 60px;">
                <h4 class="mt-2">Login D'Brownies</h4>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li style="font-size: 0.95em;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                        <input type="text" name="email" id="email" class="form-control"
                            placeholder="Masukkan email">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Masukkan password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>

                <!-- ⬇ Tambahan tombol kembali -->
                <div class="text-center mt-3">
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100" style="transition: 0.3s;">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
                    </a>
                </div>

        </div>
</body>

</html>
