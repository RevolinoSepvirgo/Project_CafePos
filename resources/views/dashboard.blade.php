@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard</h2>
    <div class="alert alert-success">
        Selamat datang, {{ auth()->user()->name }}!
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Menu</h5>
                    <a href="{{ route('menus.index') }}" class="btn btn-outline-success btn-sm mt-2">Lihat Menu</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Meja</h5>
                    <a href="{{ route('tables.index') }}" class="btn btn-outline-primary btn-sm mt-2">Lihat Meja</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Pesanan</h5>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-warning btn-sm mt-2">Lihat Pesanan</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Statistik -->
    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            Statistik Data
        </div>
        <div class="card-body">
            <canvas id="dashboardChart" height="80"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('dashboardChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Menu', 'Meja', 'Pesanan'],
            datasets: [{
                label: 'Jumlah',
                data: [
                    {{ $menuCount ?? 0 }},
                    {{ $tableCount ?? 0 }},
                    {{ $orderCount ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(25, 135, 84, 0.7)',
                    'rgba(13, 110, 253, 0.7)',
                    'rgba(255, 193, 7, 0.7)'
                ],
                borderColor: [
                    'rgba(25, 135, 84, 1)',
                    'rgba(13, 110, 253, 1)',
                    'rgba(255, 193, 7, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush
