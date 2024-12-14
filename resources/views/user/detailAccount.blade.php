@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="text-center mb-0" style="color: #ff4081;">Account Details</h4>
                    <div class="text-center">
                        <div style="height: 3px; width: 60px; background-color: #ff4081; margin: 10px auto;"></div>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.update-account') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label fw-medium">Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required>
                            </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-medium">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="mobile" class="form-label fw-medium">Mobile Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-phone text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('mobile') is-invalid @enderror" 
                                       id="mobile" 
                                       name="mobile" 
                                       value="{{ old('mobile', $user->mobile) }}" 
                                       required>
                            </div>
                            @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('user.index') }}" class="btn btn-secondary me-md-2">
                                Back to Dashboard
                            </a>
                            <button type="submit" class="btn btn-primary" style="background-color: #ff4081; border-color: #ff4081;">
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add this in your layout if you haven't already -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    .form-control:focus {
        border-color: #ff4081;
        box-shadow: 0 0 0 0.2rem rgba(255, 64, 129, 0.25);
    }
    
    .input-group-text {
        border: 1px solid #ced4da;
    }
    
    .btn-primary:hover {
        background-color: #f50057 !important;
        border-color: #f50057 !important;
    }
    
    .card {
        border-radius: 10px;
        border: none;
    }
    
    .card-header {
        border-bottom: none;
        border-radius: 10px 10px 0 0 !important;
    }
    
    .form-label {
        color: #555;
    }
</style>
@endsection