@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Detail Pesanan</h4>

    {{-- Informasi Pesanan --}}
    <p><strong>Atas Nama:</strong> {{ $order->customer_name }}</p>
    <p><strong>Meja:</strong> {{ $order->table->name }}</p>
    <p><strong>Pelayan/Kasir:</strong> {{ $order->user->name }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

    {{-- Tabel Item Pesanan --}}
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Menu</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($order->items as $item)
                @php $grandTotal += $item->subtotal; @endphp
                <tr>
                    <td>{{ $item->menu->name }}</td>
                    <td>Rp {{ number_format($item->menu->price, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="3">Total</th>
                <th>Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>

    {{-- Jika Belum Dibayar, Tampilkan Form Pembayaran --}}
    @if($order->status === 'menunggu')
        <hr>
        <h5>Pembayaran</h5>
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('orders.pay', $order->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Metode Pembayaran</label>
                <select name="method" class="form-control" required>
                    <option value="Tunai">Tunai</option>
                    <option value="QRIS">QRIS</option>
                    <option value="Debit">Debit</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Jumlah Dibayar</label>
                <input type="number" name="amount" class="form-control" min="{{ $grandTotal }}" required>
            </div>

            <button class="btn btn-success">Bayar Sekarang</button>
        </form>

    {{-- Jika Sudah Dibayar, Tampilkan Info Pembayaran --}}
    @elseif($order->status === 'dibayar' && $order->payment)
        <div class="alert alert-success mt-4">
            <h5>Pembayaran Selesai</h5>
            <ul>
                <li><strong>Metode:</strong> {{ $order->payment->method }}</li>
                <li><strong>Dibayar:</strong> Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</li>
                <li><strong>Tanggal:</strong> {{ $order->payment->created_at->format('d M Y H:i') }}</li>
            </ul>
        </div>
    @endif

    <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
