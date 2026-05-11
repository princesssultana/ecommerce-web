@extends('frontend.master')
@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body p-4">

                    {{-- Header --}}
                    <div class="text-center mb-4">
                        <h4 class="btn w-100 fw-semibold py-2"style="background-color: #1144ec; color: #fff;">Create Account</h4>
                        <p class="text-muted small">Fill in the details to create your account</p>
                    </div>

                    {{-- Error messages --}}
                    @if($errors->any())
                        <div class="alert alert-danger py-2">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li class="small">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Success message --}}
                    @if(session('success'))
                        <div class="alert alert-success py-2 small">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('submit.register') }}" method="POST">
                        
                    @csrf

                        <div class="mb-3">
                            <label class="form-label fw-medium">Full Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="Your full name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

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

                        <div class="mb-3">
                            <label class="form-label fw-medium">Phone</label>
                            <input type="text"
                                   name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}"
                                   placeholder="01XXXXXXXXX">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium">Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Atleast 6 letter">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-medium">Confirm Password</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control"
                                   placeholder="Confirm Your Password">
                        </div>

                        <button type="submit" class="btn w-100 fw-semibold py-2" style="background-color: #073cdd; color: #fff;">
                            Register
                        </button>

                        <p class="text-center mt-3 mb-0 small">
                            Already have account?
                            <a href="{{ route('show.login') }}" style="color: #0719e7;">Login here</a>
                        </p>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection