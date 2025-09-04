<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New DIY Order Notification</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: #dc2626;
            color: white;
            padding: 20px;
            border-radius: 6px;
            text-align: center;
            margin: -40px -40px 30px -40px;
        }
        .alert-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .order-number {
            background: #2563eb;
            color: white;
            padding: 12px 20px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 18px;
            margin: 20px 0;
            text-align: center;
        }
        .urgent {
            background: #fef2f2;
            border: 2px solid #fca5a5;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        .urgent h3 {
            color: #dc2626;
            margin: 0 0 10px;
        }
        .section {
            margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #2563eb;
        }
        .section h3 {
            margin: 0 0 15px;
            color: #2563eb;
            font-size: 16px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 8px;
            align-items: baseline;
        }
        .info-label {
            font-weight: 600;
            color: #4b5563;
        }
        .info-value {
            color: #374151;
        }
        .customer-section {
            background: #eff6ff;
            border-left-color: #3b82f6;
        }
        .product-section {
            background: #f0fdf4;
            border-left-color: #22c55e;
        }
        .action-buttons {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 0 10px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: #2563eb;
            color: white;
        }
        .btn-secondary {
            background: #6b7280;
            color: white;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 12px;
        }
        .priority-high {
            background: #fef3c7;
            border-left-color: #f59e0b;
        }
        @media (max-width: 600px) {
            .container { padding: 20px; }
            .header { margin: -20px -20px 20px -20px; }
            .info-grid { grid-template-columns: 1fr; gap: 4px; }
            .btn { margin: 5px; display: block; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="alert-badge">🔔 New Order Alert</div>
            <h1 style="margin: 10px 0 0;">DIY ORDER RECEIVED</h1>
        </div>

        <div class="urgent">
            <h3>⚡ Action Required</h3>
            <p style="margin: 0;"><strong>A new DIY order needs immediate attention</strong></p>
        </div>

        <div class="order-number">
            Order #: {{ $order->order_number }}
        </div>

        <div class="section customer-section">
            <h3>👤 Customer Information</h3>
            <div class="info-grid">
                <span class="info-label">Name:</span>
                <span class="info-value"><strong>{{ $order->customer_name }}</strong></span>
                
                <span class="info-label">Email:</span>
                <span class="info-value"><a href="mailto:{{ $order->customer_email }}">{{ $order->customer_email }}</a></span>
                
                <span class="info-label">Phone:</span>
                <span class="info-value"><strong>{{ $order->customer_phone }}</strong></span>
                
                <span class="info-label">Address:</span>
                <span class="info-value">{{ $order->customer_address }}<br>{{ $order->customer_info['city'] }}, {{ $order->customer_info['state'] }} {{ $order->customer_info['zip'] }}</span>
            </div>
        </div>

        <div class="section product-section">
            <h3>🛠️ Product & Specifications</h3>
            <div class="info-grid">
                <span class="info-label">Product:</span>
                <span class="info-value"><strong>{{ $product->name }}</strong></span>
                
                <span class="info-label">Quantity:</span>
                <span class="info-value"><strong>{{ $order->quantity }}</strong></span>
                
                <span class="info-label">Specifications:</span>
                <span class="info-value">{{ $specifications }}</span>
            </div>
        </div>

        @if($order->notes)
        <div class="section priority-high">
            <h3>📝 Customer Notes</h3>
            <p style="margin: 0; font-style: italic; background: white; padding: 10px; border-radius: 4px;">
                "{{ $order->notes }}"
            </p>
        </div>
        @endif

        <div class="section">
            <h3>⏱️ Order Timeline</h3>
            <div class="info-grid">
                <span class="info-label">Ordered:</span>
                <span class="info-value">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</span>
                
                <span class="info-label">Status:</span>
                <span class="info-value"><strong style="color: #f59e0b;">{{ strtoupper($order->status) }}</strong></span>
                
                <span class="info-label">Expected Pickup:</span>
                <span class="info-value">{{ $order->created_at->addBusinessDays(5)->format('F j, Y') }} (approx)</span>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ url('/admin/diy-order-resources/' . $order->id) }}" class="btn btn-primary">
                View Order in Admin
            </a>
            <a href="tel:{{ $order->customer_phone }}" class="btn btn-secondary">
                Call Customer
            </a>
        </div>

        <div style="background: #fef3c7; padding: 15px; border-radius: 6px; margin: 20px 0;">
            <h4 style="color: #92400e; margin: 0 0 10px;">🎯 Next Steps:</h4>
            <ul style="margin: 0; color: #92400e;">
                <li>Review order specifications carefully</li>
                <li>Check inventory availability</li>
                <li>Contact customer if clarification needed</li>
                <li>Update order status when materials are ready</li>
                <li>Call customer to schedule pickup</li>
            </ul>
        </div>

        <div class="footer">
            <p><strong>Sent to:</strong> marc@daniellefence.net, cperez@daniellefence.net, Pepe@daniellefence.net, SBarron@daniellefence.net, CDahlman@daniellefence.net</p>
            <p style="margin-top: 10px;">Order placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
        </div>
    </div>
</body>
</html>