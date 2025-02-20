

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Categories</h1>
    @session('success')
    <div class="alert alert-success">
                                    {{$value}}
                        </div>
                        @endsession
    <a href="{{ route('categories.create') }}" class="btn btn-success">Create New Category</a>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->category_name }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category->category_id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
