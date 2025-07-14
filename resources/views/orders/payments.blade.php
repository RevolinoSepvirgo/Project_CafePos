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
                @foreach ($order->items as $item)
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

        @if ($order->status != 'dibayar')
            <form id="payment-form" action="{{ route('orders.pay', $order->id) }}" method="POST">
                @csrf
                <input type="hidden" name="total" id="total" value="{{ $total }}">
                <input type="hidden" name="change" id="change_hidden">

                <div class="mb-3">
                    <label for="payment_method" class="form-label">Metode Pembayaran</label>
                    <select name="payment_method" id="payment_method" class="form-select" required>
                        <option value="">Pilih Metode</option>
                        <option value="tunai">Tunai</option>
                        <option value="qris">QRIS</option>
                        <option value="debit">Debit</option>
                        <option value="kredit">Kartu Kredit</option>
                    </select>
                </div>

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
            <a href="{{ route('orders.print', $order->id) }}" target="_blank" class="btn btn-primary">
                <i class="bi bi-printer"></i> Cetak Struk
            </a>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const amountInput = document.getElementById('amount');
        const changeInput = document.getElementById('change');
        const changeHidden = document.getElementById('change_hidden');
        const total = parseInt(document.getElementById('total')?.value ?? 0);

        if (amountInput) {
            amountInput.addEventListener('input', function () {
                const bayar = parseInt(this.value) || 0;
                const kembalian = bayar - total;
                const formatted = kembalian >= 0 ? 'Rp ' + kembalian.toLocaleString('id-ID') : 'Rp 0';
                changeInput.value = formatted;
                changeHidden.value = kembalian >= 0 ? kembalian : 0;
            });
        }

       const form = document.getElementById('payment-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Cegah submit default

            Swal.fire({
                title: 'Pembayaran berhasil!',
                text: "Apakah Anda ingin mencetak struk?",
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Ya, Cetak Struk',
                cancelButtonText: 'Tidak',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
            }).then((result) => {
                // Kirim form via AJAX
                const formData = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                }).then(response => {
                    if (result.isConfirmed) {
                        // Jika ingin cetak struk
                        window.location.href = "{{ route('orders.print', $order->id) }}";
                    } else {
                        // Jika tidak
                        window.location.href = "{{ route('orders.index') }}";
                    }
                }).catch(error => {
                    Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan pembayaran.', 'error');
                    console.error(error);
                });
            });
        });
    }
    </script>
@endpush
