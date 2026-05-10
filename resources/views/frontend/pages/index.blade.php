@extends('frontend.master')

@section('title', 'All Products')

@section('content')

<section class="trending-product section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>All Products</h2>
                    <p>Browse our complete product collection.</p>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse($products as $product)
            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-product">
                    <div class="product-image">
                        <img src="{{ url('/products/' . $product->thumbnail) }}" alt="{{ $product->name }}">
                        <div class="button">
                            {{-- data-id যোগ হয়েছে, class add-to-cart-btn যোগ হয়েছে --}}
                            <a href="#" class="btn add-to-cart-btn" data-id="{{ $product->id }}">
                                <i class="lni lni-cart"></i> Add to Cart
                            </a>
                        </div>
                    </div>
                    <div class="product-info">
                        <span class="category">{{ $product->category->name ?? '' }}</span>
                        <h4 class="title">
                            <a href="#">{{ $product->name }}</a>
                        </h4>
                        <ul class="review">
                            <li><i class="lni lni-star-filled"></i></li>
                            <li><i class="lni lni-star-filled"></i></li>
                            <li><i class="lni lni-star-filled"></i></li>
                            <li><i class="lni lni-star-filled"></i></li>
                            <li><i class="lni lni-star"></i></li>
                            <li><span>4.0 Review(s)</span></li>
                        </ul>
                        <div class="price">
                            <span>${{ $product->price }}</span>
                            <span class="discount-price">${{ $product->discount_price }}</span>
                        </div>
                        <div class="button" style="margin-top: 10px;">
                            <button onclick="showProductModal({{ $product->id }})" class="btn">
                                <i class="lni lni-eye"></i> View
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No products found.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Modal --}}
<div id="productModal"
     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:16px; max-width:500px; width:90%; padding:28px; position:relative; max-height:90vh; overflow-y:auto;">
        <button onclick="closeModal()"
            style="position:absolute; top:14px; right:16px; font-size:20px; border:none; background:none; cursor:pointer;">✕</button>
        <div id="modalContent" style="text-align:center; color:#64748b;">Loading...</div>
    </div>
</div>

@endsection

@push('scripts')
<script>
{{-- Add to Cart --}}
document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        const productId = this.dataset.id;

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'login') {
                alert('Please login first!');
                window.location.href = '/login';
            } else {
                alert(data.message);
            }
        });
    });
});

{{-- Modal --}}
function showProductModal(id) {
    const modal = document.getElementById('productModal');
    modal.style.display = 'flex';
    document.getElementById('modalContent').innerHTML = '<p>Loading...</p>';

    fetch(`/product/${id}/details`)
        .then(res => res.json())
        .then(p => {
            document.getElementById('modalContent').innerHTML = `
                <img src="/products/${p.thumbnail ?? ''}"
                     onerror="this.style.display='none'"
                     style="width:100%; border-radius:10px; margin-bottom:16px; object-fit:cover; max-height:260px;">
                <p style="font-size:11px; color:#94a3b8; text-transform:uppercase; margin:0;">${p.category?.name ?? ''}</p>
                <h2 style="font-size:20px; font-weight:700; color:#1e293b; margin:6px 0 8px;">${p.name}</h2>
                <p style="font-size:20px; color:#2563eb; font-weight:600; margin:0 0 12px;">$${parseFloat(p.price).toFixed(2)}</p>
                <p style="font-size:14px; color:#64748b; line-height:1.7; text-align:left;">${p.description ?? 'No description available.'}</p>
                <button onclick="closeModal()"
                    style="margin-top:20px; padding:10px 28px; background:#2563eb; color:#fff; border:none; border-radius:8px; cursor:pointer; font-size:14px;">
                    Close
                </button>
            `;
        })
        .catch(() => {
            document.getElementById('modalContent').innerHTML = '<p style="color:red;">Failed to load product.</p>';
        });
}

function closeModal() {
    document.getElementById('productModal').style.display = 'none';
}

document.getElementById('productModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endpush