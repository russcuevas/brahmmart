<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f9f9f9; }
        .email-wrapper { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 25px rgba(0,0,0,0.05); }
        .header { background: #752738; padding: 40px 20px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 28px; letter-spacing: 1px; }
        .header p { margin: 10px 0 0; opacity: 0.9; font-size: 16px; }
        .content { padding: 40px; }
        
        .pickup-card { background: #fff5f7; border: 2px solid #752738; border-radius: 12px; padding: 25px; margin-bottom: 30px; text-align: center; }
        .pickup-card h3 { margin: 0 0 10px; color: #752738; font-size: 20px; }
        .pickup-date { font-size: 24px; font-weight: 700; color: #333; margin: 15px 0; }
        .pickup-icon { font-size: 40px; margin-bottom: 10px; }
        
        .order-info { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .info-box { background: #fcfcfc; border: 1px solid #f0f0f0; border-radius: 12px; padding: 15px; }
        .info-label { font-size: 11px; color: #999; text-transform: uppercase; font-weight: 700; margin-bottom: 4px; display: block; }
        .info-value { font-size: 14px; font-weight: 600; color: #333; }
        
        .order-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .order-table th { text-align: left; padding: 12px; border-bottom: 2px solid #f0f0f0; color: #888; font-size: 12px; text-transform: uppercase; }
        .order-table td { padding: 15px 12px; border-bottom: 1px solid #f9f9f9; vertical-align: top; }
        .product-name { font-weight: 700; color: #333; display: block; font-size: 14px; }
        .product-meta { font-size: 12px; color: #999; }
        .sizing-text { display: block; font-size: 12px; color: #752738; margin-top: 6px; font-style: italic; background: #fffafa; padding: 8px; border-radius: 6px; border-left: 3px solid #752738; }
        
        .total-box { border-top: 2px solid #f0f0f0; padding-top: 20px; text-align: right; }
        .total-label { font-size: 14px; color: #888; }
        .total-value { font-size: 22px; font-weight: 700; color: #752738; margin-left: 10px; }
        
        .note-section { margin-top: 30px; padding: 20px; background: #fff8f8; border-radius: 12px; border-left: 4px solid #752738; }
        .note-title { font-weight: 700; color: #752738; font-size: 14px; margin-bottom: 5px; display: block; }
        .note-body { font-size: 13px; color: #555; }
        
        .footer { padding: 30px; text-align: center; color: #aaa; font-size: 12px; background: #fafafa; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <h1>Order Confirmed!</h1>
            <p>Your order #{{ $order->id }} is being processed.</p>
        </div>

        <div class="content">
            @if($order->status == 'completed' && $order->pick_up_date)
                <div class="pickup-card">
                    <div class="pickup-icon">📦</div>
                    <h3>Ready for Pick-up!</h3>
                    <p style="margin: 0; font-size: 14px; color: #666;">Please visit our store on:</p>
                    <div class="pickup-date">
                        {{ \Carbon\Carbon::parse($order->pick_up_date)->format('M d, Y @ h:i A') }}
                    </div>
                    <p style="margin: 0; font-size: 12px; color: #999;">Don't forget to bring your ID.</p>
                </div>
            @endif

            <div class="order-info">
                <div class="info-box">
                    <span class="info-label">Order Number</span>
                    <span class="info-value">#{{ $order->id }}</span>
                </div>
                <div class="info-box">
                    <span class="info-label">Customer Name</span>
                    <span class="info-value">{{ $order->customer->fullname }}</span>
                </div>
            </div>

            <table class="order-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>
                                <span class="product-name">{{ $item->product->product_name }}</span>
                                <span class="product-meta">
                                    {{ $item->variant ? 'Size: '.$item->variant->size : 'Standard' }}
                                    @if($item->product->is_emailable == 1)
                                        | <span style="color: #752738; font-weight: 600;">Custom Sizing</span>
                                    @endif
                                </span>
                                @if($item->sizing_notes)
                                    <div class="sizing-text">
                                        <strong>Sizing Details:</strong> {{ $item->sizing_notes }}
                                    </div>
                                @endif
                            </td>
                            <td style="text-align: center;">{{ $item->quantity }}</td>
                            <td style="text-align: right; font-weight: 700; color: #752738;">
                                ₱{{ number_format($item->quantity * $item->price_at_order, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($order->order_note)
                <div class="note-section">
                    <span class="note-title">Store Instructions:</span>
                    <div class="note-body">{{ $order->order_note }}</div>
                </div>
            @endif

            <div class="total-box">
                <span class="total-label">Grand Total Paid:</span>
                <span class="total-value">₱{{ number_format($order->total_price, 2) }}</span>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Brahmmart - University of Batangas</p>
            <p>batangas.brahmmart.com</p>
        </div>
    </div>
</body>
</html>
