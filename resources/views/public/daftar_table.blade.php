@extends('layouts.menu')

@section('title', 'Daftar Meja - D\'Brownies')

@section('content')
<div class="container py-5">
    <h3 class="text-center title"> Meja Café D'Brownies</h3>

    <!-- Filter Lantai -->
    <div class="text-center mb-3">
    <div class="btn-group" role="group">
        <button class="btn btn-secondary " onclick="filterByLantai('all', this)">ALL</button>
        <button class="btn btn-outline-secondary" onclick="filterByLantai('lantai-1', this)">Lantai 1</button>
        <button class="btn btn-outline-secondary" onclick="filterByLantai('lantai-2', this)">Lantai 2</button>
        <button class="btn btn-outline-secondary" onclick="filterByLantai('lantai-3', this)">Lantai 3 🚬</button>
    </div>
</div>

    <!-- Filter Pencarian -->
    <div class="mb-4 text-end">
        <input type="text" id="searchInput" class="form-control w-100 w-md-50 mx-auto" placeholder="🔍 Cari meja (nama/status)..." onkeyup="filterTables()">
    </div>

    @php
        $lantai1 = $tables->filter(fn($t) => str_starts_with(strtolower($t->name), 'a'))->take(10);
        $lantai2 = $tables->filter(fn($t) => str_starts_with(strtolower($t->name), 'b'))->take(10);
        $lantai3 = $tables->filter(fn($t) => str_starts_with(strtolower($t->name), 'c'))->take(10);
    @endphp

    @foreach (['Lantai 1' => $lantai1, 'Lantai 2' => $lantai2, 'Lantai 3🚬' => $lantai3] as $lantai => $list)
        @php
            $classLantai = strtolower(str_replace([' ', '🚬'], ['-', ''], $lantai)); // lantai-1, lantai-2, lantai-3
        @endphp
        <div class="floor-section mb-5" data-lantai="{{ $classLantai }}">
            <h5 class="fw-bold text-center mb-3">{{ $lantai }}</h5>
            <div class="row g-2 justify-content-center align-items-center">

                @foreach($list as $table)
                    @php
                        $bgColor = match($table->status) {
                            'kosong' => 'bg-success text-white',
                            'terisi' => 'bg-danger text-white',
                            'dipesan' => 'bg-warning text-dark',
                            default => 'bg-secondary text-white'
                        };
                    @endphp
                    <div class="col-6 col-sm-3 col-md-2 table-item" data-name="{{ strtolower($table->name) }}" data-status="{{ strtolower($table->status) }}">
                        <div class="table-seat {{ $bgColor }}">
                            <div class="seat-label">Meja {{ $table->name }}</div>
                            <div class="status-label">({{ ucfirst($table->status) }})</div>
                            <small>{{ $table->capacity }} org</small>
                        </div>
                    </div>
                @endforeach

                <!-- Kolom ke-11: Meja Pemesan -->
                <div class="col-6 col-sm-3 col-md-2">
                    <div class="pemesanan text-center">
                        <div class="badge bg-light text-dark p-3 shadow-sm">
                            🧾<br>Meja<br>Pemesan
                        </div>
                    </div>
                </div>

                <!-- Kolom ke-12: Pintu Masuk -->
                <div class="col-6 col-sm-3 col-md-2">
                    <div class="pintu text-center">
                        <div class="badge bg-light text-dark p-3 shadow-sm">
                            🟤<br>Pintu<br>Masuk
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endforeach

    <!-- Legenda -->
    <div class="legend text-center mt-4">
        <span class="badge bg-success">Kosong</span>
        <span class="badge bg-danger">Terisi</span>
        <span class="badge bg-warning text-dark">Dipesan</span>
    </div>
</div>
@endsection

@section('style')
<style>
    .title {
        font-weight: bold;
        margin-bottom: 30px;
    }

    .table-seat {
        height: 80px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        box-shadow: 0 3px 6px rgba(0,0,0,0.05);
        transition: transform 0.2s;
        cursor: pointer;
        text-align: center;
        padding: 4px;
        font-size: 0.85rem;
    }

    .table-seat:hover {
        transform: translateY(-2px);
    }

    .seat-label {
        font-weight: 600;
        font-size: 13px;
    }

    .status-label {
        font-size: 11px;
    }

    .legend .badge {
        margin: 0 6px;
        font-size: 14px;
        padding: 6px 10px;
    }

    .floor-section {
        border-bottom: 1px solid #ddd;
        padding-bottom: 20px;
    }

    .pintu, .pemesanan {
        min-height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .badge {
        font-size: 0.75rem;
        line-height: 1.3;
    }

    @media (max-width: 576px) {
        .seat-label, .status-label {
            font-size: 12px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
  let currentLantai = 'all';

  function filterTables() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const sections = document.querySelectorAll('.floor-section');

    sections.forEach(section => {
      const sectionLantai = section.dataset.lantai;
      const matchLantai = currentLantai === 'all' || sectionLantai === currentLantai;

      let hasVisible = false;
      section.querySelectorAll('.table-item').forEach(item => {
        const name = item.dataset.name;
        const status = item.dataset.status;
        const matchSearch = name.includes(input) || status.includes(input);

        const show = matchSearch;
        item.style.display = show ? 'block' : 'none';
        if (matchSearch) hasVisible = true;
      });

      section.style.display = matchLantai && hasVisible ? 'block' : 'none';
    });
  }

  function filterByLantai(lantai, btn) {
    currentLantai = lantai;
    document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    filterTables();
  }
</script>
@endsection
