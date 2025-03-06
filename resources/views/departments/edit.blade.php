

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-warning text-black">{{ __('Edit Departments') }}</div>
                <div class="card-body">
                <form action="{{ route('departments.update',$department->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
           <label for="name">Deparment Name</label>
           <input type="text" class="form-control" id="name" name="name" value="{{ $department->name }}" required>
        </div>
        <div class="mt-2 d-flex justify-content-between">
           <a href="{{route('departments.index')}}" class="btn btn-outline-warning text-dark">Back</a>
           <button type="submit" class="btn btn-warning">Update</button>
        </div>
        
    </form>
</div>
@endsection
