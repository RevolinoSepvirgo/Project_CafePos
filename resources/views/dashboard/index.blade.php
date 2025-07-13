@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">📊 Dashboard</h1>

        <!-- Statistik Kartu -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Pesanan Hari Ini -->
            <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between stat-card">
                <div>
                    <p class="text-sm text-gray-500">Pesanan Hari Ini</p>
                    <h3 class="text-xl font-bold text-gray-800">{{ $todayOrders }}</h3>
                </div>
                <div class="p-2 rounded-full bg-blue-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>

            <!-- Pendapatan Hari Ini -->
            <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between stat-card">
                <div>
                    <p class="text-sm text-gray-500">Pendapatan Hari Ini</p>
                    <h3 class="text-xl font-bold text-gray-800">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h3>
                </div>
                <div class="p-2 rounded-full bg-green-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Pesanan Bulan Ini -->
            <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between stat-card">
                <div>
                    <p class="text-sm text-gray-500">Pesanan Bulan Ini</p>
                    <h3 class="text-xl font-bold text-gray-800">{{ $monthlyOrders }}</h3>
                </div>
                <div class="p-2 rounded-full bg-purple-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                    </svg>
                </div>
            </div>

            <!-- Pendapatan Bulan Ini -->
            <div class="bg-white shadow rounded-lg p-4 flex items-center justify-between stat-card">
                <div>
                    <p class="text-sm text-gray-500">Pendapatan Bulan Ini</p>
                    <h3 class="text-xl font-bold text-gray-800">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h3>
                </div>
                <div class="p-2 rounded-full bg-yellow-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8v8m0 4v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                    </svg>
                </div>
            </div>
        </div>


        <!-- Grafik -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-md font-semibold text-gray-700 mb-4">📊 Grafik Pesanan & Pendaptan 7 Hari Terakhir</h2>
            <canvas id="combinedChart" height="100"></canvas>
        </div>



        <!-- Pesanan Terbaru -->
        <div class="bg-white shadow-lg rounded-xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-semibold text-gray-800">📝 Pesanan Terbaru</h2>
                <a href="{{ route('orders.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm divide-y divide-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-50 text-xs font-bold text-gray-600 uppercase tracking-wide">
                        <tr>
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">Meja</th>
                            <th class="px-6 py-3 text-left">pengelola</th>
                            <th class="px-6 py-3 text-left">Total</th>
                            <th class="px-6 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($recentOrders as $order)
                            <tr class="hover:bg-gray-50 transition-all duration-150">
                                <td class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap">#ORD-{{ $order->id }}
                                </td>
                                <td class="px-6 py-3 text-gray-700">{{ $order->table->name ?? '-' }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ $order->user->name ?? '-' }}</td>
                                <td class="px-6 py-3 font-semibold text-gray-800">
                                    Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-3">
                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full
                            {{ $order->status == 'dibayar' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection



    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('combinedChart').getContext('2d');
                const combinedChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($ordersPerDay->pluck('date')) !!}, // Pastikan $ordersPerDay dan $revenuePerDay urut
                        datasets: [{
                                label: 'Jumlah Pesanan',
                                data: {!! json_encode($ordersPerDay->pluck('total')) !!},
                                backgroundColor: '#3B82F6',
                                borderRadius: 6,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Pendapatan (Rp)',
                                data: {!! json_encode($revenuePerDay->pluck('total')) !!},
                                backgroundColor: '#10B981',
                                yAxisID: 'y1',
                                borderRadius: 6,

                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Jumlah Pesanan'
                                }
                            },
                            y1: {
                                beginAtZero: true,
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Pendapatan (Rp)'
                                },
                                grid: {
                                    drawOnChartArea: false
                                },
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
