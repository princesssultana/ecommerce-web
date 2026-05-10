@extends('master')

@section('content')

{{-- Hero Section --}}
<div class="bg-dark text-white rounded-3 p-5 mb-5 text-center">
    <h1 class="display-5 fw-bold">Welcome to ShopFlow 🛒</h1>
    <p class="lead text-secondary">Find the best products at the best prices</p>
    <a href="#categories" class="btn btn-primary btn-lg mt-2">Shop Now</a>
</div>

{{-- Categories Section --}}
<div id="categories">
    <h4 class="fw-bold mb-3">Browse Categories</h4>
    <div class="row g-3 mb-5">
        @forelse($categories as $category)
        <div class="col-6 col-md-3">
            <a href="#" class="text-decoration-none">
                <div class="card text-center p-3 h-100 shadow-sm">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}"
                             height="60"
                             style="object-fit:contain; margin: 0 auto;">
                    @else
                        <div style="font-size:2.5rem">📦</div>
                    @endif
                    <div class="mt-2 fw-bold text-dark">{{ $category->name }}</div>
                    <small class="text-muted">
                        {{ $category->products->count() }} products
                    </small>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12">
            <p class="text-muted">No categories found.</p>
        </div>
        @endforelse
    </div>
</div>

{{-- Featured Products Section --}}
<div>
    <h4 class="fw-bold mb-3">Latest Products</h4>
    <div class="row g-3">
        @forelse($products as $product)
        <div class="col-6 col-md-3">
            <div class="card h-100 shadow-sm">

                {{-- Product Image --}}
                @if($product->thumbnail)
                    <img src="{{ asset('storage/' . $product->thumbnail) }}"
                         class="card-img-top"
                         height="180"
                         style="object-fit:cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center"
                         style="height:180px; font-size:3rem;">
                        🛍️
                    </div>
                @endif

                <div class="card-body d-flex flex-column">
                    {{-- Name --}}
                    <h6 class="card-title fw-bold">{{ $product->name }}</h6>

                    {{-- Category --}}
                    <small class="text-muted mb-2">{{ $product->category->name }}</small>

                    {{-- Price --}}
                    <div class="mt-auto">
                        @if($product->discount_price)
                            <span class="text-danger fw-bold fs-6">
                                BDT{{ number_format($product->discount_price) }}
                            </span>
                            <small class="text-muted text-decoration-line-through ms-1">
                                BDT{{ number_format($product->price) }}
                            </small>
                        @else
                            <span class="fw-bold fs-6">
                                BDT{{ number_format($product->price) }}
                            </span>
                        @endif
                    </div>

                    {{-- Add to Cart Button --}}
                    <a href="{{ route('cart.add', $product->id) }}" class="btn btn-primary btn-sm mt-2 w-100">
                        Add to Cart
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-muted">No products found.</p>
        </div>
        @endforelse
    </div>
</div>

@endsection