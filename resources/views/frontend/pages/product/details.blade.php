@extends('frontend.master')

@section('title', $product->name)

@section('content')

<section class="section" style="padding: 60px 0;">
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            {{-- Product Image --}}
            <div class="col-lg-5 col-12 mb-4">
                <div style="border-radius:12px; overflow:hidden; border:1px solid #e2e8f0;">
                    @if($product->thumbnail)
                        <img src="{{ asset('products/' . $product->thumbnail) }}"
                             alt="{{ $product->name }}"
                             style="width:100%; object-fit:cover; max-height:400px;">
                    @else
                        <div style="height:400px; background:#f1f5f9; display:flex;
                                    align-items:center; justify-content:center;">
                            <i class="lni lni-image" style="font-size:48px; color:#cbd5e1;"></i>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Product Info --}}
            <div class="col-lg-7 col-12">
                <span style="font-size:12px; color:#94a3b8; text-transform:uppercase;">
                    {{ $product->category->name ?? '' }}
                </span>

                <h2 style="font-size:26px; font-weight:700; color:#1e293b; margin:8px 0;">
                    {{ $product->name }}
                </h2>

                {{-- Stars --}}
                <div style="margin-bottom:12px;">
                    <i class="lni lni-star-filled" style="color:#f59e0b;"></i>
                    <i class="lni lni-star-filled" style="color:#f59e0b;"></i>
                    <i class="lni lni-star-filled" style="color:#f59e0b;"></i>
                    <i class="lni lni-star-filled" style="color:#f59e0b;"></i>
                    <i class="lni lni-star" style="color:#f59e0b;"></i>
                    <span style="font-size:13px; color:#94a3b8; margin-left:4px;">4.0 Review(s)</span>
                </div>

                {{-- Price --}}
                <div style="margin-bottom:16px;">
                    <span style="font-size:28px; font-weight:700; color:#2563eb;">
                        ${{ $product->price }}
                    </span>
                    @if($product->discount_price)
                        <span style="font-size:16px; color:#94a3b8; text-decoration:line-through; margin-left:8px;">
                            ${{ $product->discount_price }}
                        </span>
                    @endif
                </div>


                <hr style="border-color:#e2e8f0;">

                {{-- Description --}}
                <p style="font-size:14px; color:#64748b; line-height:1.8; margin:16px 0;">
                    {{ $product->description ?? 'No description available.' }}
                </p>

                {{-- Stock --}}
                <p style="font-size:13px; color:#64748b; margin-bottom:20px;">
                    <i class="lni lni-checkmark-circle" style="color:#22c55e;"></i>
                    Stock: {{ $product->stock }} units available
                </p>
          {{-- Quantity --}}
<div style="margin:16px 0;">
    <button onclick="if(qty>1){qty--;document.getElementById('qty').innerText=qty}"
            style="width:34px;height:34px;border:1px solid #ddd;background:#f8f8f8;border-radius:6px;font-size:18px;cursor:pointer;">−</button>
    <span id="qty" style="margin:0 14px;font-size:16px;font-weight:600;">1</span>
    <button onclick="qty++;document.getElementById('qty').innerText=qty"
            style="width:34px;height:34px;border:1px solid #ddd;background:#f8f8f8;border-radius:6px;font-size:18px;cursor:pointer;">+</button>
</div>

{{-- Add to Cart --}}
<a id="cart-btn" href="{{ route('cart.add',$product->id) }}" class="btn btn-primary"
   style="padding:12px 32px;">
   <i class="lni lni-cart"></i> Add to Cart
</a>

<script>
var qty = 1;
document.querySelectorAll('button').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.getElementById('cart-btn').href = "{{ route('cart.add', $product->id) }}".replace('{{ $product->id }}', qty);
});
</script>

                {{-- Back --}}
                <a href="{{ route('products.list') }}"
                   class="btn btn-outline-secondary ms-2"
                   style="padding:12px 24px; font-size:15px;">
                    Back to Products
                </a>
            </div>
        </div>
    </div>
</section>

@endsection