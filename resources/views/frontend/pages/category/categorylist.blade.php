@extends('frontend.master')

@section('title', 'All Categories')

@section('content')

<section class="section" style="padding: 60px 0;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center mb-4">
                    <h2>All Categories</h2>
                    <p>Browse products by category.</p>
                </div>
            </div>
        </div>
        <div class="row">
            @if($categories->isEmpty())
                <div class="col-12 text-center">
                    <p>No categories found.</p>
                </div>
            @else
                @foreach($categories as $category)
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <a href="{{ route('products.byCategory', $category->id) }}"
                       style="text-decoration:none;">
                        <div class="card p-3 d-flex flex-row align-items-center gap-3"
                             style="border-radius:12px; border:1px solid #e2e8f0;">
                            @if($category->image)
                                <img src="{{ url('/categories/' . $category->image) }}"
                                     width="60" height="60"
                                     style="object-fit:cover; border-radius:8px;">
                            @else
                                <div style="width:60px; height:60px; background:#f1f5f9;
                                            border-radius:8px; display:flex; align-items:center;
                                            justify-content:center;">
                                    <i class="lni lni-grid-alt" style="font-size:24px; color:#94a3b8;"></i>
                                </div>
                            @endif
                            <div>
                                <h5 style="margin:0; font-size:15px; color:#1e293b;">
                                    {{ $category->name }}
                                </h5>
                                <p style="margin:0; font-size:12px; color:#94a3b8;">
                                    {{ $category->products_count }} products
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

@endsection