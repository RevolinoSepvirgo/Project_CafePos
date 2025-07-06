@extends('layouts.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header bg-warning text-white fw-bold">
            Edit Meja
            <a href="{{ route('tables.index') }}" class="btn btn-light btn-sm float-end">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('tables.update', $table->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Meja</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $table->name }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="capacity" class="form-label">Kapasitas</label>
                    <input type="number" name="capacity" id="capacity" class="form-control" value="{{ $table->capacity }}"
                        required min="1">
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="kosong" {{ $table->status == 'kosong' ? 'selected' : '' }}>Kosong</option>
                        <option value="dipesan" {{ $table->status == 'dipesan' ? 'selected' : '' }}>Dipesan</option>
                        <option value="terisi" {{ $table->status == 'terisi' ? 'selected' : '' }}>Terisi</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Update
                </button>
            </form>
        </div>
    </div>
@endsection
