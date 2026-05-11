@extends('frontend.master')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body p-4">

                    {{-- Header --}}
                    <div class="text-center mb-4">
                        <h4 class=" fw-bold">Welcome Back</h4>
                        <p class="text-muted small">log in to your account</p>
                    </div>

                    {{-- Error --}}
                    @if($errors->any())
                        <div class="alert alert-danger py-2 small">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    {{-- Success --}}
                    @if(session('success'))
                        <div class="alert alert-success py-2 small">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-medium">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="email@example.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium">Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="••••••••">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn w-100 fw-semibold py-2" style="background-color: #0b25cd; color: #fff;">
                            Login
                        </button>

                        <p class="text-center mt-3 mb-0 small">
                            Don't have account?
                            <a href="{{ route('show.register') }}" style="color: #0d40e9;">Register</a>
                        </p>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection