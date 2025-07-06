<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CafePOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="icon" type="image/png" href="{{ asset('aset/logo/logo db.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('aset/logo/logo db.png') }}" sizes="16x16" />

    <style>
        body {
            background: #f1f3f5;
            margin: 0;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: #22252a;
            color: #fff;
            overflow-y: auto;
            transition: all 0.3s;
            padding: 1rem;
            display: flex;
            flex-direction: column;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            font-weight: 500;
            border-radius: 0.5rem;
            margin-bottom: 5px;
            transition: all 0.2s;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background: #ffc107;
            color: #22252a;
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 1rem;
        }

        .logo-wrapper img {
            object-fit: contain;
        }

        .account-info {
            margin-top: auto;
            padding: 1rem;
            background: #343a40;
            text-align: center;
            border-radius: 0.5rem;
        }

        .account-info .name {
            font-weight: bold;
        }

        .account-info .role {
            color: #ffc107;
            text-transform: capitalize;
        }

        main {
            margin-left: 240px;
            padding: 2rem;
        }

        .account-info .bi-person-circle {
            font-size: 1.2rem;
            vertical-align: middle;
            margin-right: 4px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <div class="logo-wrapper d-flex align-items-center justify-content-center">
                <img src="{{ asset('aset/logo/logo db.png') }}" alt="Logo Icon" class="me-2" style="height: 38px;">
                <img src="{{ asset('aset/logo/desain bg.png') }}" alt="Logo Text" style="height: 28px;">
            </div>
        </div>

        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('menus.index') }}" class="nav-link {{ request()->routeIs('menus.*') ? 'active' : '' }}">
                    <i class="bi bi-cup-straw"></i> Menu
                </a>
            </li>
            <li>
                <a href="{{ route('tables.index') }}" class="nav-link {{ request()->routeIs('tables.*') ? 'active' : '' }}">
                    <i class="bi bi-table"></i> Meja
                </a>
            </li>
            <li>
                <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                    <i class="bi bi-cart"></i> Pesanan
                </a>
            </li>
            <li>
                <a href="{{ route('orders.create') }}" class="nav-link {{ request()->is('transactions*') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i> Transaksi
                </a>
            </li>
            <li>
                <a href="{{ url('/users') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Pengguna
                </a>
            </li>
        </ul>

        @if (auth()->check())
            <div class="account-info">
                <div class="name">
                    <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
                </div>
                <div class="role">{{ auth()->user()->role }}</div>
                <hr class="my-2 text-gray-500">

                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="button" class="nav-link w-100 text-start" onclick="confirmLogout()">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        @endif
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Yakin mau logout?',
                text: "Sesi kamu akan berakhir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 300);
            }
        }, 3000);
    </script>

    @stack('scripts')
</body>

</html>
