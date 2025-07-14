<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cetak Riwayat Pembayaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body class="p-4">
    <div class="d-flex justify-content-between align-items-center no-print mb-4">
        <h4 class="mb-0">🧾 Laporan Pembayaran</h4>
        <button class="btn btn-dark" onclick="window.print()">
            <i class="bi bi-printer"></i> Cetak
        </button>
    </div>

    <p class="mb-4">
        Periode:
        <strong>{{ $startDate ?? '-' }}</strong> s.d.
        <strong>{{ $endDate ?? '-' }}</strong>
    </p>

    <table class="table table-bordered table-sm">
        <thead class="table-secondary text-center">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Meja</th>
                <th>Kasir</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @php $totalSemua = 0; @endphp
            @forelse ($orders as $order)
                @php
                    $totalOrder = $order->items->sum('subtotal');
                    $totalSemua += $totalOrder;
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->table->name ?? '-' }}</td>
                    <td>{{ $order->user->name ?? ($order->user_name ?? '-') }}</td>
                    <td class="text-end">Rp {{ number_format($totalOrder, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $order->payment->method ?? '-' }}</td>
                    <td class="text-center">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-3">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
        @if (count($orders))
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Total Keseluruhan:</th>
                    <th class="text-end">Rp {{ number_format($totalSemua, 0, ',', '.') }}</th>
                    <th colspan="2"></th>
                </tr>
            </tfoot>
        @endif
    </table>
</body>

</html>
