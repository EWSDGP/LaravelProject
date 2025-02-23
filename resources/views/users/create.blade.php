@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
           
                <div class="card-header">{{ __('Create User') }}</div>
         
                <div class="card-body">
                    <a href="{{route('users.index')}}" class="btn btn-info mb-3">Back</a>
                    <form action="{{route('users.store')}}" method="POST">
                        @csrf

                       
                        <div class="mt-2">
                            <label>Name:</label>
                            <input type="text" name="name" class="form-control">
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label>Email:</label>
                            <input type="text" name="email" class="form-control">
                            @error('email')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label>Password:</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label for="">Role:</label>
                            <select class="form-select" name="roles[]" multiple>
                                <option value="">--Select Role --</option>
                                @foreach($roles as $role)
                                <option value="{{$role->name}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>


                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
