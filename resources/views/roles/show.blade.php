@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Show Role Details') }}</div>

                <div class="card-body">
                    <a href="{{route('roles.index')}}" class="btn btn-info mb-3">Back</a>
               
                        @csrf

                       
                        <div class="mt-2">
                            <label>Name:</label>
                            <p>{{$role->name}}</p>
                           
                        </div>
                        <div class="mt-2">
                            <h3>Permissions:</h3>
                            @foreach($role->permissions as $permission)
                            <p>{{$permission->name}}</p>
                            @endforeach
                        </div>
                        
                           
                        </div>
                        
                       
                    </form>


                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
