<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIY Order Confirmation</title>
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
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            color: #2563eb;
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }
        .tagline {
            color: #666;
            margin: 5px 0 0;
            font-size: 14px;
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
        .section {
            margin: 25px 0;
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
        .pickup-notice {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        .pickup-notice h4 {
            color: #92400e;
            margin: 0 0 10px;
        }
        .address {
            font-weight: bold;
            color: #374151;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .contact-info {
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="logo">Danielle Fence</h1>
            <p class="tagline">Celebrating 49 Years Serving Central Florida</p>
        </div>

        <h2 style="color: #2563eb; margin-bottom: 10px;">Thank you for your DIY order!</h2>
        <p>Your order has been received and is being processed. Here are the details:</p>

        <div class="order-number">
            Order #: {{ $order->order_number }}
        </div>

        <div class="section">
            <h3>Product Information</h3>
            <div class="info-grid">
                <span class="info-label">Product:</span>
                <span class="info-value">{{ $product->name }}</span>
                
                <span class="info-label">Quantity:</span>
                <span class="info-value">{{ $order->quantity }}</span>
                
                <span class="info-label">Specifications:</span>
                <span class="info-value">{{ $specifications }}</span>
            </div>
        </div>

        <div class="section">
            <h3>Customer Information</h3>
            <div class="info-grid">
                <span class="info-label">Name:</span>
                <span class="info-value">{{ $order->customer_name }}</span>
                
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $order->customer_email }}</span>
                
                <span class="info-label">Phone:</span>
                <span class="info-value">{{ $order->customer_phone }}</span>
            </div>
        </div>

        <div class="pickup-notice">
            <h4>📍 Pickup Location</h4>
            <p class="address">4855 State Road 60 West<br>Mulberry, FL 33860</p>
            <p><strong>Phone:</strong> (863) 425-3182</p>
        </div>

        <div class="section">
            <h3>What Happens Next?</h3>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Our team will review your order and specifications</li>
                <li>We'll prepare your materials for pickup</li>
                <li>You'll receive a call when your order is ready (typically 3-5 business days)</li>
                <li>Please bring a valid ID and this confirmation when picking up</li>
            </ul>
        </div>

        @if($order->notes)
        <div class="section">
            <h3>Order Notes</h3>
            <p style="margin: 0; font-style: italic;">{{ $order->notes }}</p>
        </div>
        @endif

        <div class="footer">
            <div class="contact-info">
                <strong>Questions about your order?</strong><br>
                Call us at (863) 425-3182 or email SBarron@daniellefence.net
            </div>
            
            <p style="margin-top: 20px; font-size: 12px; color: #9ca3af;">
                This email was sent regarding order {{ $order->order_number }} placed on {{ $order->created_at->format('F j, Y') }}.
            </p>
        </div>
    </div>
</body>
</html>