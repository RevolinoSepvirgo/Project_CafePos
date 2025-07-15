@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="flex-grow-1 text-center">
                <h4 class="fw-bold mb-0 text-dark">📅Data Menu</h4>
            </div>

            @auth
                @if (auth()->user()->role === 'admin')
                    <div class="ms-3">
                        <a href="{{ route('menus.create') }}" class="btn btn-dark btn-sm">
                            <i class="bi bi-plus-circle"></i> Tambah Menu
                        </a>
                    </div>
                @endif
            @endauth
        </div>



        @foreach ($categories as $category)
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white fw-bold">
                    {{ $category->name }}
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead class="table-success">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Nama</th>
                                    <th class="text-end pe-5">Harga</th>
                                    <th class="ps-4" style="min-width: 90px;">Gambar</th>
                                    @auth
                                        @if (auth()->user()->role === 'admin')
                                            <th class="text-center" style="width: 140px;">Aksi</th>
                                        @endif
                                    @endauth
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($category->menus as $menu)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $menu->name }}</td>
                                        <td class="text-end pe-5">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                                        <td class="ps-4">
                                            @if ($menu->image)
                                                <img src="{{ asset('storage/' . $menu->image) }}" alt="gambar"
                                                    style="width:60px; height:60px; object-fit:cover; border-radius:6px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        @auth
                                            @if (auth()->user()->role === 'admin')
                                                <td class="text-center">
                                                    <a href="{{ route('menus.edit', $menu->id) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <form action="{{ route('menus.destroy', $menu->id) }}" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            @endif
                                        @endauth
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada menu di kategori ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
<style>
    h4.fw-bold {
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
</style>
