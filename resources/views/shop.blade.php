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
            <h2>BRAHMMART</h2>
        </a>
        <ul class="shop-nav-links">
            <li><a href="/">Home</a></li>
            <li><a href="{{ route('shop.page') }}" class="active">Shop</a></li>
            <li><a href="/#id-status">ID Scheduling</a></li>
            <li><a href="/#contact">Contact</a></li>
        </ul>
        <div class="shop-nav-actions">
            <button class="shop-nav-icon" aria-label="Search">
                <i class="fas fa-magnifying-glass"></i>
            </button>
            <button class="shop-nav-icon" aria-label="Cart">
                <i class="fas fa-bag-shopping"></i>
                <span class="cart-count">2</span>
            </button>
            <a href="/login" class="shop-nav-icon" aria-label="Account">
                <i class="fas fa-user"></i>
            </a>
            <button class="shop-mobile-toggle" id="shopMobileToggle" aria-label="Menu">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    {{-- ===== BREADCRUMB ===== --}}
    <div class="breadcrumb">
        <a href="/">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('shop.page') }}">Shop</a>
        <i class="fas fa-chevron-right"></i>
        <a href="#">Uniforms</a>
        <i class="fas fa-chevron-right"></i>
        <span class="current">UB Official School Polo</span>
    </div>

    {{-- ===== PRODUCT PAGE ===== --}}
    <div class="product-page">

        {{-- === LEFT: Product Images === --}}
        <div class="product-images">
            <div class="product-main-img" id="mainImgWrap">
                <img src="{{ asset('assets/images/polo-girl/1.jpeg') }}" alt="UB Official School Polo"
                    id="mainProductImg">
            </div>
            <div class="product-thumbs">
                <div class="product-thumb active"
                    onclick="changeImage('{{ asset('assets/images/polo-girl/1.jpeg') }}', this)">
                    <img src="{{ asset('assets/images/polo-girl/1.jpeg') }}" alt="Polo Front">
                </div>
                <div class="product-thumb" onclick="changeImage('{{ asset('assets/images/polo-girl/2.jpeg') }}', this)">
                    <img src="{{ asset('assets/images/polo-girl/2.jpeg') }}" alt="Polo Side">
                </div>
                <div class="product-thumb"
                    onclick="changeImage('{{ asset('assets/images/polo-girl/3.jpeg') }}', this)">
                    <img src="{{ asset('assets/images/polo-girl/3.jpeg') }}" alt="Polo Back">
                </div>
                <div class="product-thumb"
                    onclick="changeImage('{{ asset('assets/images/polo-girl/4.jpeg') }}', this)">
                    <img src="{{ asset('assets/images/polo-girl/4.jpeg') }}" alt="Polo Back">
                </div>
            </div>
        </div>

        {{-- === CENTER: Product Details === --}}
        <div class="product-details">
            <a href="#" class="product-store">
                <i class="fas fa-store"></i> Visit BRAHMMART Store
            </a>

            <h1 class="product-title">UB Type A Female College Blouse</h1>

            <p class="product-description">
                The official University of Batangas school polo is crafted from premium cotton-polyester blend for
                lasting comfort. Features an embroidered UB logo, reinforced stitching, and a classic fit that meets
                school dress code standards. Designed for everyday wear throughout the academic year.
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
            <label class="product-option-label">Size:</label>
            <div class="size-selector" id="sizeSelector">
                <button class="size-btn" data-size="S" onclick="selectSize(this)">S</button>
                <button class="size-btn active" data-size="M" onclick="selectSize(this)">M</button>
                <button class="size-btn" data-size="L" onclick="selectSize(this)">L</button>
                <button class="size-btn" data-size="XL" onclick="selectSize(this)">XL</button>
                <button class="size-btn" data-size="2XL" onclick="selectSize(this)">2XL</button>
                <button class="size-btn" data-size="3XL" onclick="selectSize(this)">3XL</button>
                <button class="size-btn" data-size="4XL" onclick="selectSize(this)">4XL</button>
                <button class="size-btn" data-size="5XL" onclick="selectSize(this)">5XL</button>
                <button class="size-btn" data-size="6XL" onclick="selectSize(this)">6XL</button>
            </div>

            {{-- Stock Warning --}}
            <div class="stock-warning">
                <i class="fas fa-fire"></i>
                <div>
                    <p>There are just <strong>5</strong> left in stock, so please act immediately.</p>
                    <div class="stock-bar">
                        <div class="stock-bar-fill" style="width: 15%;"></div>
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
                        <div class="about-table-cell label">Material</div>
                        <div class="about-table-cell value">Cotton-Poly Blend</div>
                    </div>
                    <div class="about-table-row">
                        <div class="about-table-cell label">Type</div>
                        <div class="about-table-cell value">School Polo</div>
                    </div>
                    <div class="about-table-row">
                        <div class="about-table-cell label">For</div>
                        <div class="about-table-cell value">All Departments</div>
                    </div>
                    <div class="about-table-row">
                        <div class="about-table-cell label">Category</div>
                        <div class="about-table-cell value">Official Uniform</div>
                    </div>
                    <div class="about-table-row">
                        <div class="about-table-cell label">Care</div>
                        <div class="about-table-cell value">Machine Washable</div>
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
                        <img src="{{ asset('assets/images/polo-girl/1.jpeg') }}" alt="Selected">
                    </div>
                    <div class="variant-info">
                        <span>Selected Variant</span>
                        <strong id="selectedVariantText">Size M — UB Type A Female College Blouse</strong>
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
                    <span class="stock-info">Stock: <strong>856</strong></span>
                </div>

                {{-- Price --}}
                <div class="purchase-price">
                    <span class="price-label">Total Price:</span>
                    <span class="price-value" id="totalPrice">₱620.00</span>
                </div>

                {{-- Buttons --}}
                <div class="purchase-actions">
                    <button class="btn-buy primary" id="buyNowBtn">
                        Buy Now
                    </button>
                    <button class="btn-buy secondary" id="addToBagBtn">
                        <i class="fas fa-lock"></i> Add To Bag
                    </button>
                </div>
            </div>

            {{-- Other Products --}}
            <div class="new-products-card">
                <h4>Other Products</h4>

                <div class="new-product-item">
                    <div class="new-product-thumb">
                        <img src="{{ asset('assets/images/vest-girl/piece.jpeg') }}" alt="Vest">
                    </div>
                    <div class="new-product-info">
                        <h5>UB Official School Vest</h5>
                        <span class="new-price">₱520.00 <span class="old-price">₱650.00</span></span>
                    </div>
                </div>

                <div class="new-product-item">
                    <div class="new-product-thumb">
                        <img src="{{ asset('assets/images/criminology-uniform/set.jpeg') }}" alt="Crim Set">
                    </div>
                    <div class="new-product-info">
                        <h5>Criminology Uniform Set</h5>
                        <span class="new-price">₱1,850.00 <span class="old-price">₱2,200.00</span></span>
                    </div>
                </div>

                <div class="new-product-item">
                    <div class="new-product-thumb">
                        <img src="{{ asset('assets/images/palda-girl/piece.jpeg') }}" alt="Skirt">
                    </div>
                    <div class="new-product-info">
                        <h5>UB Official School Skirt</h5>
                        <span class="new-price">₱380.00 <span class="old-price">₱450.00</span></span>
                    </div>
                </div>

                <div class="new-product-item">
                    <div class="new-product-thumb">
                        <img src="{{ asset('assets/images/essentials-girl/necktie.jpeg') }}" alt="Necktie">
                    </div>
                    <div class="new-product-info">
                        <h5>UB Necktie — Official</h5>
                        <span class="new-price">₱150.00 <span class="old-price">₱180.00</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ===== IMAGE SWITCHER =====
        function changeImage(src, thumbEl) {
            document.getElementById('mainProductImg').src = src;
            document.querySelectorAll('.product-thumb').forEach(t => t.classList.remove('active'));
            thumbEl.classList.add('active');
        }

        // ===== SIZE SELECTOR =====
        const basePrice = 480;

        function selectSize(btn) {
            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const size = btn.dataset.size;
            document.getElementById('selectedVariantText').textContent = `Size ${size} — School Polo`;
            updatePrice();
        }

        // ===== QUANTITY =====
        let qty = 1;

        function updateQty(change) {
            qty = Math.max(1, Math.min(qty + change, 856));
            document.getElementById('qtyValue').textContent = qty;
            updatePrice();
        }

        function updatePrice() {
            const total = (basePrice * qty).toLocaleString('en-PH', {
                minimumFractionDigits: 2
            });
            document.getElementById('totalPrice').textContent = `₱${total}`;
        }
    </script>
</body>

</html>
