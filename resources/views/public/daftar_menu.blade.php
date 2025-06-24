@extends('layouts.menu')

@section('title', 'Daftar Menu D.Brownies')

@section('style')
<style>
  body {
    background-color: #f8f9fa;
  }

  .category-title {
    font-weight: bold;
    font-size: 1.2rem;
    margin: 40px 0 20px;
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 6px;
  }

  .menu-card {
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.2s ease;
    background: #fff;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
  }

  .menu-card:hover {
    transform: scale(1.02);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
  }

  .menu-img-container {
    background-color: #ffffff;
    aspect-ratio: 1 / 1;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .menu-img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    padding: 8px;
  }

  .menu-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 4px;
  }

  .menu-category {
    font-size: 0.85rem;
    color: #777;
  }

  .menu-price {
    color: #dc3545;
    font-weight: bold;
    margin-top: 8px;
    font-size: 0.95rem;
  }
</style>
@endsection

@section('content')
<div class="container py-4">

  <!-- Header -->
  <div class="text-center mb-4">
    <h3 class="fw-bold mt-2">🍰 Daftar Menu D'Brownies</h3>
    <p class="text-muted">Lihat dan pilih menu favorit Anda!</p>
  </div>

  <!-- Search & Filter -->
  <div class="row mb-4">
    <div class="col-md-6 mb-2">
      <input type="text" id="searchInput" class="form-control" placeholder="🔍 Cari menu..." onkeyup="filterMenu()">
    </div>
    <div class="col-md-6 mb-2">
      <select id="categoryFilter" class="form-select" onchange="filterMenu()">
        <option value="all">🍰 Semua Kategori</option>
        @foreach ($categories as $kategori)
          <option value="{{ strtolower($kategori->name) }}">{{ $kategori->name }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <!-- Menu List by Category -->
  <div id="menu-list">
    @foreach ($categories as $kategori)
      <div class="category-section mb-3" data-category="{{ strtolower($kategori->name) }}">
        <div class="category-title">{{ $kategori->name }}</div>
        <div class="row g-3">
          @foreach ($menus->where('category_id', $kategori->id) as $menu)
            <div class="col-6 col-sm-4 col-md-3 col-lg-3">
              <div class="menu-card">
                <div class="menu-img-container">
                  <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="menu-img">
                </div>
                <div class="p-3 text-center">
                  <div class="menu-title">{{ $menu->name }}</div>
                  <div class="menu-category">{{ $menu->category->name }}</div>
                  <div class="menu-price">Rp{{ number_format($menu->price, 0, ',', '.') }}</div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection

@section('scripts')
<script>
  function filterMenu() {
    const searchInput = document.getElementById("searchInput").value.toLowerCase();
    const selectedCategory = document.getElementById("categoryFilter").value;
    const categorySections = document.querySelectorAll(".category-section");

    categorySections.forEach(section => {
      let visible = false;
      const cards = section.querySelectorAll(".menu-card");

      cards.forEach(card => {
        const title = card.querySelector(".menu-title").textContent.toLowerCase();
        const category = section.getAttribute("data-category");
        const matchSearch = title.includes(searchInput);
        const matchCategory = selectedCategory === "all" || selectedCategory === category;
        const show = matchSearch && matchCategory;

        card.parentElement.style.display = show ? "block" : "none";
        if (show) visible = true;
      });

      section.style.display = visible ? "block" : "none";
    });
  }
</script>
@endsection
