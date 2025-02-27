@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
             @session('success')
                        <div class="alert alert-success">
                                    {{$value}}
                        </div>
                        @endsession
                <div class="card-header">{{ __('Roles') }}</div>

                <div class="card-body">
                @can ('role-create')
                    <a href="{{route('roles.create')}}" class="btn btn-success mb-3">Create Role</a>
                    @endcan
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{$role->id}}</td>
                                <td>{{$role->name}}</td>
                               
                                
                               <td>
                               <form action="{{route('roles.destroy',$role->id)}}" method="POST">
                        @csrf
                        @method ('DELETE')
                        @can ('role-list')
                                  <a href="{{route('roles.show',$role->id)}}" class="btn btn-sm btn-info">Details</a>
                        @endcan
                        @can ('role-edit')
                                  <a href="{{route('roles.edit',$role->id)}}" class="btn btn-sm btn-info">Edit</a>
                        @endcan
                        @can ('role-delete')
                               <button class="btn btn-danger btn-sm">Delete</button>
                        @endcan
                               </form>
                            </td>
                            </tr>
                            
                            
                            @endforeach
                        </tbody>
                      
                    </table>

                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
