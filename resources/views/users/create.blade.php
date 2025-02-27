@extends('layouts.app')

@section('content')
    <div class="bg-leaf text-white d-flex justify-content-center align-items-center p-4 position-relative">
        <a href="{{ route('users.index') }}" class="position-absolute text-white fs-5" style="top: 50%; left: 30px; transform: translate(-50%, -50%);" >
            <i class="fas fa-arrow-left"></i>
        </a>
        <h3 class="m-0 fs-4">Add Account</h3>
    </div>
    <div class="bg-white">
        <div>
            <form class="px-5 py-1" action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="mt-4">
                    <label class="mb-1">Name:</label>    
                    <input type="text" name="name" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <label class="mb-1">Email:</label>
                    <input type="text" name="email" class="form-control">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <label class="mb-1">Password:</label>
                    <input type="password" name="password" class="form-control">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <label class="mb-1">Role:</label>
                    <select class="form-select" name="department_id">
                        <option value="" disabled selected>-- Select Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4">
                    <label class="mb-1">Department (Optional):</label>
                    <select class="form-select" name="department_id">
                        <option value="" disabled selected>-- Select Department --</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-5">
                    <button class="btn btn-primary w-100 p-2">Submit</button>
                </div>
            </form>
        </div>
    @endsection
