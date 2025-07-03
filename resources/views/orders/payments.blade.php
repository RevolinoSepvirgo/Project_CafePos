@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Pembayaran</h4>

    <div class="mb-3">
        <p><strong>Atas Nama:</strong> {{ $order->customer_name }}</p>
        <p><strong>Meja:</strong> {{ $order->table->name }}</p>
        <p><strong>Status:</strong>
            <span class="badge bg-{{ $order->status == 'dibayar' ? 'success' : 'warning text-dark' }}">
                {{ ucfirst($order->status) }}
            </span>
        </p>
    </div>

    <table class="table table-bordered">
        <thead>
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
                    <td>Rp {{ number_format($item->menu->price, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="3" class="text-end">Total</th>
                <th>Rp {{ number_format($total, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>

    @if($order->status != 'dibayar')
    <form action="{{ route('orders.pay', $order->id) }}" method="POST">
        @csrf

        <input type="hidden" name="total" id="total" value="{{ $total }}">

        <div class="mb-3">
            <label for="amount" class="form-label">Jumlah Dibayar</label>
            <input type="number" name="amount" id="amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="change" class="form-label">Kembalian</label>
            <input type="text" id="change" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-success">Bayar</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
    @else
        <div class="alert alert-success">Pesanan sudah dibayar.</div>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
    @endif
</div>
@endsection

@push('scripts')
<script>
    const amountInput = document.getElementById('amount');
    const changeInput = document.getElementById('change');
    const total = parseInt(document.getElementById('total').value);

    amountInput.addEventListener('input', function () {
        const bayar = parseInt(this.value) || 0;
        const kembalian = bayar - total;
        changeInput.value = kembalian >= 0 ? 'Rp ' + kembalian.toLocaleString('id-ID') : 'Rp 0';
    });
</script>
@endpush
