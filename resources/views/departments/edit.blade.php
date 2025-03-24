@extends('layouts.app')

@section('content')
<div class="container-fluid min-vh-100 py-5" style="background: linear-gradient(135deg, #87CEEB 0%, #B0E0E6 100%);">
    <div class="row justify-content-center align-items-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-white border-0 py-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-building text-primary me-2"></i>
                        <h4 class="mb-0 text-primary">{{ __('Edit Department') }}</h4>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('departments.update',$department->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-4">
                            <label for="name" class="form-label text-muted">
                                <i class="fas fa-tag me-2"></i>Department Name
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg border-2" 
                                   id="name" 
                                   name="name" 
                                   value="{{ $department->name }}" 
                                   required
                                   placeholder="Enter department name">
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{route('departments.index')}}" 
                               class="btn btn-outline-primary btn-lg px-4">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save me-2"></i>Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.9);
    }
    .form-control:focus {
        border-color: #87CEEB;
        box-shadow: 0 0 0 0.2rem rgba(135, 206, 235, 0.25);
    }
    .btn-primary {
        background-color: #87CEEB;
        border-color: #87CEEB;
    }
    .btn-primary:hover {
        background-color: #5F9EA0;
        border-color: #5F9EA0;
    }
    .btn-outline-primary {
        color: #87CEEB;
        border-color: #87CEEB;
    }
    .btn-outline-primary:hover {
        background-color: #87CEEB;
        border-color: #87CEEB;
        color: white;
    }
</style>
@endpush
@endsection
