<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'D.Brownies')</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('aset/logo/logo db.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('aset/logo/logo db.png') }}" sizes="16x16" />

    <!-- Navbar Custom Style -->
    <style>
        .navbar-custom {
            background-color: #403d46;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #fff;
            font-weight: 500;
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active-link {
            color: #ffc107;
        }

        .logo-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-group img {
            height: 40px;
        }

        footer {
            background-color: #f8f9fa;
            padding: 16px 0;
            text-align: center;
            font-size: 0.9rem;
            color: #777;
            border-top: 1px solid #e9ecef;
        }

        @media (max-width: 576px) {
            .logo-group img:first-child {
                height: 32px;
            }

            .logo-group img:last-child {
                height: 36px;
            }
        }
    </style>

    @yield('style')
    @yield('head_extra')
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
        <div class="container">
            <a class="navbar-brand logo-group" href="{{ url('/') }}">
                <img src="{{ asset('aset/logo/logo db.png') }}" alt="Logo Kecil">
            </a>
            <a href="">
                <img class="img-responsive logo" src="{{ asset('aset/logo/desain bg.png') }}" alt="restorant"
                    style="position: relative; width: 150px !important; height: 45px !important; top: -4px; left: -10px;" />
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('menus*') ? 'active-link' : '' }}"
                            href="{{ route('menus.public') }}">
                            <i class="bi bi-card-list me-1"></i> Menu
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('tables*') ? 'active-link' : '' }}"
                            href="{{ route('tables.public') }}">
                            <i class="bi bi-table me-1"></i> Meja
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="pt-0 pb-2">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer Start -->
    <footer class="footer-area">
        <div class="container main-footer">
            <div class="row">

                <div class="footer-bottom text-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <p>Copyright © <a
                                        href="https://www.instagram.com/r.linoo_?igsh=djBmZHYyZm00c3du&utm_source=qr"
                                        target="_blank">R.lino</a> 2025. All Right Reserved By revolino.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer End -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
