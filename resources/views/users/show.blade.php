@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Show User Details') }}</div>

                <div class="card-body">
                    <a href="{{ route('users.index') }}" class="btn btn-info mb-3">Back</a>

                    <div class="mt-2">
                        <label><strong>Name:</strong></label>
                        <p>{{ $user->name }}</p>
                    </div>

                    <div class="mt-2">
                        <label><strong>Email:</strong></label>
                        <p>{{ $user->email }}</p>
                    </div>

                    <div class="mt-2">
                        <label><strong>Department:</strong></label>
                        <p>{{ $user->department ? $user->department->name : 'No Department Assigned' }}</p>
                    </div>

                    <div class="mt-2">
                        <label><strong>Roles:</strong></label>
                        <p>
                            @if($user->roles->isNotEmpty())
                                {{ implode(', ', $user->roles->pluck('name')->toArray()) }}
                            @else
                                No Role Assigned
                            @endif
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
