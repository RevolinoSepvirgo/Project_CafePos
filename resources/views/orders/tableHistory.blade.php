@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4"><i class="bi bi-clock-history"></i> Riwayat Pembayaran</h4>

    <div class="card">
        <div class="card-header bg-secondary text-white">Semua Pesanan Dibayar</div>
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
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
                        <td>{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->table->name }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</td>
                        <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('orders.showHistory', $order->id) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Belum ada riwayat pembayaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
