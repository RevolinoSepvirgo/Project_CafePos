@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header bg-success text-white fw-bold">
        Data Meja
        <a href="{{ route('tables.create') }}" class="btn btn-light btn-sm float-end">
            <i class="bi bi-plus-circle"></i> Tambah Meja
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead class="table-success">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Meja</th>
                        <th>Kapasitas</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tables as $table)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $table->name }}</td>
                            <td>{{ $table->capacity }} orang</td>
                            <td>
                                <form action="{{ route('tables.changeStatus', $table->id) }}" method="POST" class="d-flex align-items-center">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm me-2" style="width: 110px;">
                                        <option value="kosong" {{ $table->status == 'kosong' ? 'selected' : '' }}>Kosong</option>
                                        <option value="terisi" {{ $table->status == 'terisi' ? 'selected' : '' }}>Terisi</option>
                                        <option value="dipesan" {{ $table->status == 'dipesan' ? 'selected' : '' }}>Dipesan</option>
                                    </select>
                                    @php
                                        $badgeColor = match($table->status) {
                                            'kosong' => 'success',
                                            'terisi' => 'danger',
                                            'dipesan' => 'warning',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badgeColor }}">
                                        {{ ucfirst($table->status) }}
                                    </span>
                                </form>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('tables.edit', $table->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('tables.destroy', $table->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus meja ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data meja.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
