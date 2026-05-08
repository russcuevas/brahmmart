<div class="cart-drawer-header">
    <div class="cart-header-left">
        <h3>Shopping Bag</h3>
        <span class="cart-badge-count">{{ count($cartItems) }} Items</span>
    </div>
    <button class="cart-drawer-close" id="cartClose">
        <i class="fas fa-times"></i>
    </button>
</div>

<div class="cart-drawer-items">
    @php $subtotal = 0; @endphp
    @forelse ($cartItems as $item)
        @php
            $images = json_decode($item->product->product_image, true);
            $displayImage = !empty($images) ? asset($images[0]) : asset('favicon.png');
            $price = $item->variant ? $item->variant->price : $item->product->product_price;
            $subtotal += $price * $item->quantity;
        @endphp
        <div class="cart-item">
            <div class="cart-item-img">
                <img src="{{ $displayImage }}" alt="{{ $item->product->product_name }}">
            </div>
            <div class="cart-item-info">
                <div class="cart-item-top">
                    <h4>{{ $item->product->product_name }}</h4>
                    <button class="cart-item-remove" onclick="removeFromCart({{ $item->id }})"><i
                            class="fas fa-trash-can"></i></button>
                </div>
                @if ($item->variant)
                    <span class="cart-item-variant">Size: {{ $item->variant->size }}</span>
                @endif
                <div class="cart-item-bottom">
                    <div class="cart-item-qty">
                        <button class="qty-btn-cart" onclick="updateCartQty({{ $item->id }}, -1)"><i
                                class="fas fa-minus"></i></button>
                        <span>{{ $item->quantity }}</span>
                        <button class="qty-btn-cart" onclick="updateCartQty({{ $item->id }}, 1)"><i
                                class="fas fa-plus"></i></button>
                    </div>
                    <div class="cart-item-price">₱{{ number_format($price * $item->quantity, 2) }}</div>
                </div>
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 40px 20px; color: var(--text-muted);">
            <i class="fas fa-shopping-basket" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
            <p>Your shopping bag is empty.</p>
        </div>
    @endforelse
</div>

<div class="cart-drawer-footer">
    <div class="cart-summary">
        <div class="summary-row">
            <span>Subtotal</span>
            <span>₱{{ number_format($subtotal, 2) }}</span>
        </div>
        <div class="summary-total">
            <span>Total</span>
            <span>₱{{ number_format($subtotal, 2) }}</span>
        </div>
    </div>
    <div class="cart-actions">
        <button class="btn-checkout-cart">Checkout Now</button>
        <button class="btn-continue-shopping" id="continueShopping">Continue Shopping</button>
    </div>
</div>
