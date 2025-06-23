@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Daftar Pesanan</h4>

    <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">+ Buat Pesanan</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>no</th>
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
            @foreach($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->table->name }}</td>
                <td>{{ $order->user->name }}</td>
                <td>
                    <span class="badge bg-{{ $order->status == 'dibayar' ? 'success' : 'warning text-dark' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td>Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</td>
                <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
