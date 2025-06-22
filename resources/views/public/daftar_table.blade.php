<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Meja - D'Brownies</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .title {
            font-weight: bold;
            margin-bottom: 30px;
        }
        .table-seat {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s;
            cursor: pointer;
        }
        .table-seat:hover {
            transform: translateY(-3px);
        }
        .seat-label {
            font-weight: 600;
            font-size: 14px;
        }
        .status-label {
            font-size: 12px;
        }
        .legend .badge {
            margin-right: 10px;
            font-size: 14px;
        }
        .grid-wrapper {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 16px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <h3 class="text-center title">Susunan Meja Cafe</h3>

    <div class="grid-wrapper mb-4">
        @foreach($tables as $table)
            @php
                $status = $table->status;
                $bgColor = match($status) {
                    'kosong' => 'bg-success text-white',
                    'terisi' => 'bg-danger text-white',
                    'dipesan' => 'bg-warning text-dark',
                    default => 'bg-secondary text-white'
                };
            @endphp
            <div class="table-seat {{ $bgColor }}">
                <div class="seat-label">Meja {{ $table->name }}</div>
                <div class="status-label">({{ ucfirst($status) }})</div>
                <small>{{ $table->capacity }} orang</small>
            </div>
        @endforeach
    </div>

    @if($tables->isEmpty())
        <div class="alert alert-info text-center">
            Tidak ada data meja tersedia saat ini.
        </div>
    @endif

    <div class="legend text-center mt-4">
        <span class="badge bg-success">Kosong</span>
        <span class="badge bg-danger">Terisi</span>
        <span class="badge bg-warning text-dark">Dipesan</span>
    </div>
</div>

</body>
</html>
