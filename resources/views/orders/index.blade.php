@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col text-center">
                <h4 class="fw-bold d-inline-flex align-items-center mb-0">
                    <i class="bi bi-receipt me-2"></i> Daftar Pesanan
                </h4>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="row align-items-center mb-4">
            <div class="col-md-6 text-start">
                <a href="{{ route('orders.create') }}" class="btn btn-dark rounded-pill px-4 shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i> Buat Pesanan
                </a>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('orders.history') }}" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
                    <i class="bi bi-clock-history me-1"></i> Riwayat Pesanan
                </a>
            </div>
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ========== Pesanan Menunggu ========== --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="bi bi-hourglass-split me-2"></i> Menunggu Pembayaran
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0 align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Atas Nama</th>
                                <th>Meja</th>
                                <th>Kasir/Pelayan</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ordersMenunggu as $order)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td class="text-center">{{ $order->table->name }}</td>
                                    <td>{{ $order->user->name ?? $order->user_name }}</td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-warning text-dark px-3 py-1">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td class="text-end">Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info me-1">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('orders.payment.form', $order->id) }}"
                                            class="btn btn-sm btn-danger">
                                            <i class="bi bi-credit-card me-1"></i> Bayar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Tidak ada pesanan menunggu</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ========== Pesanan Dibayar ========== --}}
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white fw-bold">
                <i class="bi bi-check-circle me-2"></i> Sudah Dibayar Hari Ini
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0 align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Atas Nama</th>
                                <th>Meja</th>
                                <th>Kasir/Pelayan</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Metode</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ordersDibayar as $order)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td class="text-center">{{ $order->table->name }}</td>
                                    <td>{{ $order->user->name ?? $order->user_name }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success px-3 py-1">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td class="text-end">Rp
                                        {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</td>
                                    <td class="text center">
                                        {{ ucfirst($order->payment->method ?? '-') }}

                                    </td>
                                    <td class="text-center">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('orders.showHistory', $order->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Tidak ada pesanan dibayar hari
                                        ini</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="px-3 py-2">
                        {{ $ordersDibayar->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
