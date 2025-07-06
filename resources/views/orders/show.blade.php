@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4 fw-bold text-primary">🧾 Detail Pesanan</h4>

                {{-- Informasi Umum --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <p><strong>Atas Nama:</strong><br> {{ $order->customer_name }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Meja:</strong><br> {{ $order->table->name }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Kasir / Pelayan:</strong><br> {{ $order->user->name }}</p>
                    </div>
                </div>

                <p><strong>Status:</strong>
                    @if ($order->status === 'dibayar')
                        <span class="badge bg-success">✅ Sudah Dibayar</span>
                    @else
                        <span class="badge bg-warning text-dark">⏳ Menunggu Pembayaran</span>
                    @endif
                </p>

                {{-- Tabel Menu --}}
                <div class="table-responsive mt-4">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>🍽️ Menu</th>
                                <th>💰 Harga</th>
                                <th>🔢 Qty</th>
                                <th>🧾 Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach ($order->items as $item)
                                @php $grandTotal += $item->subtotal; @endphp
                                <tr>
                                    <td>{{ $item->menu->name }}</td>
                                    <td>Rp {{ number_format($item->menu->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr class="fw-bold bg-light">
                                <td colspan="3" class="text-end">Total</td>
                                <td>Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Tombol Aksi --}}
                <div class="mt-4 d-flex flex-wrap gap-2">
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-outline-primary">
                        ✏️ Edit / Tambah Menu
                    </a>

                    @if ($order->status === 'menunggu')
                        <a href="{{ route('orders.payment.form', $order->id) }}" class="btn btn-success">
                            💳 Bayar Sekarang
                        </a>
                    @endif

                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                        ⬅️ Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        h4 {
            font-weight: 700;
        }

        .badge {
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 12px;
        }

        .btn {
            padding: 8px 18px;
            border-radius: 10px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
@endpush
