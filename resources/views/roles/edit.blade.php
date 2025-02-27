@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-warning text-white">{{ __('Edit Role') }}</div>

                <div class="card-body">
                    <form action="{{route('roles.update',$role->id)}}" method="POST">
                        @csrf
                        @method ('PUT')
                       
                        <div class="mt-2 d-flex align-items-center">
                            <label for="name" class="me-2" style="min-width: 80px;">Name:</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $role->name }}">
                        </div>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <div class="mt-2">
                            <h3>Permissions:</h3>
                            <div class="row">
                                @foreach($permissions->chunk(ceil($permissions->count() / 2)) as $chunk)
                                    <div class="col-md-6">
                                        @foreach($chunk as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="permission_{{$permission->name}}" 
                                                    name="permissions[{{$permission->name}}]" 
                                                    value="{{$permission->name}}" 
                                                    {{$role->hasPermissionTo($permission->name) ? 'checked' : ''}}>
                                                <label class="form-check-label" for="permission_{{$permission->name}}">
                                                    {{$permission->name}}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        <div class="mt-2 d-flex justify-content-between">
                            <a href="{{ route('roles.index') }}" class="btn btn-outline-warning text-dark">Back</a>
                            <button type="submit" class="btn btn-warning">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
