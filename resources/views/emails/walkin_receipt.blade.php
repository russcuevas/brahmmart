<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Walk-in Order Receipt</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f9f9f9; }
        .email-wrapper { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 25px rgba(0,0,0,0.05); }
        .header { background: #752738; padding: 40px 20px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 28px; letter-spacing: 1px; }
        .header p { margin: 10px 0 0; opacity: 0.9; font-size: 16px; }
        .content { padding: 40px; }
        .customer-card { background: #fcfcfc; border: 1px solid #f0f0f0; border-radius: 12px; padding: 20px; margin-bottom: 30px; }
        .customer-card h3 { margin: 0 0 15px; color: #752738; font-size: 18px; border-bottom: 2px solid #fcf2f4; padding-bottom: 8px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; }
        .info-label { color: #888; font-weight: 500; }
        .info-value { color: #333; font-weight: 600; }
        
        .order-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .order-table th { text-align: left; padding: 12px; border-bottom: 2px solid #f0f0f0; color: #888; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; }
        .order-table td { padding: 15px 12px; border-bottom: 1px solid #f9f9f9; vertical-align: top; }
        .product-name { font-weight: 700; color: #333; display: block; font-size: 15px; }
        .product-meta { font-size: 12px; color: #999; margin-top: 4px; }
        .sizing-badge { display: inline-block; background: #fcf2f4; color: #752738; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; margin-top: 8px; border: 1px solid rgba(117, 39, 56, 0.1); }
        .sizing-text { display: block; font-size: 12px; color: #752738; margin-top: 6px; font-style: italic; background: #fffafa; padding: 8px; border-radius: 6px; border-left: 3px solid #752738; }
        
        .totals { background: #752738; border-radius: 12px; padding: 25px; color: #fff; text-align: right; }
        .total-row { display: flex; justify-content: flex-end; align-items: center; gap: 20px; margin-bottom: 5px; }
        .total-label { font-size: 14px; opacity: 0.8; }
        .total-amount { font-size: 24px; font-weight: 700; }
        
        .order-note { margin-top: 30px; padding: 20px; background: #fff8f0; border-radius: 12px; border: 1px solid #ffeeba; }
        .order-note h4 { margin: 0 0 10px; color: #856404; font-size: 14px; display: flex; align-items: center; gap: 8px; }
        .order-note p { margin: 0; font-size: 13px; color: #666; line-height: 1.5; }
        
        .footer { padding: 30px; text-align: center; color: #aaa; font-size: 12px; background: #fafafa; }
        .footer p { margin: 5px 0; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <img src="{{ asset('logo-plain.png') }}" alt="Brahmmart" style="height: 60px; margin-bottom: 15px; filter: brightness(0) invert(1);">
            <h1>Order Receipt</h1>
            <p>Thank you for shopping at UB Mart!</p>
        </div>

        <div class="content">
            <div class="customer-card">
                <h3>Customer Information</h3>
                <div class="info-row">
                    <span class="info-label">Name:</span>
                    <span class="info-value">{{ $customer->fullname }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $customer->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date:</span>
                    <span class="info-value">{{ date('M d, Y h:i A') }}</span>
                </div>
            </div>

            @foreach ($orders as $order)
                <div style="margin-bottom: 40px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h4 style="margin: 0; color: #333; font-size: 16px; font-weight: 700;">Order #{{ $order->id }}</h4>
                        <span style="background: {{ $order->status == 'completed' ? '#f0fdf4' : '#eff6ff' }}; color: {{ $order->status == 'completed' ? '#166534' : '#1e40af' }}; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                            {{ $order->status }}
                        </span>
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
                                        @if($item->variant)
                                            <span class="product-meta">Size: {{ $item->variant->size }}</span>
                                        @endif
                                        
                                        @if($item->product->is_emailable == 1)
                                            <span class="sizing-badge">CUSTOM SIZING</span>
                                            @if($item->sizing_notes)
                                                <div class="sizing-text">
                                                    <strong>Sizing Details:</strong> {{ $item->sizing_notes }}
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                    <td style="text-align: center; font-weight: 600;">{{ $item->quantity }}</td>
                                    <td style="text-align: right; font-weight: 700; color: #752738;">₱{{ number_format($item->quantity * $item->price_at_order, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($order->order_note)
                        <div class="order-note">
                            <h4><img src="https://cdn-icons-png.flaticon.com/512/3209/3209265.png" width="16" style="vertical-align: middle;"> Order Notes</h4>
                            <p>{{ $order->order_note }}</p>
                        </div>
                    @endif

                    <div class="totals">
                        <div class="total-row">
                            <span class="total-label">Total for this order:</span>
                            <span class="total-amount">₱{{ number_format($order->total_price, 2) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach

            <div style="margin-top: 40px; text-align: center; padding: 25px; background: #fcf2f4; border-radius: 12px; border: 1px dashed #752738;">
                <p style="margin: 0; font-size: 14px; color: #752738; font-weight: 600;">
                    Please present this receipt at the store counter to claim your items.
                </p>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Brahmmart - University of Batangas</p>
            <p>This is an automated receipt. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
