

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-success text-white">{{ __('Create New Department') }}</div>

                <div class="card-body">
                    
                <form action="{{ route('departments.store') }}" method="POST">
        @csrf
        <div class="mt-2 d-flex align-items-center">
           <label for="name">Deparment Name</label>
           <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mt-2 d-flex justify-content-between">
           <a href="{{route('departments.index')}}" class="btn btn-outline-dark">Back</a>
           <button type="submit" class="btn btn-success">Save</button>
        </div>
        
    </form>
</div>
@endsection
