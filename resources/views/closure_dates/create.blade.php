@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Create Closure Date</h1>

       
        <form action="{{ route('closure_dates.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="Idea_ClosureDate" class="form-label">Idea Closure Date:</label>
                <input type="date" name="Idea_ClosureDate" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="Comment_ClosureDate" class="form-label">Comment Closure Date:</label>
                <input type="date" name="Comment_ClosureDate" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="Academic_Year" class="form-label">Academic Year:</label>
                <input type="text" name="Academic_Year" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
