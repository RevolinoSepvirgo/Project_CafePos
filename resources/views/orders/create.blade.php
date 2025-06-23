@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tambah Pesanan</h4>

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf

        <div class="mb-3">
            <label for="customer_name">Atas Nama</label>
            <input type="text" name="customer_name" class="form-control" placeholder="Contoh: Budi" required>
        </div>

        <div class="mb-3">
            <label for="table_id">Pilih Meja</label>
            <select name="table_id" class="form-control" required>
                @foreach($tables as $table)
                    <option value="{{ $table->id }}">{{ $table->name }}</option>
                @endforeach
            </select>
        </div>

        <div id="items-container">
            <div class="row mb-2 item-row">
                <div class="col-md-6">
                    <select name="items[0][menu_id]" class="form-control" required>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="items[0][quantity]" class="form-control" placeholder="Qty" min="1" required>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-danger remove-item">Hapus</button>
                </div>
            </div>
        </div>

        <button type="button" id="add-item" class="btn btn-secondary mb-3">+ Tambah Menu</button>
        <br>
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
let index = 1;
document.getElementById('add-item').addEventListener('click', function () {
    const container = document.getElementById('items-container');
    const row = document.createElement('div');
    row.classList.add('row', 'mb-2', 'item-row');
    row.innerHTML = `
        <div class="col-md-6">
            <select name="items[${index}][menu_id]" class="form-control" required>
                @foreach($menus as $menu)
                    <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="items[${index}][quantity]" class="form-control" placeholder="Qty" min="1" required>
        </div>
        <div class="col-md-3">
            <button type="button" class="btn btn-danger remove-item">Hapus</button>
        </div>
    `;
    container.appendChild(row);
    index++;
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-item')) {
        e.target.closest('.item-row').remove();
    }
});
</script>
@endsection
