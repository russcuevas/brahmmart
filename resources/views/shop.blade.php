<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brahmmart</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/customers/shop.css') }}">
</head>

<body>

    {{-- ===== NAVBAR ===== --}}
    <nav class="shop-nav">
        <a href="/" class="shop-nav-brand">
            <img src="{{ asset('favicon.png') }}" alt="BRAHMMART">
            <span class="shop-logo-text">BRAHMMART</span>
        </a>

        <div class="shop-nav-actions">
            <button class="shop-filter-toggle" id="shopFilterToggle" title="Filter Settings">
                <i class="fas fa-cog"></i>
            </button>
            <button class="shop-nav-icon" id="cartToggleBtn" aria-label="Cart">
                <i class="fas fa-bag-shopping"></i>
                <span class="cart-count">2</span>
            </button>
            <a href="/login" class="shop-nav-icon" aria-label="Account">
                <i class="fas fa-user"></i>
            </a>

        </div>
    </nav>

    <div class="shop-container">
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        {{-- ===== SIDEBAR ===== --}}
        <aside class="shop-sidebar" id="shopSidebar">
            <div class="sidebar-header">
                <h3>Filters</h3>
                <button class="sidebar-close" id="sidebarClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="sidebar-section">
                <h3 class="sidebar-title">Product Categories</h3>
                <ul class="category-list">
                    <li>
                        <a href="{{ route('shop.page', ['category' => 'all']) }}"
                            class="{{ !request('category') || request('category') == 'all' ? 'active' : '' }}">
                            All Products
                        </a>
                    </li>
                    @foreach ($categories as $cat)
                        <li>
                            <a href="{{ route('shop.page', ['category' => $cat->category_name]) }}"
                                class="{{ request('category') == $cat->category_name ? 'active' : '' }}">
                                {{ $cat->category_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="sidebar-section">
                <h3 class="sidebar-title">Filter by Price</h3>
                <div class="price-range">
                    <input type="range" min="0" max="5000" value="{{ request('max_price', 2500) }}"
                        class="slider" id="priceSlider">
                    <div class="price-labels">
                        <span>₱0</span>
                        <span id="priceValue">₱{{ number_format(request('max_price', 2500)) }}+</span>
                    </div>
                </div>
            </div>
        </aside>

        {{-- ===== MAIN CONTENT ===== --}}
        <main class="shop-main">
            <div class="shop-header">
                <div class="shop-header-top">
                    <div class="breadcrumb">
                        <a href="/">Home</a>
                        <i class="fas fa-chevron-right"></i>
                        <span class="current">Shop</span>
                    </div>
                </div>

                <div class="shop-action-bar">
                    <form action="{{ route('shop.page') }}" method="GET" class="shop-search-wrapper">
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" class="shop-search-input" value="{{ request('search') }}"
                            placeholder="Search for uniforms, books, supplies...">
                        <button type="submit" class="search-btn">Search</button>
                    </form>
                    <div class="shop-utils">
                        <span class="results-count">Showing {{ count($products) }} products</span>
                        <select class="sort-select">
                            <option>Default Sorting</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Newest Arrivals</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="product-grid">
                @forelse ($products as $product)
                    @php
                        $images = json_decode($product->product_image, true);
                        $displayImage = !empty($images) ? asset($images[0]) : asset('favicon.png');
                    @endphp
                    <div class="product-card">
                        <div class="product-img">
                            <img src="{{ $displayImage }}" alt="{{ $product->product_name }}">
                            <div class="product-actions">
                                <button title="Quick View" onclick="location.href='/product/{{ $product->id }}'"><i
                                        class="far fa-eye"></i></button>
                                @if (!$product->has_variant)
                                    <button title="Add to Cart"><i class="fas fa-cart-plus"></i></button>
                                @endif
                            </div>
                        </div>
                        <div class="product-info">
                            <span class="product-cat">{{ $product->category_name }}</span>
                            <h4 class="product-name">{{ $product->product_name }}</h4>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>(0)</span>
                            </div>
                            <div class="product-price">
                                @if ($product->has_variant)
                                    <span
                                        style="font-size: 12px; color: var(--text-muted); font-weight: 400;">From</span>
                                @endif
                                ₱{{ number_format($product->display_price, 2) }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--text-muted);">
                        <i class="fas fa-box-open"
                            style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.5;"></i>
                        <h3 style="font-size: 1.5rem; color: var(--text-dark);">No Product displayed</h3>
                        <p>We're currently restocking our inventory. Please check back later!</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>

    {{-- ===== CART DRAWER ===== --}}
    <div class="cart-drawer-overlay" id="cartOverlay"></div>
    <div class="cart-drawer" id="cartDrawer">
        <div class="cart-drawer-header">
            <div class="cart-header-left">
                <h3>Shopping Bag</h3>
                <span class="cart-badge-count">2 Items</span>
            </div>
            <button class="cart-drawer-close" id="cartClose">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="cart-drawer-items">
            <!-- Item 1 -->
            <div class="cart-item">
                <div class="cart-item-img">
                    <img src="{{ asset('assets/images/polo-girl/1.jpeg') }}" alt="Product">
                </div>
                <div class="cart-item-info">
                    <div class="cart-item-top">
                        <h4>UB Type A Female Blouse</h4>
                        <button class="cart-item-remove"><i class="fas fa-trash-can"></i></button>
                    </div>
                    <span class="cart-item-variant">Size: M</span>
                    <div class="cart-item-bottom">
                        <div class="cart-item-qty">
                            <button class="qty-btn-cart"><i class="fas fa-minus"></i></button>
                            <span>1</span>
                            <button class="qty-btn-cart"><i class="fas fa-plus"></i></button>
                        </div>
                        <div class="cart-item-price">₱620.00</div>
                    </div>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="cart-item">
                <div class="cart-item-img">
                    <img src="{{ asset('assets/images/palda-girl/piece.jpeg') }}" alt="Product">
                </div>
                <div class="cart-item-info">
                    <div class="cart-item-top">
                        <h4>UB Official School Skirt</h4>
                        <button class="cart-item-remove"><i class="fas fa-trash-can"></i></button>
                    </div>
                    <span class="cart-item-variant">Size: M</span>
                    <div class="cart-item-bottom">
                        <div class="cart-item-qty">
                            <button class="qty-btn-cart"><i class="fas fa-minus"></i></button>
                            <span>1</span>
                            <button class="qty-btn-cart"><i class="fas fa-plus"></i></button>
                        </div>
                        <div class="cart-item-price">₱380.00</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cart-drawer-footer">
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>₱1,000.00</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span class="free-shipping">FREE</span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span>₱1,000.00</span>
                </div>
            </div>
            <div class="cart-actions">
                <button class="btn-checkout-cart">Checkout Now</button>
                <button class="btn-continue-shopping" id="continueShopping">Continue Shopping</button>
            </div>
        </div>
    </div>

    <script>
        // ===== SIDEBAR TOGGLE =====
        const filterToggle = document.getElementById('shopFilterToggle');
        const sidebar = document.getElementById('shopSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const closeSidebar = document.getElementById('sidebarClose');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
        }

        if (filterToggle) filterToggle.addEventListener('click', toggleSidebar);
        if (overlay) overlay.addEventListener('click', toggleSidebar);
        if (closeSidebar) closeSidebar.addEventListener('click', toggleSidebar);

        // Mobile Nav Toggle (assuming it exists in header)
        const mobileToggle = document.getElementById('shopMobileToggle');
        if (mobileToggle) {
            mobileToggle.addEventListener('click', () => {
                // Handle mobile menu toggle if needed
            });
        }

        // ===== CART DRAWER =====
        const cartToggleBtn = document.getElementById('cartToggleBtn');
        const cartDrawer = document.getElementById('cartDrawer');
        const cartOverlay = document.getElementById('cartOverlay');
        const cartClose = document.getElementById('cartClose');
        const continueShopping = document.getElementById('continueShopping');

        function toggleCart() {
            cartDrawer.classList.toggle('active');
            cartOverlay.classList.toggle('active');
            document.body.style.overflow = cartDrawer.classList.contains('active') ? 'hidden' : '';
        }

        if (cartToggleBtn) cartToggleBtn.addEventListener('click', toggleCart);
        if (cartClose) cartClose.addEventListener('click', toggleCart);
        if (cartOverlay) cartOverlay.addEventListener('click', toggleCart);
        if (continueShopping) continueShopping.addEventListener('click', toggleCart);

        // ===== PRICE SLIDER DYNAMIC UPDATE =====
        const priceSlider = document.getElementById('priceSlider');
        const priceValue = document.getElementById('priceValue');

        if (priceSlider && priceValue) {
            priceSlider.addEventListener('input', (e) => {
                const value = parseInt(e.target.value).toLocaleString();
                priceValue.textContent = `₱${value}+`;
            });

            priceSlider.addEventListener('change', (e) => {
                const maxPrice = e.target.value;
                const url = new URL(window.location.href);
                url.searchParams.set('max_price', maxPrice);
                window.location.href = url.toString();
            });
        }
    </script>
</body>

</html>
