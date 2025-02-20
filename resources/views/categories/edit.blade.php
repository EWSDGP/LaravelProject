

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Category</h1>
    <a href="{{route('categories.index')}}" class="btn btn-info mb-3">Back</a>
    <form action="{{ route('categories.update', $category->category_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="category_name">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name" value="{{ $category->category_name }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection
