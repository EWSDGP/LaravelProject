@extends('layouts.app')
 
@section('content')
<div class="container-fluid p-0 min-vh-100 mt-4">
    <div class="row g-0">
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-0 h-100">
                <div class="card-header bg-primary bg-gradient text-white py-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-shield-lock-fill fs-3 me-3"></i>
                        <h4 class="mb-0">{{ __('Role Details') }}</h4>
                    </div>
                    <a href="{{route('roles.index')}}" class="btn btn-light btn-sm rounded-pill px-4 py-2">
                        <i class="bi bi-arrow-left me-2"></i> Back
                    </a>
                </div>
 
                <div class="card-body p-4 p-md-5 pt-5">
                    @csrf
                   
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                            <i class="bi bi-person-badge-fill fs-3 text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">Role Name</h6>
                                            <h3 class="mb-0 fw-bold text-primary">{{$role->name}}</h3>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-tag-fill me-2 text-primary"></i>
                                            <span class="text-muted">Role ID: <span class="text-dark">{{$role->id}}</span></span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-info-circle-fill me-2 text-primary"></i>
                                            <span class="text-muted">This role has been assigned to users with specific permissions.</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-shield-check me-2 text-primary"></i>
                                            <span class="text-muted">Total Permissions: <span class="text-dark">{{count($role->permissions)}}</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-12 col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                            <i class="bi bi-clock-history fs-3 text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">Created</h6>
                                            <h5 class="mb-0">{{$role->created_at ? $role->created_at->format('M d, Y') : 'N/A'}}</h5>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-calendar-event me-2 text-primary"></i>
                                            <span class="text-muted">Created Date: <span class="text-dark">{{$role->created_at ? $role->created_at->format('M d, Y') : 'N/A'}}</span></span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-clock me-2 text-primary"></i>
                                            <span class="text-muted">Created Time: <span class="text-dark">{{$role->created_at ? $role->created_at->format('h:i A') : 'N/A'}}</span></span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-pencil-square me-2 text-primary"></i>
                                            <span class="text-muted">Last Updated: <span class="text-dark">{{$role->updated_at ? $role->updated_at->format('M d, Y h:i A') : 'N/A'}}</span></span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-arrow-repeat me-2 text-primary"></i>
                                            <span class="text-muted">Update Count: <span class="text-dark">{{$role->updated_at && $role->created_at ? $role->updated_at->diffInDays($role->created_at) : '0'}}</span> days</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
 
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light py-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                            <i class="bi bi-people-fill fs-3 text-primary"></i>
                                        </div>
                                        <h4 class="mb-0 fw-bold text-primary">Staff with this Role</h4>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row g-3">
                                        @if(isset($role->users) && count($role->users) > 0)
                                            @foreach($role->users as $user)
                                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                                    <div class="card border-0 shadow-sm h-100 hover-shadow">
                                                        <div class="card-body p-3 d-flex align-items-center">
                                                            <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                                                <i class="bi bi-person-fill fs-4 text-info"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">{{$user->name}}</h6>
                                                                <small class="text-muted">{{$user->email}}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-12">
                                                <div class="alert alert-info d-flex align-items-center">
                                                    <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                                                    <span>No staff members currently assigned to this role.</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
 
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light py-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                            <i class="bi bi-shield-lock-fill fs-3 text-primary"></i>
                                        </div>
                                        <h4 class="mb-0 fw-bold text-primary">Permissions</h4>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row g-3">
                                        @foreach($role->permissions as $permission)
                                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                                <div class="card border-0 shadow-sm h-100 hover-shadow">
                                                    <div class="card-body p-3 d-flex align-items-center">
                                                        <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                                            <i class="bi bi-check-circle-fill fs-4 text-success"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{$permission->name}}</h6>
                                                            <small class="text-muted">Permission granted</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
<style>
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease;
    }
</style>
@endsection