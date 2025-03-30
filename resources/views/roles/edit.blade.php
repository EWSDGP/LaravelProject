@extends('layouts.app')

@section('content')
<div class="container-fluid min-vh-100 bg-light py-4">
    <div class="row justify-content-center">
        <div class="col-xxl-8 col-xl-9 col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white d-flex align-items-center">
                    <i class="bi bi-shield-lock me-2 fs-5"></i>
                    <h5 class="mb-0">{{ __('Edit Role') }}</h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{route('roles.update',$role->id)}}" method="POST">
                        @csrf
                        @method ('PUT')
                       
                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-warning text-white">
                                    <i class="bi bi-person-badge"></i>
                                </span>
                                <input type="text" id="name" name="name" 
                                    class="form-control form-control-lg" 
                                    value="{{ $role->name }}"
                                    placeholder="Role Name">
                            </div>
                            @error('name')
                                <span class="text-danger small">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="bi bi-key me-2"></i>
                                Permissions
                            </h5>
                            <div class="row g-3">
                                @foreach($permissions->chunk(ceil($permissions->count() / 2)) as $chunk)
                                    <div class="col-lg-6">
                                        <div class="card h-100 bg-light border">
                                            <div class="card-body">
                                                @foreach($chunk as $permission)
                                                    <div class="form-check mb-2">
                                                        <input type="checkbox" 
                                                            class="form-check-input" 
                                                            id="permission_{{$permission->name}}" 
                                                            name="permissions[{{$permission->name}}]" 
                                                            value="{{$permission->name}}" 
                                                            {{$role->hasPermissionTo($permission->name) ? 'checked' : ''}}>
                                                        <label class="form-check-label" for="permission_{{$permission->name}}">
                                                            <i class="bi bi-check2-circle me-1"></i>
                                                            {{$permission->name}}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('roles.index') }}" 
                                class="btn btn-outline-warning btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>
                                Back
                            </a>
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="bi bi-check2 me-2"></i>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
