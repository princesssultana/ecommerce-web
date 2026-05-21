<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Confirmed</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      background-color: #f3f4f6;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
      padding: 40px 16px;
      color: #111827;
    }

    .wrapper {
      max-width: 560px;
      margin: 0 auto;
    }

    /* ── Main card ── */
    .card {
      background: #ffffff;
      border-radius: 12px;
      border: 1px solid #e5e7eb;
      overflow: hidden;
    }

    .card-body {
      padding: 48px 40px 36px;
      text-align: center;
    }

    /* ── Checkmark ── */
    .check-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 64px;
      height: 64px;
      margin-bottom: 24px;
    }

    .check-icon svg {
      width: 52px;
      height: 52px;
    }

    /* ── Heading ── */
    .title {
      font-size: 28px;
      font-weight: 700;
      color: #111827;
      margin-bottom: 8px;
      letter-spacing: -0.5px;
    }

    .subtitle {
      font-size: 15px;
      color: #6b7280;
    }

    /* ── Divider ── */
    .divider {
      border: none;
      border-top: 1px solid #e5e7eb;
      margin: 28px 0;
    }

    /* ── Order details ── */
    .details {
      text-align: left;
    }

    .detail-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 0;
    }

    .detail-row + .detail-row {
      border-top: 1px solid #f3f4f6;
    }

    .detail-label {
      font-size: 14px;
      font-weight: 600;
      color: #374151;
    }

    .detail-value {
      font-size: 14px;
      color: #374151;
    }

    .detail-value.amount {
      color: #16a34a;
      font-weight: 600;
    }

    /* ── Paid badge ── */
    .badge-paid {
      display: inline-block;
      background: #15803d;
      color: #ffffff;
      font-size: 12px;
      font-weight: 600;
      padding: 3px 10px;
      border-radius: 4px;
      letter-spacing: 0.03em;
    }

    /* ── Button ── */
    .btn-wrap {
      padding: 0 40px 40px;
    }

    .btn-primary {
      display: block;
      width: 100%;
      background: #2563eb;
      color: #ffffff;
      font-size: 16px;
      font-weight: 600;
      text-align: center;
      text-decoration: none;
      padding: 16px;
      border-radius: 8px;
      letter-spacing: 0.01em;
    }

    /* ── Footer ── */
    .footer {
      margin-top: 24px;
      text-align: center;
    }

    .footer p {
      font-size: 13px;
      color: #9ca3af;
      line-height: 1.6;
    }

    /* ── Responsive ── */
    @media (max-width: 480px) {
      .card-body { padding: 36px 24px 28px; }
      .btn-wrap  { padding: 0 24px 32px; }
      .title     { font-size: 24px; }
    }
  </style>
</head>
<body>
<div class="wrapper">
  <div class="card">

    <!-- Body -->
    <div class="card-body">

      <!-- Green checkmark -->
      <div class="check-icon">
        <svg viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <polyline points="10,28 22,40 42,16"
            stroke="#16a34a"
            stroke-width="5"
            stroke-linecap="round"
            stroke-linejoin="round"
            fill="none"/>
        </svg>
      </div>

      <h1 class="title">Order Confirmed!</h1>
      <p class="subtitle">Thank you for your purchase.</p>

      <hr class="divider">

      <!-- Order details -->
      <div class="details">

        <div class="detail-row">
          <span class="detail-label">Order ID</span>
          <span class="detail-value">#{{ $order->id }}</span>
        </div>

        <div class="detail-row">
          <span class="detail-label">Order Number</span>
          <span class="detail-value">{{ $order->order_number }}</span>
        </div>

        <div class="detail-row">
          <span class="detail-label">Total Amount</span>
          <span class="detail-value amount">
            {{ number_format($order->total_amount, 2) }} BDT
          </span>
        </div>

        <div class="detail-row">
          <span class="detail-label">Payment Status</span>
          <span class="detail-value">
            @if($order->payment_status === 'paid')
              <span class="badge-paid">Paid</span>
            @else
              <span style="color:#d97706;font-weight:600;">{{ ucfirst($order->payment_status) }}</span>
            @endif
          </span>
        </div>

      </div>
    </div><!-- /card-body -->

    <!-- View Order Details button -->
    <div class="btn-wrap">
      <a href="{{ route('orders.show', $order->id) }}" class="btn-primary">
        View Order Details
      </a>
    </div>

  </div><!-- /card -->

  <!-- Footer note -->
  <div class="footer">
    <p>
      এই ইমেইলটি স্বয়ংক্রিয়ভাবে পাঠানো হয়েছে।<br>
      কোনো প্রশ্ন থাকলে আমাদের সাথে যোগাযোগ করুন।
    </p>
  </div>
</div>
</body>
</html>