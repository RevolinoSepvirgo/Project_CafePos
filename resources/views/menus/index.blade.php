@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header bg-success text-white fw-bold">
        Data Menu
        <a href="{{ route('menus.create') }}" class="btn btn-light btn-sm float-end">
            <i class="bi bi-plus-circle"></i> Tambah Menu
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead class="table-success">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th class="text-end pe-5">Harga</th> <!-- Lebih lebar -->
                        <th class="ps-4" style="min-width: 90px;">Gambar</th> <!-- Tambah padding kiri -->
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $menu->name }}</td>
                            <td>{{ $menu->category->name ?? '-' }}</td>
                            <td class="text-end pe-5">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                            <td class="ps-4">
                                @if($menu->image)
                                    <img src="{{ asset('storage/' . $menu->image) }}" alt="gambar"
                                         style="width:60px; height:60px; object-fit:cover; border-radius:6px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
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
                            <td colspan="6" class="text-center text-muted">Belum ada data menu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
