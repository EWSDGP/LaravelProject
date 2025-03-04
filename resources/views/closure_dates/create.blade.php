@extends('layouts.app')

@section('content')
   
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-success text-white">{{ __('Create Closure Date') }}</div>
                <div class="card-body">   
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

        <div class="mt-2 d-flex justify-content-between">
           <a href="{{route('closure_dates.index')}}" class="btn btn-outline-dark">Back</a>
           <button type="submit" class="btn btn-success">Create</button>
        </div>
        
    </form>
</div>
@endsection
