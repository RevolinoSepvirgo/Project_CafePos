@extends('layouts.app')

@section('title', 'Edit Pesanan')

@section('content')
    <div class="container-fluid mt-4">
        <form method="POST" action="{{ route('orders.update', $order->id) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Kiri: Menu -->
                <div class="col-md-8">
                    <h4 class="mb-3">📚 Daftar Menu</h4>
                    <div class="input-group mb-3">
                        <span class="input-group-text">🔍</span>
                        <input type="text" class="form-control" placeholder="Cari menu..." id="searchInput">
                    </div>

                    <div class="mb-3">
                        <button type="button" class="btn btn-sm btn-light category-btn active"
                            onclick="filterMenu('all')">Semua</button>
                        @php
                            $kategoriUnik = $menus->pluck('category.name')->unique()->filter();
                        @endphp
                        @foreach ($kategoriUnik as $cat)
                            <button type="button" class="btn btn-sm btn-light category-btn"
                                onclick="filterMenu('{{ strtolower($cat) }}')">{{ $cat }}</button>
                        @endforeach
                    </div>

                    <div class="row g-3" id="menu-list">
                        @foreach ($menus as $menu)
                            <div class="col-md-4 menu-card-wrapper"
                                data-category="{{ strtolower($menu->category->name ?? 'lainnya') }}">
                                <div class="menu-card"
                                    onclick="addToOrder({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }})">
                                    <div class="fw-bold">{{ $menu->name }}</div>
                                    <div class="text-muted">{{ $menu->category->name ?? 'Tanpa Kategori' }}</div>
                                    <div class="text-danger fw-semibold">Rp{{ number_format($menu->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Kanan: Panel Pesanan -->
                <div class="col-md-4">
                    <div class="order-panel">
                        <h5>🧾 Edit Pesanan</h5>
                        <div class="mb-2">
                            <label class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" name="customer_name"
                                value="{{ $order->customer_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Meja</label>
                            <select class="form-select" name="table_id" required>
                                <option value="">Pilih meja</option>
                                @foreach ($tables as $table)
                                    <option value="{{ $table->id }}"
                                        {{ $order->table_id == $table->id ? 'selected' : '' }}>{{ $table->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="order-list" class="mb-3 text-center text-muted">
                            Belum ada pesanan
                        </div>

                        <div id="order-items-container"></div>

                        <div class="order-summary mb-3">
                            Total Pesanan: <span id="totalHarga">Rp0</span>
                        </div>

                        <button class="btn btn-dark w-100">💾 Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        let order = [
            @foreach ($order->items as $item)
                {
                    id: {{ $item->menu_id }},
                    nama: "{{ $item->menu->name }}",
                    harga: {{ $item->menu->price }},
                    qty: {{ $item->quantity }}
                },
            @endforeach
        ];

        function addToOrder(id, nama, harga) {
            const item = order.find(i => i.id === id);
            if (item) {
                item.qty++;
            } else {
                order.push({
                    id,
                    nama,
                    harga,
                    qty: 1
                });
            }
            renderOrder();
        }

        function increaseQty(index) {
            order[index].qty++;
            renderOrder();
        }

        function decreaseQty(index) {
            if (order[index].qty > 1) {
                order[index].qty--;
            } else {
                order.splice(index, 1);
            }
            renderOrder();
        }

        function renderOrder() {
            const list = document.getElementById('order-list');
            const container = document.getElementById('order-items-container');
            const totalEl = document.getElementById('totalHarga');

            if (order.length === 0) {
                list.innerHTML = '<div class="text-center text-muted">Belum ada pesanan</div>';
                container.innerHTML = '';
                totalEl.textContent = 'Rp0';
                return;
            }

            list.innerHTML = '';
            let html = '';
            let hiddenInputs = '';
            let total = 0;

            order.forEach((item, index) => {
                const subtotal = item.qty * item.harga;
                total += subtotal;

                html += `<div class='order-item d-flex justify-content-between align-items-center mb-1'>
                <div class='flex-grow-1'>${item.nama}</div>
                <div class='d-flex align-items-center'>
                  <button type='button' class='btn btn-sm btn-outline-dark me-1' onclick='decreaseQty(${index})'>-</button>
                  <span>${item.qty}</span>
                  <button type='button' class='btn btn-sm btn-outline-dark ms-1' onclick='increaseQty(${index})'>+</button>
                </div>
                <div class='ms-3'>Rp${subtotal.toLocaleString('id-ID')}</div>
              </div>`;

                hiddenInputs += `
        <input type="hidden" name="menu[${item.id}]" value="${item.qty}">
      `;
            });

            list.innerHTML = html;
            container.innerHTML = hiddenInputs;
            totalEl.textContent = `Rp${total.toLocaleString('id-ID')}`;
        }

        function filterMenu(category) {
            document.querySelectorAll('.category-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            document.querySelectorAll('.menu-card-wrapper').forEach(card => {
                const cat = card.dataset.category;
                card.style.display = category === 'all' || cat === category ? 'block' : 'none';
            });
        }

        // Initial render
        renderOrder();
    </script>

    <style>
        .category-btn.active {
            background-color: #f0ad4e;
            color: #fff;
        }

        .menu-card {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 15px;
            cursor: pointer;
            transition: box-shadow 0.2s;
        }

        .menu-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .order-panel {
            background: #ffc107;
            border-radius: 10px;
            padding: 20px;
            color: #212529;
        }

        .order-panel h5 {
            font-weight: bold;
        }

        .order-item {
            border-bottom: 1px solid #ddd;
            padding: 5px 0;
        }

        .order-summary {
            font-weight: bold;
        }
    </style>
@endsection
