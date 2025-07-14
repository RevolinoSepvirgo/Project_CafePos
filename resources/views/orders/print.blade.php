<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pesanan</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 13px;
            color: #000;
            width: 80mm;
            margin: auto;
            background: #fff;
        }

        .header, .footer {
            text-align: center;
        }

        h2 {
            margin: 0;
            font-size: 18px;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            padding: 4px 0;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .bold {
            font-weight: bold;
        }

        .double-line {
            border-top: 2px solid #000;
            margin: 8px 0;
        }

        .total-box {
            padding-top: 4px;
            border-top: 1px dashed #000;
            margin-top: 5px;
        }

        .footer small {
            display: block;
            margin-top: 3px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>D'Brownies</h2>
        <small>Jl. Gadut No.123, Kota Padang</small><br
        <small>Telp: +62 851-7320-2332</small><br>
        <small>Ig: @d.brownies</small>
    </div>

    <div class="line"></div>

    <table>
        <tr>
            <td>Nama</td>
            <td>: {{ $order->customer_name }}</td>
        </tr>
        <tr>
            <td>Meja</td>
            <td>: {{ $order->table->name }}</td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td>: {{ $order->user->name }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: {{ $order->created_at->format('d-m-Y H:i') }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <table>
        <thead>
            <tr>
                <th class="text-left">Menu</th>
                <th class="text-center">Qty</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td class="text-left">{{ $item->menu->name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="line"></div>

    @php
        $payment = $order->payment;
        $total = $order->items->sum('subtotal');
    @endphp

    <table>
        <tr>
            <td class="text-left bold">Total Belanja</td>
            <td class="text-end bold">Rp {{ number_format($total, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="text-left">Jumlah Dibayar</td>
            <td class="text-end">Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="text-left">Kembalian</td>
            <td class="text-end">Rp {{ number_format($payment->change ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="text-left">Metode</td>
            <td class="text-end">{{ ucfirst($payment->method ?? '-') }}</td>
        </tr>
    </table>

    <div class="double-line"></div>

    <div class="footer">
        <p><strong>Terima Kasih</strong></p>
        <small>~ D'Brownies ~</small>
        <small>Silakan datang kembali!</small>
    </div>

</body>
</html>
