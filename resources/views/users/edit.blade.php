@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Edit User') }}</div>

                <div class="card-body">
                    <a href="{{route('users.index')}}" class="btn btn-info mb-3">Back</a>
                    <form action="{{route('users.update',$user->id)}}" method="POST">
                        @csrf
                        @method ('PUT')
                       
                        <div class="mt-2">
                            <label>Name:</label>
                            <input type="text" name="name" class="form-control" value="{{$user->name}}">
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label>Email:</label>
                            <input type="text" name="email" class="form-control" value="{{$user->email}}">
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
                                <option value="{{$role->name}}"{{$user->hasRole($role->name)?"selected":""}}>{{$role->name}}</option>
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
