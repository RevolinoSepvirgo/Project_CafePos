@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header bg-success text-white fw-bold">
        Tambah Meja
        <a href="{{ route('tables.index') }}" class="btn btn-light btn-sm float-end">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('tables.store') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama Meja</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="capacity" class="form-label">Kapasitas</label>
                <input type="number" name="capacity" id="capacity" class="form-control" required min="1" value="4">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="kosong">Kosong</option>
                    <option value="dipesan">Dipesan</option>
                    <option value="terisi">Terisi</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Simpan
            </button>
        </form>
    </div>
</div>
@endsection
