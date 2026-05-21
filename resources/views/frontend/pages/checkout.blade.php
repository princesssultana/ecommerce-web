@extends('frontend.master')

@section('title', 'Checkout')

@section('content')
<section style="padding:40px 0;">
<div class="container">

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Breadcrumb --}}
    <div style="font-size:13px; color:#94a3b8; margin-bottom:24px;">
        <a href="{{ route('cart.index') }}" style="color:#2563eb;">Cart</a>
        <span style="margin:0 6px;">›</span>
        <span style="color:#1e293b; font-weight:500;">Shipping</span>
        <span style="margin:0 6px;">›</span>
        <span>Payment</span>
    </div>

    <form action="{{ route('checkout.place') }}" method="POST">
    @csrf
    <div class="row">

        {{-- Left: Shipping + Payment Method --}}
        <div class="col-lg-7 col-12">

            {{-- Shipping Address --}}
            <div class="card p-4 mb-4">
                <h5 style="font-weight:600; margin-bottom:20px;">Shipping Address</h5>

                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label">First Name *</label>
                        <input type="text" name="first_name" class="form-control"
                               value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Last Name *</label>
                        <input type="text" name="last_name" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ Auth::user()->email }}" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Phone *</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-4">
                        <label class="form-label">City *</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>
                    <div class="col-4">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control">
                    </div>
                    <div class="col-4">
                        <label class="form-label">Zip Code</label>
                        <input type="text" name="zip_code" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address *</label>
                    <textarea name="address" class="form-control" rows="3"
                              placeholder="House no, Road no, Area..." required></textarea>
                </div>
            </div>

            {{-- Shipping Method --}}
            <div class="card p-4 mb-4">
                <h5 style="font-weight:600; margin-bottom:16px;">Shipping Method</h5>
                <div class="row">
                    <div class="col-6">
                        <label style="border:1px solid #e2e8f0; border-radius:10px; padding:14px;
                                      display:block; cursor:pointer;">
                            <input type="radio" name="shipping_method" value="free" checked>
                            <strong style="margin-left:8px;">Free Shipping</strong>
                            <div style="font-size:12px; color:#94a3b8; margin-left:24px;">7-20 Days — BDT 0</div>
                        </label>
                    </div>
                    <div class="col-6">
                        <label style="border:1px solid #e2e8f0; border-radius:10px; padding:14px;
                                      display:block; cursor:pointer;">
                            <input type="radio" name="shipping_method" value="express">
                            <strong style="margin-left:8px;">Express Shipping</strong>
                            <div style="font-size:12px; color:#94a3b8; margin-left:24px;">1-3 Days — BDT 9</div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- ✅ Payment Method — FORM এর ভেতরে --}}
            <div class="card p-4 mb-4">
                <h5 style="font-weight:600; margin-bottom:16px;">Payment Method</h5>
                <div class="row">
                    <div class="col-6">
                        <label style="border:1px solid #e2e8f0; border-radius:10px; padding:14px;
                                      display:block; cursor:pointer;" id="label-cod">
                            <input type="radio" name="payment_method" value="cod" checked
                                   onchange="highlightPayment()">
                            <strong style="margin-left:8px;">Cash on Delivery</strong>
                            <div style="font-size:12px; color:#94a3b8; margin-left:24px;">Pay when you receive</div>
                        </label>
                    </div>
                    <div class="col-6">
                        <label style="border:1px solid #e2e8f0; border-radius:10px; padding:14px;
                                      display:block; cursor:pointer;" id="label-sslcommerz">
                            <input type="radio" name="payment_method" value="sslcommerz"
                                   onchange="highlightPayment()">
                            <strong style="margin-left:8px;">Online Payment</strong>
                            <div style="font-size:12px; color:#94a3b8; margin-left:24px;">bKash, Nagad, Card via SSLCommerz</div>
                        </label>
                    </div>
                </div>
            </div>

        </div>

        {{-- Right: Order Summary --}}
        <div class="col-lg-5 col-12">
            <div class="card p-4">
                <h5 style="font-weight:600; margin-bottom:16px;">Your Cart</h5>

                @foreach($cartItems as $item)
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:14px;">
                    <div style="position:relative;">
                        <img src="{{ asset('products/' . $item->product->thumbnail) }}"
                             width="56" height="56"
                             style="object-fit:cover; border-radius:8px;">
                        <span style="position:absolute; top:-6px; right:-6px; background:#1e293b;
                                     color:#fff; font-size:10px; width:18px; height:18px;
                                     border-radius:50%; display:flex; align-items:center;
                                     justify-content:center;">{{ $item->quantity }}</span>
                    </div>
                    <div style="flex:1;">
                        <div style="font-size:13px; font-weight:500;">{{ $item->product->name }}</div>
                        <div style="font-size:12px; color:#94a3b8;">Qty: {{ $item->quantity }}</div>
                    </div>
                    <div style="font-size:14px; font-weight:600;">
                        BDT {{ number_format($item->product->price * $item->quantity, 2) }}
                    </div>
                </div>
                @endforeach

                <hr>

                {{-- Discount Code --}}
                <div style="display:flex; gap:8px; margin:14px 0;">
                    <input type="text" placeholder="Discount code"
                           style="flex:1; padding:8px 12px; border:1px solid #e2e8f0;
                                  border-radius:8px; font-size:13px;">
                    <button type="button"
                            style="padding:8px 16px; background:#f1f5f9; border:1px solid #e2e8f0;
                                   border-radius:8px; font-size:13px; cursor:pointer;">
                        Apply
                    </button>
                </div>

                <hr>

                <div style="font-size:13px;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                        <span style="color:#64748b;">Subtotal</span>
                        <span>BDT {{ number_format($total, 2) }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                        <span style="color:#64748b;">Shipping</span>
                        <span id="shipping-cost">BDT 0</span>
                    </div>
                    <div style="display:flex; justify-content:space-between;
                                font-size:16px; font-weight:700; margin-top:12px;
                                padding-top:12px; border-top:1px solid #e2e8f0;">
                        <span>Total</span>
                        <span id="total-amount">BDT {{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <button type="submit"
                        style="width:100%; margin-top:20px; padding:14px;
                               background:#1e293b; color:#fff; border:none;
                               border-radius:10px; font-size:15px; font-weight:600;
                               cursor:pointer;">
                    Continue to Payment
                </button>
            </div>
        </div>

    </div>
    </form>

</div>
</section>
@endsection

@push('scripts')
<script>
const subtotal = {{ $total }};

// Shipping cost update
document.querySelectorAll('input[name="shipping_method"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        const shipping = this.value === 'express' ? 9 : 0;
        document.getElementById('shipping-cost').innerText = 'BDT ' + shipping;
        document.getElementById('total-amount').innerText = 'BDT ' + (subtotal + shipping).toFixed(2);
    });
});

// Payment method highlight
function highlightPayment() {
    const selected = document.querySelector('input[name="payment_method"]:checked').value;
    document.getElementById('label-cod').style.borderColor        = selected === 'cod'        ? '#2563eb' : '#e2e8f0';
    document.getElementById('label-sslcommerz').style.borderColor = selected === 'sslcommerz' ? '#2563eb' : '#e2e8f0';
}
        
window.addEventListener('DOMContentLoaded', function () {
    highlightPayment();
});
</script>
@endpush