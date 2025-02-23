

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Categories</h1>
    @session('success')
    <div class="alert alert-success">
                                    {{$value}}
                        </div>
                        @endsession
                        @can ('category-create')
    <a href="{{ route('categories.create') }}" class="btn btn-success">Create New Category</a>
    @endcan
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
                @can ('category-edit')
                    <a href="{{ route('categories.edit', $category->category_id) }}" class="btn btn-warning">Edit</a>
                @endcan
                    <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        @can ('category-delete')
                        <button type="submit" class="btn btn-danger">Delete</button>
                        @endcan
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
