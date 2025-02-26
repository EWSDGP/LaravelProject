@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Closure Dates</h1>

      
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @can ('closure_date-create')
        <a href="{{ route('closure_dates.create') }}" class="btn btn-primary mb-3">Create New Closure Date</a>
        @endcan
      
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Academic Year</th>
                    <th>Idea Closure Date</th>
                    <th>Comment Closure Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($closureDates as $closureDate)
                    <tr>
                        <td>{{ $closureDate->Academic_Year }}</td>
                        <td>{{ $closureDate->Idea_ClosureDate }}</td>
                        <td>{{ $closureDate->Comment_ClosureDate }}</td>
                        <td>
                            
                            @can ('closure_date-edit')
                            <a href="{{ route('closure_dates.edit', $closureDate->ClosureDate_id) }}" class="btn btn-warning btn-sm">Edit</a>
                            @endcan
                           
                            <form action="{{ route('closure_dates.destroy', $closureDate->ClosureDate_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                @can ('closure_date-delete')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this closure date?')">Delete</button>
                                @endcan
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
