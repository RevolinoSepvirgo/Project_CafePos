@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>Daftar Pesanan</h4>

        <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">+ Buat Pesanan</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- ========== Pesanan Belum Dibayar ========== --}}
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark fw-bold">Menunggu Pembayaran</div>
            <div class="card-body p-0">
                <table class="table table-bordered table-striped mb-0">
                    <thead>
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
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->table->name }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>
                                    <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td>Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</td>
                                <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('orders.payment.form', $order->id) }}" class="btn btn-sm btn-success">Bayar</a>
                                </td>



                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada pesanan menunggu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ========== Pesanan Sudah Dibayar ========== --}}
        <div class="card">
            <div class="card-header bg-success text-white fw-bold">Sudah Dibayar</div>
            <div class="card-body p-0">
                <table class="table table-bordered table-striped mb-0">
                    <thead>
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
                        @forelse($ordersDibayar as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->table->name }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>
                                    <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td>Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</td>
                                <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>

                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada pesanan dibayar</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $ordersDibayar->links() }}

            </div>
        </div>
    </div>
@endsection
