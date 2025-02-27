

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Department</h1>
    <a href="{{route('departments.index')}}" class="btn btn-info mb-3">Back</a>
    <form action="{{ route('departments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Deparment Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Save</button>
    </form>
</div>
@endsection
