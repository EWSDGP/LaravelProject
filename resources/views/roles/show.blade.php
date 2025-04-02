@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary bg-gradient text-white d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-person-badge-fill me-2"></i>
                        {{ __('Show Role Details') }}
                    </div>
                    <a href="{{route('roles.index')}}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>

                <div class="card-body p-4">
                    @csrf
                    
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-light rounded-circle p-3 me-3">
                                    <i class="bi bi-person-fill fs-4 text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-1">Role Name</h6>
                                    <h4 class="mb-0">{{$role->name}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-light rounded-circle p-3 me-3">
                                    <i class="bi bi-shield-lock-fill fs-4 text-primary"></i>
                                </div>
                                <h4 class="mb-0">Permissions</h4>
                            </div>
                            <div class="mt-3 d-flex align-items-center flex-wrap gap-2">
                                @foreach($role->permissions as $permission)
                                    <span class="badge bg-primary bg-gradient p-2">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        {{$permission->name}}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
