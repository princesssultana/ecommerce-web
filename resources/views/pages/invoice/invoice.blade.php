@extends('master')

@section('content')
<div class="container-fluid py-4" style="max-width: 860px;">

  {{-- Back button --}}
  <div class="mb-3">
<a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-secondary">
    ← Back
</a>
     
  </div>

  <div class="card border-0 shadow-sm rounded-3 overflow-hidden">

    {{-- Header --}}
    <div style="background:#0F6E56; padding: 2rem;">
      <div class="d-flex justify-content-between align-items-start">
        <div>
          <h4 class="mb-1 text-white">{{ config('app.name') }}</h4>
          <small style="color:#9FE1CB;">{{ config('app.url') }}</small>
        </div>
        <div class="text-end">
          <h5 class="text-white mb-1">Invoice</h5>
          <small style="color:#9FE1CB;">{{ $order->order_number }}</small><br>
          <small style="color:#9FE1CB;">{{ $order->created_at->format('d M, Y') }}</small>
        </div>
      </div>
    </div>

    {{-- Billed to + Order info --}}
    <div class="row g-0 border-bottom">
      <div class="col-6 p-4 border-end">
        <p class="text-uppercase text-muted mb-2" style="font-size:11px;">Billed to</p>
        <p class="mb-1 fw-semibold">{{ $order->shipping_name }}</p>
        <p class="mb-1 text-muted small">{{ $order->user->email }}</p>
        <p class="mb-1 text-muted small">{{ $order->shipping_phone }}</p>
        <p class="mb-0 text-muted small">{{ $order->shipping_address }}, {{ $order->shipping_city }}</p>
      </div>
      <div class="col-6 p-4">
        <p class="text-uppercase text-muted mb-2" style="font-size:11px;">Order info</p>
        <table class="w-100 small">
          <tr>
            <td class="text-muted py-1">Order no.</td>
            <td class="text-end">{{ $order->order_number }}</td>
          </tr>
          <tr>
            <td class="text-muted py-1">Payment</td>
            <td class="text-end text-capitalize">{{ $order->payment_method }}</td>
          </tr>
          <tr>
            <td class="text-muted py-1">Transaction</td>
            <td class="text-end">{{ $order->transaction_id }}</td>
          </tr>
          <tr>
            <td class="text-muted py-1">Delivery</td>
            <td class="text-end text-capitalize">{{ $order->delivery_type }}</td>
          </tr>
          <tr>
            <td class="text-muted py-1">Status</td>
            <td class="text-end">
              <span class="badge rounded-pill
                @if($order->payment_status === 'paid') bg-success
                @elseif($order->payment_status === 'pending') bg-warning text-dark
                @else bg-danger @endif">
                {{ ucfirst($order->payment_status) }}
              </span>
            </td>
          </tr>
        </table>
      </div>
    </div>

    {{-- Items --}}
    <div class="p-4">
      <table class="table table-borderless mb-0" style="font-size:14px;">
        <thead style="border-bottom: 1px solid #eee;">
          <tr class="text-muted text-uppercase" style="font-size:11px;">
            <th class="ps-0 pb-2">Item</th>
            <th class="text-center pb-2">Qty</th>
            <th class="text-end pb-2">Unit price</th>
            <th class="text-end pb-2">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($order->items as $item)
          <tr style="border-bottom: 1px solid #f5f5f5;">
            <td class="ps-0 py-3">{{ $item->product->name }}</td>
            <td class="text-center text-muted py-3">{{ $item->quantity }}</td>
            <td class="text-end text-muted py-3">BDT {{ number_format($item->price, 2) }}</td>
            <td class="text-end py-3">BDT {{ number_format($item->price * $item->quantity, 2) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Summary --}}
    <div class="px-4 pb-4 d-flex justify-content-end">
      <table style="min-width:240px; font-size:14px;">
        <tr>
          <td class="text-muted py-1">Subtotal</td>
          <td class="text-end py-1">BDT {{ number_format($order->subtotal, 2) }}</td>
        </tr>
        <tr>
          <td class="text-muted py-1">Shipping</td>
          <td class="text-end py-1">BDT {{ number_format($order->shipping_charge, 2) }}</td>
        </tr>
        <tr>
          <td class="text-muted py-1">Discount</td>
          <td class="text-end py-1" style="color:#0F6E56;">
            – BDT {{ number_format($order->discount, 2) }}
          </td>
        </tr>
        <tr style="border-top: 1px solid #eee;">
          <td class="pt-3 pb-1 fw-semibold">Total</td>
          <td class="text-end pt-3 pb-1 fw-semibold" style="font-size:16px;">
            BDT {{ number_format($order->total, 2) }}
          </td>
        </tr>
        <tr>
          <td colspan="2" class="text-end pb-2">
            <span class="badge rounded-pill"
                  style="background:#E1F5EE; color:#0F6E56;">
              {{ ucfirst($order->payment_status) }}
            </span>
          </td>
        </tr>
      </table>
    </div>

    {{-- Footer --}}
    <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
      <small class="text-muted">Generated: {{ now()->format('d M Y, h:i A') }}</small>
      <div class="d-flex gap-2">
    <button onclick="window.print()" class="btn btn-sm btn-outline-secondary">
        🖨️ Print
    </button>
    <a href="{{ route('invoice.download', $order->id) }}" class="btn btn-sm text-white" style="background:#0F6E56;">
        ⬇ Download PDF
    </a>
</div>
    </div>

  </div>
</div>
@endsection










