<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <style>
        body { font-family: 'Outfit', sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #752738; }
        .section { margin-bottom: 25px; padding: 15px; border-radius: 8px; }
        .emailable { background-color: #fff5f7; border: 1px solid #fed7e2; }
        .non-emailable { background-color: #f0fdf4; border: 1px solid #bbf7d0; }
        .item { margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #eee; }
        .item:last-child { border-bottom: none; }
        .price { font-weight: bold; color: #752738; }
        .footer { text-align: center; margin-top: 30px; font-size: 0.8rem; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Confirmation</h1>
            <p>Thank you for your order, <strong>{{ $order->customer->fullname }}</strong>!</p>
            <p>Order ID: #{{ $order->id }}</p>
        </div>

        @php
            $emailableItems = $order->items->filter(function($item) {
                return $item->product->is_emailable == 1;
            });
            $standardItems = $order->items->filter(function($item) {
                return $item->product->is_emailable == 0;
            });
        @endphp

        @if($emailableItems->count() > 0)
            <div class="section emailable">
                <h3>Custom Sizing Items</h3>
                <p><strong>Message:</strong> Please go to the store working M-F hours 8-5pm not included the lunch break so that you can get the custom sizes.</p>
                @foreach($emailableItems as $item)
                    <div class="item">
                        <span>{{ $item->product->product_name }} x {{ $item->quantity }}</span>
                        <span class="price">₱{{ number_format($item->price_at_order * $item->quantity, 2) }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        @if($standardItems->count() > 0)
            <div class="section non-emailable">
                <h3>Standard Items</h3>
                <p><strong>Message:</strong> please wait for the admin to complete your order so that you can get it.</p>
                @foreach($standardItems as $item)
                    <div class="item">
                        <span>{{ $item->product->product_name }} 
                            @if($item->variant) (Size: {{ $item->variant->size }}) @endif
                            x {{ $item->quantity }}
                        </span>
                        <span class="price">₱{{ number_format($item->price_at_order * $item->quantity, 2) }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <div style="text-align: right; margin-top: 20px;">
            <h3>Total Amount: <span class="price">₱{{ number_format($order->total_price, 2) }}</span></h3>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} UB-Store (Brahmmart). All rights reserved.</p>
        </div>
    </div>
</body>
</html>
