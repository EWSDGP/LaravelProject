@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Show User Details') }}</div>

                <div class="card-body">
                    <a href="{{route('users.index')}}" class="btn btn-info mb-3">Back</a>
               
                        @csrf

                       
                        <div class="mt-2">
                            <label>Name:</label>
                            <p>{{$user->name}}</p>
                           
                        </div>
                        <div class="mt-2">
                            <label>Email:</label>
                            <p>{{$user->email}}</p>
                           
                        </div>
                        <!-- <div class="mt-2">
                            <label>Password:</label>
                            <p>{{$user->password}}</p>
                            
                        </div> -->
                       
                    </form>


                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
