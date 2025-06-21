<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Menu</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('aset/logo/logo db.png') }}" sizes="32x32" />
  <link rel="icon" type="image/png" href="{{ asset('aset/logo/logo db.png') }}" sizes="16x16" />
  <style>
    body {
      background-color: #f7f7f9;
      font-family: 'Segoe UI', sans-serif;
    }

    .menu-card {
      background: #fff;
      border-radius: 12px;
      padding: 15px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
      margin-bottom: 16px;
      transition: all 0.2s ease;
    }

    .menu-card:hover {
      transform: scale(1.01);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .menu-img {
      width: 90px;
      height: 90px;
      object-fit: cover;
      border-radius: 10px;
      margin-right: 16px;
    }

    .btn-add {
      border-radius: 50%;
      width: 36px;
      height: 36px;
      font-weight: bold;
      padding: 0;
    }

    .menu-title {
      font-weight: 600;
      margin-bottom: 4px;
    }

    .menu-desc {
      font-size: 0.9rem;
      color: #666;
    }

    .menu-price {
      color: #dc3545;
      font-weight: 600;
      margin-top: 6px;
    }

    .category-header {
      font-weight: bold;
      font-size: 1.2rem;
      margin: 40px 0 20px;
      border-bottom: 2px solid #ddd;
      padding-bottom: 6px;
    }
  </style>
</head>
<body>

<div class="container py-4">
    <div class="text-center mb-4">
        <img src="{{ asset('aset/logo/logo db.png') }}" alt="Logo" style="width: 60px;">
        <h2 class="fw-bold mt
  <h3 class="fw-bold mb-4 text-center">🍛 Daftar Menu D'Brownies</h3>

  <!-- Filter & Search -->
  <div class="row mb-4">
    <div class="col-md-6 mb-2">
      <input type="text" id="searchInput" class="form-control" placeholder="🔍 Cari menu..." onkeyup="filterMenu()">
    </div>
    <div class="col-md-6 mb-2">
      <select id="categoryFilter" class="form-select" onchange="filterMenu()">
        <option value="all">📂 Semua Kategori</option>
        @foreach ($categories as $kategori)
          <option value="{{ strtolower($kategori->name) }}">{{ $kategori->name }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <!-- Menu List by Category -->
  <div id="menu-list">
    @foreach ($categories as $kategori)
      <div class="category-section" data-category="{{ strtolower($kategori->name) }}">
        <div class="category-header">{{ $kategori->name }}</div>

        @foreach ($menus->where('category_id', $kategori->id) as $menu)
          <div class="menu-card d-flex" data-kategori="{{ strtolower($menu->category->name) }}">
            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="menu-img">
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between">
                <div>
                  <div class="menu-title">{{ $menu->name }}</div>
                  <div class="menu-desc">{{ $menu->category->name }}</div>
                </div>
                <button class="btn btn-success btn-add">+</button>
              </div>
              <div class="menu-price">Rp{{ number_format($menu->price, 0, ',', '.') }}</div>
            </div>
          </div>
        @endforeach

      </div>
    @endforeach
  </div>
</div>

<!-- Filter Script -->
<script>
  function filterMenu() {
    const searchInput = document.getElementById("searchInput").value.toLowerCase();
    const selectedCategory = document.getElementById("categoryFilter").value;
    const menuCards = document.querySelectorAll(".menu-card");
    const categorySections = document.querySelectorAll(".category-section");

    categorySections.forEach(section => {
      let visibleInSection = false;
      const cards = section.querySelectorAll(".menu-card");

      cards.forEach(card => {
        const kategori = card.getAttribute("data-kategori");
        const title = card.querySelector(".menu-title").textContent.toLowerCase();
        const desc = card.querySelector(".menu-desc").textContent.toLowerCase();
        const matchSearch = title.includes(searchInput) || desc.includes(searchInput);
        const matchKategori = selectedCategory === "all" || selectedCategory === kategori;

        const show = matchSearch && matchKategori;
        card.style.display = show ? "flex" : "none";

        if (show) visibleInSection = true;
      });

      section.style.display = visibleInSection ? "block" : "none";
    });
  }
</script>

</body>
</html>
