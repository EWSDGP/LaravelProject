

@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-warning text-white">{{ __('Edit Category') }}</div>

                <div class="card-body">
                    
                <form action="{{ route('categories.update', $category->category_id) }}" method="POST">
                        @csrf  
                        @method('PUT')               
                        <div class="form-group d-flex align-items-center">
                            <label for="category_name" class="me-2" style="min-width: 80px;">Name:</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" value="{{ $category->category_name }}" required>
                        </div>

                        <div class="mt-2 d-flex justify-content-between">
                        <a href="{{route('categories.index')}}" class="btn btn-outline-warning text-dark">Back</a>
                        <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </form>                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
