@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-secondary"><i class="bi bi-clock-history me-2"></i>Riwayat Pembayaran</h4>
    </div>

    {{-- Filter Tanggal --}}
    <form method="GET" class="row g-3 align-items-end mb-4">
        <div class="col-md-3">
            <label for="start_date" class="form-label fw-semibold">Dari Tanggal</label>
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="form-control shadow-sm">
        </div>
        <div class="col-md-3">
            <label for="end_date" class="form-label fw-semibold">Sampai Tanggal</label>
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-control shadow-sm">
        </div>
        <div class="col-md-auto d-flex gap-2">
            <button type="submit" class="btn btn-primary shadow-sm">
                <i class="bi bi-filter"></i> Filter
            </button>
            <a href="{{ route('orders.history') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-x-circle"></i> Reset
            </a>
        </div>
    </form>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white fw-semibold">
            <i class="bi bi-receipt-cutoff me-1"></i> Daftar Pesanan Dibayar
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Atas Nama</th>
                            <th>Meja</th>
                            <th>Kasir/Pelayan</th>
                            <th>Total</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td class="text-center">{{ $order->table->name }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td class="text-end">Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</td>
                            <td class="text-center">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                            <td class="text-center">
                                <span class="badge bg-success px-3 py-1">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('orders.showHistory', $order->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada riwayat pembayaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white">
            {{ $orders->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
