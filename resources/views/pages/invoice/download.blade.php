<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; margin: 30px; }
        .header { background: #0F6E56; padding: 20px; color: white; margin-bottom: 20px; }
        .header h4 { margin: 0 0 5px 0; }
        .header small { color: #9FE1CB; }
        .section { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #eee; }
        th { font-size: 11px; text-transform: uppercase; color: #999; }
        .total-row td { font-weight: bold; font-size: 15px; }
    </style>
</head>
<body>

    <div class="header">
        <div style="float:left;">
            <h4>{{ config('app.name') }}</h4>
            <small>{{ config('app.url') }}</small>
        </div>
        <div style="float:right; text-align:right;">
            <h4>Invoice</h4>
            <small>{{ $order->order_number }}</small><br>
            <small>{{ $order->created_at->format('d M, Y') }}</small>
        </div>
        <div style="clear:both;"></div>
    </div>

    <div class="section">
        <strong>Billed to</strong><br>
        {{ $order->shipping_name }}<br>
        {{ $order->user->email }}<br>
        {{ $order->shipping_phone }}<br>
        {{ $order->shipping_address }}, {{ $order->shipping_city }}
    </div>

    <div class="section">
        <strong>Order Info</strong>
        <table>
            <tr><td>Order no.</td><td>{{ $order->order_number }}</td></tr>
            <tr><td>Payment</td><td>{{ $order->payment_method }}</td></tr>
            <tr><td>Transaction</td><td>{{ $order->transaction_id }}</td></tr>
            <tr><td>Status</td><td>{{ ucfirst($order->payment_status) }}</td></tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>BDT {{ number_format($item->price, 2) }}</td>
                <td>BDT {{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr><td colspan="3">Subtotal</td><td>BDT {{ number_format($order->subtotal, 2) }}</td></tr>
            <tr><td colspan="3">Shipping</td><td>BDT {{ number_format($order->shipping_charge, 2) }}</td></tr>
            <tr><td colspan="3">Discount</td><td>- BDT {{ number_format($order->discount, 2) }}</td></tr>
            <tr class="total-row"><td colspan="3">Total</td><td>BDT {{ number_format($order->total, 2) }}</td></tr>
        </tfoot>
    </table>

</body>
</html>