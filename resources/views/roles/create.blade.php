@extends('layouts.app')

@section('content')
<div class="container-fluid min-vh-100 bg-light py-4">
    <div class="row justify-content-center">
        <div class="col-xxl-8 col-xl-9 col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-success bg-gradient d-flex align-items-center gap-2">
                    <i class="bi bi-shield-lock fs-4"></i>
                    <h5 class="mb-0 text-white">{{ __('Create Role') }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{route('roles.store')}}" method="POST">
                        @csrf                 
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">
                                <i class="bi bi-tag me-2"></i>Role Name
                            </label>
                            <input type="text" id="name" name="name" 
                                class="form-control form-control-lg shadow-sm" 
                                value="{{ old('name') }}"
                                placeholder="Enter role name">
                            @error('name')
                                <span class="text-danger mt-1 d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="permissions-section mb-4">
                            <h3 class="mb-3">
                                <i class="bi bi-key me-2"></i>Permissions
                            </h3>
                            <div class="row g-4">
                                @foreach($permissions->chunk(ceil($permissions->count() / 2)) as $chunk)
                                    <div class="col-lg-6">
                                        <div class="card shadow-sm h-100">
                                            <div class="card-body">
                                                @foreach($chunk as $permission)
                                                    <div class="form-check mb-2">
                                                        <input type="checkbox" 
                                                            class="form-check-input" 
                                                            id="permission_{{$permission->name}}" 
                                                            name="permissions[{{$permission->name}}]" 
                                                            value="{{$permission->name}}">
                                                        <label class="form-check-label" for="permission_{{$permission->name}}">
                                                            <i class="bi bi-check-circle me-2"></i>
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
                                class="btn btn-outline-dark btn-lg px-4">
                                <i class="bi bi-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-success btn-lg px-4">
                                <i class="bi bi-check-lg me-2"></i>Create Role
                            </button>
                        </div>
                    </form>                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
