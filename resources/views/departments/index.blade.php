

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Departments</h1>
    @session('success')
    <div class="alert alert-success">
                                    {{$value}}
                        </div>
                        @endsession  
@can ('department-create')         
    <a href="{{ route('departments.create') }}" class="btn btn-success">Create New Department</a>
@endcan  
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Department Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $department)
            <tr>
                <td>{{ $department->name }}</td>
                <td>
                @can ('department-edit')
                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-warning">Edit</a>
              @endcan
                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        @can ('department-delete')
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
