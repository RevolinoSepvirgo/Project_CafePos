@extends('layouts.app')

@section('title', 'Input Pesanan')

@section('content')
    <style>
        body {
            background-color: #f8f9fa;
        }

        h4, h5 {
            font-weight: bold;
        }

        .category-btn.active {
            background-color: #0d6efd;
            color: #fff;
        }

        .menu-card {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .menu-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .order-panel {
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .order-panel h5 {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .order-item {
            border-bottom: 1px solid #dee2e6;
            padding: 8px 0;
        }

        .order-summary {
            font-weight: bold;
            font-size: 1.1rem;
        }

        .input-group-text {
            background-color: #fff;
        }

        .btn-outline-dark {
            font-size: 0.9rem;
        }

        .btn-dark {
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        select.form-select,
        input.form-control {
            border-radius: 10px;
        }

        @media (max-width: 767px) {
            .menu-card {
                padding: 12px;
            }

            .order-panel {
                margin-top: 20px;
            }
        }
    </style>

    <div class="container-fluid mt-4">
        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
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
                        @php $kategoriUnik = $menus->pluck('category.name')->unique()->filter(); @endphp
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
                                    <div class="text-danger fw-semibold">Rp{{ number_format($menu->price, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Kanan: Panel Pesanan -->
                <div class="col-md-4 mt-4 mt-md-0">
                    <div class="order-panel">
                        <h5>🧾 Order Baru</h5>
                        <div class="mb-2">
                            <label class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" name="customer_name" placeholder="Nama pelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Meja</label>
                            <select class="form-select" name="table_id" required>
                                <option value="">Pilih meja</option>
                                @foreach ($tables as $table)
                                    <option value="{{ $table->id }}">{{ $table->name }}</option>
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

                        <button class="btn btn-dark w-100">🚀 Proses Pesanan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        let order = [];

        function addToOrder(id, nama, harga) {
            const item = order.find(i => i.id === id);
            if (item) {
                item.qty++;
            } else {
                order.push({ id, nama, harga, qty: 1 });
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
                    <input type="hidden" name="items[${index}][menu_id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][quantity]" value="${item.qty}">
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
    </script>
@endsection
