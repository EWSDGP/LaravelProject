@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background-color: #87CEEB;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-primary text-white py-3 rounded-top-4">
                        <h4 class="mb-0 text-center">{{ __('Edit Category') }}</h4>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('categories.update', $category->category_id) }}" method="POST">
                            @csrf  
                            @method('PUT')               
                            <div class="form-group mb-4">
                                <label for="category_name" class="form-label fw-bold">Category Name</label>
                                <input type="text" 
                                    class="form-control form-control-lg border-0 bg-light" 
                                    id="category_name" 
                                    name="category_name" 
                                    value="{{ $category->category_name }}" 
                                    required>
                            </div>

                            <div class="d-flex justify-content-between gap-3 mt-4">
                                <a href="{{route('categories.index')}}" 
                                    class="btn btn-outline-primary btn-lg flex-grow-1">
                                    Back
                                </a>
                                <button type="submit" 
                                    class="btn btn-primary btn-lg flex-grow-1">
                                    Update
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
