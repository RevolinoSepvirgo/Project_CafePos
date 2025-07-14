@extends('layouts.app')

@section('title', 'Input Pesanan')

@section('content')
    <style>
        body {
            background-color: #f1f1f1;
        }

        h4, h5 {
            font-weight: bold;
        }

        .category-btn.active {
            background-color: #070808;
            color: #fff;
        }

        .menu-card {
            background: #fff;
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .menu-card:hover {
            background-color: #f8f9fa;
            transform: scale(1.02);
        }

        .order-panel {
            background: #fff;
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .order-item {
            border-bottom: 1px dashed #ced4da;
            padding: 6px 0;
        }

        .order-summary {
            font-weight: bold;
            font-size: 1.1rem;
        }

        .input-group-text {
            background-color: #f8f9fa;
        }

        .btn-outline-secondary {
            font-size: 0.9rem;
        }

        .btn-success {
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        select.form-select,
        input.form-control {
            border-radius: 6px;
        }

        .text-muted {
            font-size: 0.9rem;
        }
    </style>

    <div class="container-fluid mt-3">
        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <div class="row">
                <!-- Menu -->
                <div class="col-md-8">
                    <h4 class="mb-3 text-dark"><i class="bi bi-journal-text me-2"></i>Menu Tersedia</h4>

                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Cari menu..." id="searchInput">
                    </div>

                    <div class="mb-3">
                        <button type="button" class="btn btn-sm btn-outline-secondary category-btn active" onclick="filterMenu('all')">Semua</button>
                        @php $kategoriUnik = $menus->pluck('category.name')->unique()->filter(); @endphp
                        @foreach ($kategoriUnik as $cat)
                            <button type="button" class="btn btn-sm btn-outline-secondary category-btn" onclick="filterMenu('{{ strtolower($cat) }}')">{{ $cat }}</button>
                        @endforeach
                    </div>

                    <div class="row g-3" id="menu-list">
                        @foreach ($menus as $menu)
                            <div class="col-md-4 menu-card-wrapper" data-category="{{ strtolower($menu->category->name ?? 'lainnya') }}">
                                <div class="menu-card" onclick="addToOrder({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }})">
                                    <div class="fw-bold">{{ $menu->name }}</div>
                                    <div class="text-muted">{{ $menu->category->name ?? 'Tanpa Kategori' }}</div>
                                    <div class="text-success fw-semibold">Rp{{ number_format($menu->price, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Panel -->
                <div class="col-md-4 mt-4 mt-md-0">
                    <div class="order-panel">
                        <h5 class="mb-3"><i class="bi bi-clipboard-plus me-2"></i>Pesanan Pelanggan</h5>

                        <div class="mb-3">
                            <label class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" name="customer_name" placeholder="" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor Meja</label>
                            <select class="form-select" name="table_id" required>
                                <option value="">Pilih Meja</option>
                                @foreach ($tables as $table)
                                    <option value="{{ $table->id }}">{{ $table->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="order-list" class="mb-3 text-muted text-center">
                            Belum ada item pesanan.
                        </div>

                        <div id="order-items-container"></div>

                        <div class="order-summary mb-3">
                            Total: <span id="totalHarga">Rp0</span>
                        </div>

                        <button class="btn btn-success w-100"><i class="bi bi-send-check me-1"></i> Proses Pesanan</button>
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
                list.innerHTML = '<div class="text-muted text-center">Belum ada item pesanan.</div>';
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

                html += `<div class='order-item d-flex justify-content-between align-items-center'>
                    <div>${item.nama}</div>
                    <div class='d-flex align-items-center'>
                        <button type='button' class='btn btn-sm btn-outline-secondary me-1' onclick='decreaseQty(${index})'>-</button>
                        <span>${item.qty}</span>
                        <button type='button' class='btn btn-sm btn-outline-secondary ms-1' onclick='increaseQty(${index})'>+</button>
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
