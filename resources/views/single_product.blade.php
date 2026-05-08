<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brahmmart</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/customers/single_product.css') }}">
    <style>
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

        .shop-logo-text {
            font-size: 1.2rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: 1px;
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

    {{-- ===== BREADCRUMB ===== --}}
    <div class="breadcrumb">
        <a href="/">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('shop.page') }}">Shop</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('shop.page', ['category' => $product->category_name]) }}">{{ $product->category_name }}</a>
        <i class="fas fa-chevron-right"></i>
        <span class="current">
            @if ($product->uniform_name)
                {{ $product->uniform_name }} -
            @endif
            {{ $product->product_name }}
        </span>
    </div>

    {{-- ===== PRODUCT PAGE ===== --}}
    <div class="product-page">

        {{-- === LEFT: Product Images === --}}
        <div class="product-images">
            @php
                $images = json_decode($product->product_image, true) ?: [];
                $mainImg = !empty($images) ? asset($images[0]) : asset('favicon.png');
            @endphp
            <div class="product-main-img" id="mainImgWrap">
                <img src="{{ $mainImg }}" alt="{{ $product->product_name }}" id="mainProductImg">
            </div>
            <div class="product-thumbs">
                @foreach ($images as $index => $img)
                    <div class="product-thumb {{ $index === 0 ? 'active' : '' }}"
                        onclick="changeImage('{{ asset($img) }}', this)">
                        <img src="{{ asset($img) }}" alt="{{ $product->product_name }}">
                    </div>
                @endforeach
            </div>
        </div>

        {{-- === CENTER: Product Details === --}}
        <div class="product-details">
            <a href="{{ route('shop.page') }}" class="product-store">
                <i class="fas fa-store"></i> Visit BRAHMMART Store
            </a>

            <h1 class="product-title">
                @if ($product->uniform_name)
                    {{ $product->uniform_name }} -
                @endif
                {{ $product->product_name }}
            </h1>

            <p class="product-description">
                {{ $product->product_description ?: 'No description available for this product.' }}
            </p>

            {{-- Ratings --}}
            <div class="product-ratings">
                <div class="rating-stars">
                    <span>4.8</span>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-stroke"></i>
                </div>
                <span class="rating-stat"><strong>186</strong> Ratings</span>
                <span class="rating-stat"><strong>2.1k+</strong> Sold</span>
            </div>

            {{-- Size Selector --}}
            @if ($product->has_variant)
                <label class="product-option-label">Size:</label>
                <div class="size-selector" id="sizeSelector">
                    @foreach ($variants as $index => $v)
                        <button class="size-btn {{ $index === 0 ? 'active' : '' }}" data-size="{{ $v->size }}"
                            data-price="{{ $v->price }}" data-variant-id="{{ $v->id }}"
                            data-stock="{{ $v->stocks }}" onclick="selectVariant(this)">
                            {{ $v->size }}
                        </button>
                    @endforeach
                </div>
            @endif

            {{-- Stock Warning --}}
            <div class="stock-warning">
                <i class="fas fa-fire"></i>
                <div>
                    <p id="stockWarningText">
                        @if ($product->has_variant)
                            Only <strong>{{ $variants[0]->stocks }}</strong> left in stock!
                        @else
                            Only <strong>{{ $product->stocks }}</strong> left in stock!
                        @endif
                    </p>
                    <div class="stock-bar">
                        <div class="stock-bar-fill" id="stockBarFill" style="width: 45%;"></div>
                    </div>
                </div>
            </div>

            {{-- Action Links --}}
            <div class="product-action-links">
                <a href="#" class="product-action-link">
                    <i class="fas fa-ruler"></i> Size Chart
                </a>
            </div>

            {{-- About Item --}}
            <div class="about-item">
                <h4>About Item</h4>
                <div class="about-table">
                    <div class="about-table-row">
                        <div class="about-table-cell label">Category</div>
                        <div class="about-table-cell value">{{ $product->category_name }}</div>
                    </div>
                    @if ($product->category_name === 'Uniforms' && $product->gender)
                        <div class="about-table-row">
                            <div class="about-table-cell label">Gender</div>
                            <div class="about-table-cell value" style="color: #752738; font-weight: 700;">
                                {{ $product->gender }}
                            </div>
                        </div>
                    @endif
                    <div class="about-table-row">
                        <div class="about-table-cell label">Stock Status</div>
                        <div class="about-table-cell value">
                            @php
                                $totalStock = $product->has_variant ? $variants->sum('stocks') : $product->stocks;
                            @endphp
                            @if ($totalStock > 0)
                                <span style="color: #27ae60; font-weight: 700;">In Stock</span>
                            @else
                                <span style="color: #e74c3c; font-weight: 700;">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- === RIGHT: Purchase Sidebar === --}}
        <div class="purchase-sidebar">
            <div class="purchase-card">

                {{-- Selected Variant --}}
                <div class="selected-variant">
                    <div class="variant-thumb">
                        <img src="{{ $mainImg }}" alt="Selected" id="sideVariantImg">
                    </div>
                    <div class="variant-info">
                        <span>Selected Item</span>
                        <strong id="selectedVariantText">
                            @if ($product->has_variant)
                                Size {{ $variants[0]->size }} — {{ $product->product_name }}
                            @else
                                {{ $product->product_name }}
                            @endif
                        </strong>
                    </div>
                </div>

                {{-- Quantity --}}
                <div class="purchase-qty">
                    <div class="qty-control">
                        <button class="qty-btn" id="qtyMinus" onclick="updateQty(-1)">
                            <i class="fas fa-minus"></i>
                        </button>
                        <div class="qty-value" id="qtyValue">1</div>
                        <button class="qty-btn" id="qtyPlus" onclick="updateQty(1)">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <span class="stock-info">Stock: <strong id="sidebarStock">
                            {{ $product->has_variant ? $variants[0]->stocks : $product->stocks }}
                        </strong></span>
                </div>

                {{-- Price --}}
                <div class="purchase-price">
                    <span class="price-label">Total Price:</span>
                    <span class="price-value" id="totalPrice">
                        ₱{{ number_format($product->has_variant ? $variants[0]->price : $product->product_price, 2) }}
                    </span>
                </div>

                {{-- Buttons --}}
                <div class="purchase-actions">
                    <button class="btn-buy primary" id="buyNowBtn">
                        Buy Now
                    </button>
                    <button class="btn-buy secondary" id="addToBagBtn"
                        onclick="handleAddToBag({{ $product->id }})">
                        <i class="fas fa-lock"></i> Add To Bag
                    </button>
                </div>
            </div>

            {{-- Other Products --}}
            <div class="new-products-card">
                <h4>Other Products</h4>

                @foreach ($otherProducts as $op)
                    @php
                        $opImages = json_decode($op->product_image, true) ?: [];
                        $opMainImg = !empty($opImages) ? asset($opImages[0]) : asset('favicon.png');
                    @endphp
                    <div class="new-product-item"
                        onclick="location.href='{{ route('single.product.page', $op->id) }}'"
                        style="cursor: pointer;">
                        <div class="new-product-thumb">
                            <img src="{{ $opMainImg }}" alt="{{ $op->product_name }}">
                        </div>
                        <div class="new-product-info">
                            <h5>
                                @if ($op->uniform_name)
                                    {{ $op->uniform_name }} -
                                @endif
                                {{ $op->product_name }}
                            </h5>
                            <span class="new-price">
                                @if ($op->has_variant && $op->min_price != $op->max_price)
                                    ₱{{ number_format($op->min_price, 2) }} - ₱{{ number_format($op->max_price, 2) }}
                                @else
                                    ₱{{ number_format($op->min_price, 2) }}
                                @endif
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ===== CART DRAWER ===== --}}
    <div class="cart-drawer-overlay" id="cartOverlay"></div>
    <div class="cart-drawer" id="cartDrawer">
        @include('components.cart_drawer_content', ['cartItems' => $cartItems])
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ===== IMAGE SWITCHER =====
        function changeImage(src, thumbEl) {
            document.getElementById('mainProductImg').src = src;
            document.querySelectorAll('.product-thumb').forEach(t => t.classList.remove('active'));
            thumbEl.classList.add('active');
        }

        // ===== VARIANT SELECTION =====
        let selectedVariantId = {{ $product->has_variant ? $variants[0]->id ?? 'null' : 'null' }};
        let currentPrice = {{ $product->has_variant ? $variants[0]->price ?? 0 : $product->product_price }};
        let currentStock = {{ $product->has_variant ? $variants[0]->stocks ?? 0 : $product->stocks }};
        let qty = 1;

        function selectVariant(btn) {
            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const size = btn.dataset.size;
            selectedVariantId = btn.dataset.variantId;
            currentPrice = parseFloat(btn.dataset.price);
            currentStock = parseInt(btn.dataset.stock);

            document.getElementById('selectedVariantText').textContent = `Size ${size} — {{ $product->product_name }}`;
            document.getElementById('sidebarStock').textContent = currentStock;
            document.getElementById('stockWarningText').innerHTML = `Only <strong>${currentStock}</strong> left in stock!`;

            // Reset qty if it exceeds new stock
            if (qty > currentStock) qty = currentStock;
            if (currentStock === 0) qty = 0;
            document.getElementById('qtyValue').textContent = qty;

            updatePriceDisplay();
        }

        // ===== QUANTITY =====
        function updateQty(change) {
            if (currentStock === 0) return;
            let newVal = qty + change;
            if (newVal < 1) newVal = 1;
            if (newVal > currentStock) {
                newVal = currentStock;
                Toast.fire({
                    icon: 'warning',
                    title: 'Maximum stock reached'
                });
            }
            qty = newVal;
            document.getElementById('qtyValue').textContent = qty;
            updatePriceDisplay();
        }

        function updatePriceDisplay() {
            const total = (currentPrice * qty).toLocaleString('en-PH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            document.getElementById('totalPrice').textContent = `₱${total}`;
        }

        // ===== CART ACTIONS =====
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

        function handleAddToBag(productId) {
            @if (!Auth::guard('customer')->check())
                window.location.href = '{{ route('auth.login.page') }}';
                return;
            @endif

            if ({{ $product->has_variant ? 'true' : 'false' }} && !selectedVariantId) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Please select a size'
                });
                return;
            }

            if (qty < 1) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Please select quantity'
                });
                return;
            }

            fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        variant_id: selectedVariantId,
                        quantity: qty
                    })
                })
                .then(response => response.json())
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
                });
        }

        function fetchCart() {
            fetch('{{ route('cart.get') }}')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('cartDrawer').innerHTML = html;
                    rebindCartEvents();
                    updateCartBadge();
                });
        }

        function rebindCartEvents() {
            const closeBtn = document.getElementById('cartClose');
            if (closeBtn) closeBtn.onclick = toggleCart;
            const continueBtn = document.getElementById('continueShopping');
            if (continueBtn) continueBtn.onclick = toggleCart;
        }

        function updateCartBadge() {
            const badgeCount = document.querySelector('.cart-badge-count');
            if (badgeCount) {
                const count = badgeCount.textContent.split(' ')[0];
                document.querySelector('.cart-count').textContent = count;
            }
        }

        window.updateCartQty = function(id, change) {
            fetch('{{ route('cart.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
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

        // ===== UI TOGGLES =====
        const cartToggleBtn = document.getElementById('cartToggleBtn');
        const cartDrawer = document.getElementById('cartDrawer');
        const cartOverlay = document.getElementById('cartOverlay');

        function toggleCart() {
            cartDrawer.classList.toggle('active');
            cartOverlay.classList.toggle('active');
            document.body.style.overflow = cartDrawer.classList.contains('active') ? 'hidden' : '';
        }

        if (cartToggleBtn) cartToggleBtn.onclick = toggleCart;
        if (cartOverlay) cartOverlay.onclick = toggleCart;
        rebindCartEvents();

        const userDropdownBtn = document.getElementById('userDropdownBtn');
        const userDropdownMenu = document.getElementById('userDropdownMenu');

        if (userDropdownBtn) {
            userDropdownBtn.onclick = (e) => {
                e.stopPropagation();
                userDropdownMenu.classList.toggle('active');
            };
        }

        window.onclick = (e) => {
            if (userDropdownMenu && !userDropdownMenu.contains(e.target)) {
                userDropdownMenu.classList.remove('active');
            }
        };
    </script>
</body>

</html>
