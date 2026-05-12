<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Brahmmart</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/customers/shop.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* ===== VARIANT MODAL STYLES ===== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .variant-modal {
            background: #fff;
            width: 90%;
            max-width: 480px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            transform: translateY(20px);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .modal-overlay.active {
            display: flex;
            opacity: 1;
        }

        .modal-overlay.active .variant-modal {
            transform: translateY(0);
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            color: #752738;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .modal-close {
            background: #f5f5f5;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #666;
            transition: 0.2s;
        }

        .modal-close:hover {
            background: #eee;
            color: #333;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-product-info {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .modal-product-info img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .modal-info-text h4 {
            margin: 0 0 4px 0;
            font-size: 1.1rem;
            color: #2d3436;
            font-weight: 700;
        }

        .modal-info-text p {
            margin: 0;
            color: #636e72;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .modal-product-price {
            font-size: 1.4rem;
            font-weight: 800;
            color: #752738;
            margin-top: 12px;
        }

        .modal-label {
            display: block;
            margin-bottom: 12px;
            font-weight: 700;
            color: #2d3436;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .variant-options {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .variant-chip {
            min-width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #edeff2;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.95rem;
            color: #333;
            /* Ensure text is visible */
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            background: #fff;
        }

        .variant-chip:hover {
            border-color: #752738;
            transform: translateY(-2px);
        }

        .variant-chip.active {
            background: #752738;
            border-color: #752738;
            color: #fff;
            box-shadow: 0 4px 12px rgba(117, 39, 56, 0.25);
        }

        .qty-selector-modal {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f8f9fa;
            padding: 6px;
            border-radius: 12px;
            width: fit-content;
        }

        .qty-selector-modal button {
            background: #fff;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            cursor: pointer;
            color: #333;
            font-size: 0.8rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: 0.2s;
        }

        .qty-selector-modal button:hover {
            background: #752738;
            color: #fff;
        }

        .qty-selector-modal input {
            width: 45px;
            text-align: center;
            border: none;
            font-weight: 700;
            background: transparent;
            font-size: 1rem;
            color: #2d3436;
        }

        .modal-footer {
            padding: 24px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            gap: 12px;
        }

        .btn-cancel-modal {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: #f5f5f5;
            color: #636e72;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.9rem;
            transition: 0.2s;
        }

        .btn-cancel-modal:hover {
            background: #eee;
            color: #2d3436;
        }

        .btn-confirm-modal {
            flex: 2;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: #752738;
            color: #fff;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .btn-confirm-modal:hover {
            background: #5a1e2b;
            box-shadow: 0 8px 16px rgba(117, 39, 56, 0.2);
            transform: translateY(-2px);
        }

        .btn-confirm-modal:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* ===== SWEETALERT Z-INDEX FIX ===== */
        .swal2-container {
            z-index: 3000 !important;
        }

        /* ===== MODAL SLIDESHOW STYLES ===== */
        .modal-slideshow-container {
            width: 90px;
            height: 90px;
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            flex-shrink: 0;
        }

        .modal-slideshow-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 0.8s ease-in-out;
        }

        .modal-slideshow-container img.active {
            opacity: 1;
        }

        /* ===== PRODUCT CARD SLIDESHOW ===== */
        .product-card-slideshow {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .product-card-slideshow img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .product-card-slideshow img.active {
            opacity: 1;
        }

        /* ===== USER DROPDOWN STYLES ===== */
        .user-dropdown {
            position: relative;
            display: inline-block;
        }

        .user-dropdown-menu {
            position: absolute;
            top: calc(100% + 15px);
            right: 0;
            background: #fff;
            min-width: 240px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 15px;
            display: none;
            z-index: 2100;
            border: 1px solid #f0f0f0;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .user-dropdown-menu.active {
            display: block;
        }

        .user-dropdown-header {
            padding-bottom: 12px;
            border-bottom: 1px solid #f8f9fa;
            margin-bottom: 12px;
        }

        .user-dropdown-name {
            display: block;
            font-weight: 700;
            color: #2d3436;
            font-size: 0.95rem;
        }

        .user-dropdown-email {
            display: block;
            font-size: 0.8rem;
            color: #636e72;
            margin-top: 2px;
        }

        .user-dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            color: #2d3436;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 10px;
            transition: 0.2s;
            cursor: pointer;
            width: 100%;
            border: none;
            background: none;
            text-align: left;
        }

        .user-dropdown-item:hover {
            background: #f8f9fa;
            color: #752738;
        }

        .user-dropdown-item i {
            font-size: 1rem;
            color: #752738;
        }
    </style>
</head>

<body>

    {{-- ===== NAVBAR ===== --}}
    <nav class="shop-nav">
        <a href="/" class="shop-nav-brand">
            <img src="{{ asset('favicon.png') }}" alt="BRAHMMART">
            <span class="shop-logo-text">BRAHMMART</span>
        </a>

        <div class="shop-nav-actions">

            <button class="shop-nav-icon" id="cartToggleBtn" aria-label="Cart">
                <i class="fas fa-bag-shopping"></i>
                <span class="cart-count">{{ count($cartItems) }}</span>
            </button>
            @if (Auth::guard('customer')->check())
                <div class="user-dropdown">
                    <button class="shop-nav-icon" id="userDropdownBtn" title="Account">
                        <i class="fas fa-user"></i>
                    </button>
                    <div class="user-dropdown-menu" id="userDropdownMenu">
                        <div class="user-dropdown-header">
                            <span class="user-dropdown-name">{{ Auth::guard('customer')->user()->fullname }}</span>
                            <span class="user-dropdown-email">{{ Auth::guard('customer')->user()->email }}</span>
                        </div>
                        <a href="/students/dashboard" class="user-dropdown-item">
                            <i class="fas fa-columns"></i>
                            My Dashboard
                        </a>
                        <form action="{{ route('auth.logout') }}" method="POST" id="logoutForm">
                            @csrf
                            <button type="submit" class="user-dropdown-item">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="/login" class="shop-nav-icon" aria-label="Account">
                    <i class="fas fa-user"></i>
                </a>
            @endif

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

            @if (request('category') == 'Uniforms')
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Filter by Gender</h3>
                    <ul class="category-list">
                        <li>
                            <a href="{{ route('shop.page', array_merge(request()->query(), ['gender' => 'all'])) }}"
                                class="{{ !request('gender') || request('gender') == 'all' ? 'active' : '' }}">
                                All Genders
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.page', array_merge(request()->query(), ['gender' => 'Male'])) }}"
                                class="{{ request('gender') == 'Male' ? 'active' : '' }}">
                                Male
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.page', array_merge(request()->query(), ['gender' => 'Female'])) }}"
                                class="{{ request('gender') == 'Female' ? 'active' : '' }}">
                                Female
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop.page', array_merge(request()->query(), ['gender' => 'Unisex'])) }}"
                                class="{{ request('gender') == 'Unisex' ? 'active' : '' }}">
                                Unisex
                            </a>
                        </li>
                    </ul>
                </div>
            @endif

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
                <button class="shop-filter-toggle" id="shopFilterToggle" title="Filter Settings">
                    <i class="fas fa-cog"></i>
                </button>
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
                        @if (request('gender'))
                            <input type="hidden" name="gender" value="{{ request('gender') }}">
                        @endif
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" class="shop-search-input"
                            value="{{ request('search') }}" placeholder="Search for uniforms, books, supplies...">
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
                            <div class="product-card-slideshow" data-product-id="{{ $product->id }}">
                                @if (is_array($images) && count($images) > 0)
                                    @foreach ($images as $index => $img)
                                        <img src="{{ asset($img) }}" alt="{{ $product->product_name }}"
                                            class="{{ $index === 0 ? 'active' : '' }}">
                                    @endforeach
                                @else
                                    <img src="{{ asset('favicon.png') }}" alt="{{ $product->product_name }}"
                                        class="active">
                                @endif
                            </div>
                            <div class="product-actions">
                                <button title="Quick View"
                                    onclick="location.href='{{ route('single.product.page', $product->id) }}'"><i
                                        class="far fa-eye"></i></button>
                                <button title="Add to Cart" onclick="openVariantModal({{ $product->id }})">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span class="product-cat">{{ $product->category_name }}</span>
                                @if ($product->gender)
                                    <span
                                        style="font-size: 10px; background: #f0f2f5; color: #752738; padding: 2px 8px; border-radius: 10px; font-weight: 700; text-transform: uppercase;">
                                        {{ $product->gender }}
                                    </span>
                                @endif
                            </div>
                            <h4 class="product-name">
                                @if ($product->uniform_name)
                                    {{ $product->uniform_name }} -
                                @endif
                                {{ $product->product_name }}
                            </h4>

                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>(0)</span>
                            </div>
                            @if ($product->has_variant)
                                <div class="product-available-sizes"
                                    style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">
                                    Available sizes: <strong>{{ $product->available_sizes }}</strong>
                                </div>
                            @elseif ($product->is_emailable == 1)
                                <div class="product-available-sizes"
                                    style="font-size: 11px; color: #752738; margin-top: 2px; font-weight: 600;">
                                    Visit physical store for custom sizing
                                </div>
                            @endif
                            <div class="product-price">
                                @if ($product->has_variant && $product->min_price != $product->max_price)
                                    ₱{{ number_format($product->min_price, 2) }} -
                                    ₱{{ number_format($product->max_price, 2) }}
                                @else
                                    ₱{{ number_format($product->display_price, 2) }}
                                @endif
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

    {{-- ===== VARIANT MODAL ===== --}}
    <div class="modal-overlay" id="variantModalOverlay" onclick="closeVariantModal()">
        <div class="variant-modal" id="variantModal" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h3>Product Options</h3>
                <button class="modal-close" onclick="closeVariantModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="modal-product-info">
                    <div class="modal-slideshow-container" id="modalSlideshow">
                        <!-- Images will be injected here -->
                    </div>
                    <div class="modal-info-text">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <p id="modalProductCat" style="margin: 0;">Category</p>
                            <span id="modalGenderBadge"
                                style="display: none; font-size: 10px; background: #f0f2f5; color: #752738; padding: 2px 8px; border-radius: 10px; font-weight: 700; text-transform: uppercase;"></span>
                        </div>
                        <h4 id="modalProductName">Product Name</h4>
                        <div id="modalEmailableNote"
                            style="display: none; font-size: 11px; color: #752738; margin-top: 4px; font-weight: 600;">
                            <i class="fas fa-info-circle"></i> Visit physical store for custom sizing
                        </div>
                        <div class="modal-product-price" id="modalProductPrice">₱0.00</div>
                    </div>
                </div>

                <div class="modal-form-group" id="variantSelectionGroup">
                    <label class="modal-label">Select Size / Variant</label>
                    <div class="variant-options" id="variantOptionsContainer">
                        <!-- Dynamic Variants -->
                    </div>
                </div>

                <div class="modal-form-group">
                    <label class="modal-label">Quantity</label>
                    <div class="qty-selector-modal">
                        <button type="button" onclick="updateModalQty(-1)"><i class="fas fa-minus"></i></button>
                        <input type="number" id="modalQty" value="1" min="1" readonly>
                        <button type="button" onclick="updateModalQty(1)"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel-modal" onclick="closeVariantModal()">Cancel</button>
                <button class="btn-confirm-modal" id="confirmAddToCartBtn">Add to Shopping Bag</button>
            </div>
        </div>
    </div>

    {{-- ===== CART DRAWER ===== --}}
    <div class="cart-drawer-overlay" id="cartOverlay"></div>
    <div class="cart-drawer" id="cartDrawer">
        @include('components.cart_drawer_content', ['cartItems' => $cartItems])
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

        window.toggleCart = function() {
            cartDrawer.classList.toggle('active');
            cartOverlay.classList.toggle('active');
            document.body.style.overflow = cartDrawer.classList.contains('active') ? 'hidden' : '';
        }

        if (cartToggleBtn) cartToggleBtn.addEventListener('click', toggleCart);
        if (cartClose) cartClose.addEventListener('click', toggleCart);
        if (cartOverlay) cartOverlay.addEventListener('click', toggleCart);
        if (continueShopping) continueShopping.addEventListener('click', toggleCart);

        // ===== USER DROPDOWN =====
        const userDropdownBtn = document.getElementById('userDropdownBtn');
        const userDropdownMenu = document.getElementById('userDropdownMenu');

        if (userDropdownBtn) {
            userDropdownBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdownMenu.classList.toggle('active');
            });
        }

        window.addEventListener('click', (e) => {
            if (userDropdownMenu && !userDropdownMenu.contains(e.target)) {
                userDropdownMenu.classList.remove('active');
            }
        });

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

        // ===== ADD TO CART AJAX =====
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        function addToCart(productId, variantId = null, quantity = 1) {
            @if (!Auth::guard('customer')->check())
                Toast.fire({
                    icon: 'info',
                    title: 'Please login first to add items to cart.'
                })
                return;
            @endif

            fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        variant_id: variantId,
                        quantity: quantity
                    })
                })
                .then(response => {
                    if (response.status === 401) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Please login first to add items to cart.');
                        });
                    }
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        });
                        fetchCart();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Toast.fire({
                        icon: 'error',
                        title: error.message || 'Something went wrong. Please try again.'
                    });
                });
        }

        function fetchCart() {
            fetch('{{ route('cart.get') }}')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('cartDrawer').innerHTML = html;

                    // Re-bind events since the content was replaced
                    const closeBtn = document.getElementById('cartClose');
                    if (closeBtn) closeBtn.addEventListener('click', toggleCart);

                    const continueBtn = document.getElementById('continueShopping');
                    if (continueBtn) continueBtn.addEventListener('click', toggleCart);

                    // Update navbar badge
                    const badgeCount = document.querySelector('.cart-badge-count');
                    if (badgeCount) {
                        const count = badgeCount.textContent.split(' ')[0];
                        const navbarBadge = document.querySelector('.cart-count');
                        if (navbarBadge) navbarBadge.textContent = count;
                    }
                });
        }

        window.updateCartQty = function(id, change) {
            fetch('{{ route('cart.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        id,
                        change
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        fetchCart();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message
                        });
                    }
                });
        }

        window.removeFromCart = function(id) {
            Swal.fire({
                title: 'Remove item?',
                text: "Are you sure you want to remove this item from your bag?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#752738',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ url('/cart/remove') }}/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Toast.fire({
                                    icon: 'success',
                                    title: data.message
                                });
                                fetchCart();
                            }
                        });
                }
            });
        }

        // ===== VARIANT MODAL LOGIC =====
        let currentProductId = null;
        let selectedVariantId = null;
        let slideshowInterval = null;

        window.openVariantModal = function(productId) {
            currentProductId = productId;
            selectedVariantId = null;
            document.getElementById('modalQty').value = 1;

            // Clear existing interval if any
            if (slideshowInterval) clearInterval(slideshowInterval);

            fetch(`/product/details/${productId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const product = data.product;
                        const variants = data.variants;

                        // Setup Slideshow
                        const slideshow = document.getElementById('modalSlideshow');
                        slideshow.innerHTML = '';

                        let images = [];
                        try {
                            images = JSON.parse(product.product_image) || [];
                        } catch (e) {
                            images = [];
                        }

                        if (images.length === 0) images = ['favicon.png'];

                        images.forEach((imgSrc, index) => {
                            const img = document.createElement('img');
                            img.src = `/${imgSrc}`;
                            if (index === 0) img.className = 'active';
                            slideshow.appendChild(img);
                        });

                        // Auto-swipe logic
                        if (images.length > 1) {
                            let currentIndex = 0;
                            slideshowInterval = setInterval(() => {
                                const allImages = slideshow.querySelectorAll('img');
                                allImages[currentIndex].classList.remove('active');
                                currentIndex = (currentIndex + 1) % allImages.length;
                                allImages[currentIndex].classList.add('active');
                            }, 3000); // Swipe every 3 seconds
                        }

                        document.getElementById('modalProductName').textContent = product.product_name;
                        document.getElementById('modalProductCat').textContent = product.category_name;

                        // Gender Badge
                        const genderBadge = document.getElementById('modalGenderBadge');
                        if (product.gender) {
                            genderBadge.textContent = product.gender;
                            genderBadge.style.display = 'inline-block';
                        } else {
                            genderBadge.style.display = 'none';
                        }

                        // Emailable Note
                        const emailableNote = document.getElementById('modalEmailableNote');
                        if (product.is_emailable == 1) {
                            emailableNote.style.display = 'block';
                        } else {
                            emailableNote.style.display = 'none';
                        }

                        const basePrice = parseFloat(product.product_price) || 0;
                        document.getElementById('modalProductPrice').textContent =
                            `₱${basePrice.toLocaleString(undefined, {minimumFractionDigits: 2})}`;

                        const variantGroup = document.getElementById('variantSelectionGroup');
                        const container = document.getElementById('variantOptionsContainer');
                        const confirmBtn = document.getElementById('confirmAddToCartBtn');

                        container.innerHTML = '';

                        if (variants && variants.length > 0) {
                            variantGroup.style.display = 'block';
                            confirmBtn.disabled = true;
                            confirmBtn.style.opacity = '0.5';

                            variants.forEach(v => {
                                const chip = document.createElement('div');
                                chip.className = 'variant-chip';
                                chip.textContent = v.size;
                                chip.onclick = () => selectVariant(chip, v.id, v.price);
                                container.appendChild(chip);
                            });
                        } else {
                            // No variants (e.g. books, notebooks)
                            variantGroup.style.display = 'none';
                            confirmBtn.disabled = false;
                            confirmBtn.style.opacity = '1';
                        }

                        document.getElementById('variantModalOverlay').classList.add('active');
                        document.getElementById('variantModal').classList.add('active');
                    }
                });
        }

        window.closeVariantModal = function() {
            if (slideshowInterval) clearInterval(slideshowInterval);
            document.getElementById('variantModalOverlay').classList.remove('active');
            document.getElementById('variantModal').classList.remove('active');
        }

        window.selectVariant = function(element, variantId, price) {
            document.querySelectorAll('.variant-chip').forEach(c => c.classList.remove('active'));
            element.classList.add('active');
            selectedVariantId = variantId;
            document.getElementById('modalProductPrice').textContent =
                `₱${parseFloat(price).toLocaleString(undefined, {minimumFractionDigits: 2})}`;

            const btn = document.getElementById('confirmAddToCartBtn');
            btn.disabled = false;
            btn.style.opacity = '1';
        }

        window.updateModalQty = function(change) {
            const qtyInput = document.getElementById('modalQty');
            let val = parseInt(qtyInput.value) + change;
            if (val < 1) val = 1;
            qtyInput.value = val;
        }

        document.getElementById('confirmAddToCartBtn').onclick = function() {
            const qty = document.getElementById('modalQty').value;
            addToCart(currentProductId, selectedVariantId, qty);
            closeVariantModal();
        }

        window.addEventListener('click', (e) => {
            if (e.target.id === 'variantModalOverlay') closeVariantModal();
        });

        window.handleCheckout = function() {
            Swal.fire({
                title: 'Proceed to Checkout?',
                text: "Confirm your order to receive instructions via email.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#752738',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Place Order'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        html: 'Please wait while we process your order.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch('{{ route('cart.checkout') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.close();
                            if (data.status === 'success') {
                                Swal.fire('Ordered!', data.message, 'success')
                                .then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        })
                        .catch(error => {
                            Swal.close();
                            Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                        });
                }
            });
        }

        // ===== GLOBAL PRODUCT CARD SLIDESHOW =====
        document.addEventListener('DOMContentLoaded', () => {
            const cardSlideshows = document.querySelectorAll('.product-card-slideshow');

            cardSlideshows.forEach(slideshow => {
                const images = slideshow.querySelectorAll('img');
                if (images.length > 1) {
                    let currentIndex = 0;
                    setInterval(() => {
                        images[currentIndex].classList.remove('active');
                        currentIndex = (currentIndex + 1) % images.length;
                        images[currentIndex].classList.add('active');
                    }, 4000); // Swipe every 4 seconds for cards
                }
            });
        });
    </script>
</body>

</html>
