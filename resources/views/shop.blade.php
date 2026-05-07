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
                    <li><a href="#" class="active">All Products</a></li>
                    <li><a href="#">Uniforms</a></li>
                    <li><a href="#">School Supplies</a></li>
                    <li><a href="#">Books</a></li>
                </ul>
            </div>

            <div class="sidebar-section">
                <h3 class="sidebar-title">Filter by Price</h3>
                <div class="price-range">
                    <input type="range" min="0" max="5000" value="2500" class="slider">
                    <div class="price-labels">
                        <span>₱0</span>
                        <span>₱5,000+</span>
                    </div>
                </div>
            </div>

            <div class="sidebar-section">
                <h3 class="sidebar-title">Department</h3>
                <div class="filter-options">
                    <label class="filter-item">
                        <input type="checkbox"> <span>College</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox"> <span>Senior High School</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox"> <span>Junior High School</span>
                    </label>
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
                    <div class="shop-search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="shop-search-input" placeholder="Search for uniforms, books, supplies...">
                        <button class="search-btn">Search</button>
                    </div>
                    <div class="shop-utils">
                        <span class="results-count">Showing 6 products</span>
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
                <!-- Product 1 -->
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('assets/images/polo-girl/1.jpeg') }}" alt="Polo">
                        <div class="product-actions">
                            <button title="Quick View"><i class="far fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <span class="product-cat">Uniforms</span>
                        <h4 class="product-name">UB Type A Female College Blouse</h4>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span>(186)</span>
                        </div>
                        <div class="product-price">₱620.00</div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('assets/images/vest-girl/piece.jpeg') }}" alt="Vest">
                        <div class="product-actions">
                            <button title="Quick View"><i class="far fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <span class="product-cat">Uniforms</span>
                        <h4 class="product-name">UB Official School Vest</h4>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span>(42)</span>
                        </div>
                        <div class="product-price">₱520.00</div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset('assets/images/palda-girl/piece.jpeg') }}" alt="Skirt">
                        <div class="product-actions">
                            <button title="Quick View"><i class="far fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <span class="product-cat">Uniforms</span>
                        <h4 class="product-name">UB Official School Skirt</h4>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <span>(128)</span>
                        </div>
                        <div class="product-price">₱380.00</div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="product-card">
                    <div class="product-img">
                        <img src="https://images.unsplash.com/photo-1544816155-12df9643f363?q=80&w=2048&auto=format&fit=crop"
                            alt="Notebook">
                        <div class="product-actions">
                            <button title="Quick View"><i class="far fa-eye"></i></button>
                            <button title="Add to Cart"><i class="fas fa-cart-plus"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <span class="product-cat">School Supplies</span>
                        <h4 class="product-name">UB Premium Hardbound Notebook</h4>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span>(512)</span>
                        </div>
                        <div class="product-price">₱185.00</div>
                    </div>
                </div>

                <!-- Product 5 -->
                <div class="product-card">
                    <div class="product-img">
                        <img src="https://images.unsplash.com/photo-1512418490979-92798ccc1380?q=80&w=2040&auto=format&fit=crop"
                            alt="Bag">
                        <div class="product-actions">
                            <button title="Quick View"><i class="far fa-eye"></i></button>
                            <button title="Add to Cart"><i class="fas fa-cart-plus"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <span class="product-cat">School Supplies</span>
                        <h4 class="product-name">Brahmmart Official Backpack</h4>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span>(2.4k)</span>
                        </div>
                        <div class="product-price">₱1,250.00</div>
                    </div>
                </div>

                <!-- Product 6 -->
                <div class="product-card">
                    <div class="product-img">
                        <img src="https://images.unsplash.com/photo-1544640808-32ca72ac7f37?q=80&w=2070&auto=format&fit=crop"
                            alt="Book">
                        <div class="product-actions">
                            <button title="Quick View"><i class="far fa-eye"></i></button>
                            <button title="Add to Cart"><i class="fas fa-cart-plus"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <span class="product-cat">Books</span>
                        <h4 class="product-name">Intro to Computer Science — Textbook</h4>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span>(15)</span>
                        </div>
                        <div class="product-price">₱850.00</div>
                    </div>
                </div>
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
    </script>
</body>

</html>
