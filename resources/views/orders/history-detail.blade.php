@extends('layouts.app')

@section('content')
<style>
    .card {
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        font-size: 1.1rem;
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    table th, table td {
        vertical-align: middle !important;
    }

    table th {
        background-color: #f1f1f1;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .badge.bg-success {
        font-size: 0.9rem;
        padding: 6px 12px;
        border-radius: 8px;
    }

    .btn-outline-dark i,
    .btn-secondary i {
        margin-right: 5px;
    }

    h4 i {
        margin-right: 8px;
        color: #343a40;
    }

    @media (max-width: 576px) {
        h4 {
            font-size: 1.1rem;
        }
        .btn {
            font-size: 0.9rem;
        }
        .card-body p {
            font-size: 0.9rem;
        }
    }
</style>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-receipt"></i> Detail Riwayat Pesanan</h4>
        <a href="{{ route('orders.print', $order->id) }}" class="btn btn-outline-dark" target="_blank">
            <i class="bi bi-printer"></i> Cetak Struk
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Atas Nama:</strong> {{ $order->customer_name }}</p>
            <p><strong>Meja:</strong> {{ $order->table->name }}</p>
            <p><strong>Kasir/Pelayan:</strong> {{ $order->user->name }}</p>
            <p><strong>Status:</strong>
                <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
            </p>
            <p><strong>Tanggal & Waktu:</strong> {{ $order->created_at->format('d-m-Y H:i') }}</p>
            @if($order->payment)
            <p><strong>Metode Pembayaran:</strong> {{ ucfirst($order->payment->method) }}</p>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header fw-bold bg-light">Rincian Pesanan</div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($order->items as $item)
                        @php $total += $item->subtotal; @endphp
                        <tr>
                            <td>{{ $item->menu->name }}</td>
                            <td class="text-end">Rp {{ number_format($item->menu->price, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th class="text-end">Rp {{ number_format($total, 0, ',', '.') }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('orders.history') }}" class="btn btn-secondary mt-3">
        <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
    </a>
</div>
@endsection
