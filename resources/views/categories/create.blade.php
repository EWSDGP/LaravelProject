<!-- resources/views/categories/create.blade.php -->

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-success text-white">{{ __('Create Category') }}</div>

                <div class="card-body">
                    
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf                 
                        <div class="form-group d-flex align-items-center">
                            <label for="category_name" class="me-2" style="min-width: 80px;">Name:</label>
                            <input type="text" id="category_name" name="category_name" class="form-control" required>
                        </div>

                        <div class="mt-2 d-flex justify-content-between">
                            <a href="{{route('categories.index')}}" class="btn btn-outline-dark">Back</a>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
