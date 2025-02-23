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
                <div class="card-header">{{ __('Users') }}</div>

                <div class="card-body">
                @can ('user-create')
                    <a href="{{route('users.create')}}" class="btn btn-success mb-3">Create User</a>
                @endcan
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @foreach($user->getRoleNames() as $role)
                                    <button class="btn btn-success btn-sm">{{$role}}</button>
                                    @endforeach
                                </td>
                               <td>
                               <form action="{{route('users.destroy',$user->id)}}" method="POST">
                        @csrf
                        @method ('DELETE')
                        @can ('user-list')
                                  <a href="{{route('users.show',$user->id)}}" class="btn btn-sm btn-info">Details</a>
                        @endcan
                        @can ('user-edit')
                                  <a href="{{route('users.edit',$user->id)}}" class="btn btn-sm btn-info">Edit</a>
                                @endcan
                                @can ('user-delete')
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
