@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">{{ __('Show Role Details') }}</div>

                <div class="card-body">
               
                        @csrf

                       
                        <div class="d-flex align-items-center mt-2">
                           <h3><label class="me-2">Name:</label></h3> 
                            <p class="mb-0">{{$role->name}}</p>
                        </div>


                        <div class="mt-2 d-flex align-items-center flex-wrap">
                            <h3 class="me-2">Permissions:</h3>
                            @foreach($role->permissions as $permission)
                                <p class="mb-0 me-2 badge bg-primary">{{$permission->name}}</p>
                            @endforeach
                        </div>
                        </div>
                <a href="{{route('roles.index')}}" class="btn btn-outline-primary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
