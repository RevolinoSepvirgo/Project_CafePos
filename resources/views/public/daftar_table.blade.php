@extends('layouts.menu')

@section('title', 'Daftar Meja - D.Brownies')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-danger">Meja Café D'Brownies</h2>
        <p class="text-muted">pantau status meja restoran</p>
    </div>

    <!-- Filter Controls -->
    <div class="row mb-4">
        <div class="col-md-6 mb-2">
            <div class="btn-group w-100" role="group">
                <button class="btn btn-danger" onclick="filterByLantai('all', this)">ALL</button>
                <button class="btn btn-outline-danger" onclick="filterByLantai('lantai-1', this)">Lantai 1</button>
                <button class="btn btn-outline-danger" onclick="filterByLantai('lantai-2', this)">Lantai 2</button>
                <button class="btn btn-outline-danger" onclick="filterByLantai('lantai-3', this)">Lantai 3 🚬</button>
            </div>
        </div>
    </div>

    @php
        $lantai1 = $tables->filter(fn($t) => str_starts_with(strtolower($t->name), 'a'))->take(10);
        $lantai2 = $tables->filter(fn($t) => str_starts_with(strtolower($t->name), 'b'))->take(10);
        $lantai3 = $tables->filter(fn($t) => str_starts_with(strtolower($t->name), 'c'))->take(10);
    @endphp

    <!-- Floor Sections -->
    <div class="floor-container">
        @foreach (['Lantai 1' => $lantai1, 'Lantai 2' => $lantai2, 'Lantai 3🚬' => $lantai3] as $lantai => $list)
            @php
                $classLantai = strtolower(str_replace([' ', '🚬'], ['-', ''], $lantai));
            @endphp

            <div class="floor-section mb-4" data-lantai="{{ $classLantai }}">
                <div class="floor-header bg-secondary text-white p-3 rounded-top">
                    <h5 class="mb-0 fw-bold">{{ $lantai }}</h5>
                </div>

                <div class="floor-body bg-white p-3 rounded-bottom">
                    <div class="row g-2">
                        @foreach($list as $table)
                            @php
                                $bgColor = match($table->status) {
                                    'kosong' => 'bg-success',
                                    'terisi' => 'bg-danger',
                                    'dipesan' => 'bg-warning',
                                    default => 'bg-secondary'
                                };
                                $textColor = $table->status == 'dipesan' ? 'text-dark' : 'text-white';
                            @endphp

                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 table-item"
                                 data-name="{{ strtolower($table->name) }}"
                                 data-status="{{ strtolower($table->status) }}">
                                <div class="table-card {{ $bgColor }} {{ $textColor }} p-2 rounded shadow-sm h-100">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="fw-bold">Meja {{ $table->name }}</div>
                                        <div class="badge bg-white {{ $textColor }}">--</div>
                                    </div>
                                    <div class="status-badge mt-1">{{ ucfirst($table->status) }}</div>
                                    @if($table->is_vip)
                                        <div class="vip-badge mt-1">VIP</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <!-- Special Areas -->
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="special-area bg-light p-2 rounded shadow-sm h-100 text-center">
                                <div class="text-danger mb-1">🧾</div>
                                <small class="text-muted">Meja Pemesan</small>
                            </div>
                        </div>

                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="special-area bg-light p-2 rounded shadow-sm h-100 text-center">
                                <div class="text-danger mb-1">🚪</div>
                                <small class="text-muted">Pintu Masuk</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Legend -->
<div class="legend-container mt-4 p-3 bg-light rounded text-center">
    <div class="d-inline-flex justify-content-center flex-wrap gap-3">
        <div class="legend-item">
            <span class="badge bg-success px-3 py-2">Kosong</span>
        </div>
        <div class="legend-item">
            <span class="badge bg-danger px-3 py-2">Terisi</span>
        </div>
        <div class="legend-item">
            <span class="badge bg-warning text-dark px-3 py-2">Dipesan</span>
        </div>
    </div>
</div>

</div>
@endsection

@section('style')
<style>
    .floor-container {
        background-color: #f8f9fa;
    }

    .floor-header {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .floor-body {
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .table-card {
        transition: all 0.2s ease;
        cursor: default;
        display: flex;
        flex-direction: column;
    }

    .status-badge {
        font-size: 0.75rem;
        opacity: 0.9;
    }

    .vip-badge {
        font-size: 0.7rem;
        background-color: rgba(255,255,255,0.2);
        padding: 0.15rem 0.3rem;
        border-radius: 0.25rem;
        display: inline-block;
    }

    .special-area {
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .table-card {
            padding: 0.5rem;
        }
    }
    .legend-container {
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.legend-item {
    margin: 0 10px;
}

.legend-item .badge {
    font-size: 0.85rem;
    font-weight: 500;
    border-radius: 0.5rem;
}

</style>
@endsection

@section('scripts')
<script>
    let currentLantai = 'all';

    function filterByLantai(lantai, btn) {
        currentLantai = lantai;
        document.querySelectorAll('.btn-group .btn').forEach(b => {
            b.classList.remove('btn-danger');
            b.classList.add('btn-outline-danger');
        });
        btn.classList.remove('btn-outline-danger');
        btn.classList.add('btn-danger');

        const sections = document.querySelectorAll('.floor-section');

        sections.forEach(section => {
            const sectionLantai = section.dataset.lantai;
            const matchLantai = currentLantai === 'all' || sectionLantai === currentLantai;
            section.style.display = matchLantai ? 'block' : 'none';
        });
    }
</script>
@endsection
