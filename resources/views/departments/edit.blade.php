

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Category</h1>
    <a href="{{route('departments.index')}}" class="btn btn-info mb-3">Back</a>
    <form action="{{ route('departments.update', $department->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Department Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $department->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection
