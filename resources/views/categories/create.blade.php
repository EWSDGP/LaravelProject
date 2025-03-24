<!-- resources/views/categories/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex align-items-center" style="background-color: #87CEEB;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-white border-0 pt-4">
                        <h3 class="text-center text-dark fw-bold">{{ __('Create Category') }}</h3>
                    </div>

                    <div class="card-body px-4 py-5">
                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf                 
                            <div class="form-group mb-4">
                                <label for="category_name" class="form-label fw-semibold mb-2">Category Name</label>
                                <input type="text" 
                                       id="category_name" 
                                       name="category_name" 
                                       class="form-control form-control-lg border-0 bg-light" 
                                       placeholder="Enter category name"
                                       required>
                            </div>

                            <div class="mt-4 d-flex justify-content-between gap-3">
                                <a href="{{route('categories.index')}}" 
                                   class="btn btn-light btn-lg px-4 flex-grow-1">
                                    <i class="fas fa-arrow-left me-2"></i>Back
                                </a>
                                <button type="submit" 
                                        class="btn btn-primary btn-lg px-4 flex-grow-1">
                                    <i class="fas fa-check me-2"></i>Create
                                </button>
                            </div>
                        </form>                   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
