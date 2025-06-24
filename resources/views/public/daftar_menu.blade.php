@extends('layouts.menu')

@section('title', 'Daftar Menu D.Brownies')

@section('style')
<style>
  body {
    background-color: #f8f9fa;
  }

  .category-title {
    font-weight: bold;
    font-size: 1.4rem;
    margin: 40px 0 20px;
    border-bottom: 3px solid #dc3545;
    padding-bottom: 8px;
    color: #dc3545;
  }

  .menu-card {
    border-radius: 15px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .menu-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 20px rgba(220, 53, 69, 0.35);
  }

  .menu-img-container {
    background-color: #fff0f1;
    aspect-ratio: 1 / 1;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    padding: 10px;
  }

  .menu-img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    border-radius: 12px;
    transition: transform 0.3s ease;
  }

  .menu-img-container:hover .menu-img {
    transform: scale(1.05);
  }

  .menu-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 6px;
    color: #333;
  }

  .menu-price {
    color: #dc3545;
    font-weight: 700;
    font-size: 1rem;
    margin-top: 6px;
  }

  .add-to-cart {
    background-color: #dc3545;
    border: none;
    font-weight: 600;
    transition: background-color 0.3s ease;
  }

  .add-to-cart:hover {
    background-color: #b02a37;
  }

  .cart-btn {
    position: fixed;
    right: 25px;
    bottom: 25px;
    z-index: 1050;
    background: #dc3545;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    box-shadow: 0 6px 15px rgba(220, 53, 69, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    transition: box-shadow 0.3s ease;
  }

  .cart-btn:hover {
    box-shadow: 0 10px 25px rgba(220, 53, 69, 0.7);
  }

  .badge-notification {
    position: absolute;
    top: -6px;
    right: -6px;
    background-color: #343a40;
    color: white;
    font-weight: 700;
    font-size: 0.75rem;
    padding: 3px 7px;
    border-radius: 50%;
  }

  /* Kategori Filter Button */
  #category-filters {
    gap: 12px;
  }

  .category-btn {
    border-radius: 999px;
    background-color: #e9ecef;
    color: #000;
    font-weight: 500;
    padding: 8px 20px;
    border: none;
    transition: all 0.3s ease;
  }

  .category-btn.active {
    background-color: #dc3545;
    color: #fff;
  }

  /* Responsive adjustments */
  @media (max-width: 576px) {
    .menu-title {
      font-size: 1rem;
    }

    .menu-price {
      font-size: 0.9rem;
    }

    .add-to-cart {
      font-size: 0.85rem;
      padding: 6px 0;
    }
  }
</style>
@endsection

@section('content')
<div class="container py-4">
  <div class="text-center mb-4">
    <h3 class="fw-bold mt-2">🍰 Daftar Menu D'Brownies</h3>
    <p class="text-muted">Pilih menu favorit Anda</p>
  </div>

  <!-- Header + Filter & Search Bar -->
<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <div>


        <!-- Filter Kategori -->
        <div class="d-flex flex-wrap gap-2" id="category-filters">
            <button class="btn category-btn active" data-filter="all">Semua</button>
            @foreach ($categories as $kategori)
                <button class="btn category-btn" data-filter="{{ strtolower($kategori->name) }}">{{ $kategori->name }}</button>
            @endforeach
        </div>
    </div>



  <!-- Daftar Menu -->
  <div id="menu-list">
    @foreach ($categories as $kategori)
      <div class="category-section mb-4" data-category="{{ strtolower($kategori->name) }}">
        <div class="category-title">{{ $kategori->name }}</div>
        <div class="row g-4">
          @foreach ($menus->where('category_id', $kategori->id) as $menu)
            <div class="col-6 col-sm-4 col-md-3">
              <div class="menu-card h-100">
                <div class="menu-img-container">
                  <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="menu-img">
                </div>
                <div class="p-3 text-center">
                  <div class="menu-title">{{ $menu->name }}</div>
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
  document.querySelectorAll('.category-btn').forEach(button => {
    button.addEventListener('click', function () {
      // Aktifkan tombol yang diklik
      document.querySelectorAll('.category-btn').forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');

      const filter = this.getAttribute('data-filter');
      const sections = document.querySelectorAll('.category-section');

      sections.forEach(section => {
        const category = section.getAttribute('data-category');
        if (filter === 'all' || filter === category) {
          section.style.display = 'block';
        } else {
          section.style.display = 'none';
        }
      });
    });
  });

</script>
@endsection
