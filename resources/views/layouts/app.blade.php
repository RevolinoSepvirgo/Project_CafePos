<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CafePOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('aset/logo/logo db.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('aset/logo/logo db.png') }}" sizes="16x16" />

    <style>
        body {
            background: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background: #343a40;
            color: #fff;
        }

        .sidebar .nav-link {
            color: #fff;
            transition: background 0.2s, color 0.2s;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background: #495057;
            color: #ffc107;
        }

        .sidebar .sidebar-header {
            background: #1f1f1f;
            padding: 1.5rem 1rem;
            text-align: center;
        }

        .logo-wrapper {
            background-color: #2c3035;
            border-radius: 12px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }

        .logo-wrapper:hover {
            background-color: #3a3f45;
        }

        .logo-wrapper img:first-child {
            width: 34px;
            height: 34px;
            margin-right: 10px;
            object-fit: contain;
        }

        .logo-wrapper img:last-child {
            height: 28px;
            object-fit: contain;
        }

        .sidebar .nav-link i {
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
        }
    </style>
</head>
<body>
<div class="d-flex">
    <nav class="sidebar flex-shrink-0 p-3">
        <!-- Sidebar Header dengan Logo & Nama -->
        <div class="sidebar-header mb-4">
            <div class="logo-wrapper">
                <img src="{{ asset('aset/logo/logo db.png') }}" alt="Logo Icon">
                <img src="{{ asset('aset/logo/desain bg.png') }}" alt="Logo Text">
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
                <a href="{{ url('/transactions') }}" class="nav-link {{ request()->is('transactions*') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i> Transaksi
                </a>
            </li>

            <li>
                <a href="{{ url('/users') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Pengguna
                </a>
            </li>

            <li>
                <a href="{{ url('/logout') }}" class="nav-link">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

    <main class="flex-grow-1 p-4">
        @yield('content')
    </main>
</div>

<!-- Alert auto-hide -->
<script>
  setTimeout(() => {
    const alert = document.querySelector('.alert');
    if (alert) {
      alert.classList.remove('show');
      alert.classList.add('fade');
      setTimeout(() => alert.remove(), 300);
    }
  }, 3000);
</script>
</body>
</html>
 