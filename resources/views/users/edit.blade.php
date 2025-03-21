@extends('layouts.app')

@section('content')
    <div class="bg-leaf text-white d-flex justify-content-center align-items-center p-4 position-relative w-100">
        <a href="{{ route('users.index') }}" class="position-absolute text-white fs-5"
            style="top: 50%; left: 30px; transform: translate(-50%, -50%);">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h3 class="m-0 fs-4">Add Account</h3>
    </div>
    <div class="bg-white">
        <div>
            <form class="px-5 py-1" action="{{ route('users.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method ('PUT')

                <div class="mt-4">
                    <label class="mb-1">Name:</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <label class="mb-1">Email:</label>
                    <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- <div class="mt-4">
                    <label class="mb-1">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" value="{{ $user->password }}">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <span id="password_error" class="text-danger"></span>
                </div> -->

                <!-- <script>
                    document.getElementById('password').addEventListener('input', function () {
                        let password = this.value;
                        let errorSpan = document.getElementById('password_error');
                        let Button = document.getElementById('Button');
                        let hasNumber = /\d/;
                        let hasSpecialChar = /[@!#$%]/;
                        let minLength = password.length >= 8;

                        let errorMessages = [];

                        if (!minLength) {
                            errorMessages.push("At least 8 characters.");
                        }
                        if (!hasNumber.test(password)) {
                            errorMessages.push("At least one number.");
                        }
                        if (!hasSpecialChar.test(password)) {
                            errorMessages.push("At least one special character (@!#$%).");
                        }

                        if (errorMessages.length === 0) {
                            errorSpan.textContent = "";
                            Button.disabled = false;  
                        } else {
                            errorSpan.textContent = errorMessages.join(" ");
                            Button.disabled = true;
                        }
                    });
                </script> -->
                
                <div class="mt-4">
                    <label class="mb-1">Photo:</label>
                    <input type="file" name="photo" class="form-control">
                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <label class="mb-1">Role:</label>
                    <select class="form-select" name="roles[]">
                        validation
                        <option value="" disabled selected>-- Select Role --</option>
                        @foreach($roles as $role)
                                <option value="{{$role->name}}"{{$user->hasRole($role->name)?"selected":""}}>{{$role->name}}</option>
                                @endforeach
                    </select>
                </div>
                <div class="mt-4">
                    <label class="mb-1">Department:</label>
                    <select class="form-select" name="department_id">
                        <option value="" disabled selected>-- Select Department --</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}"
                                {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="mt-5">
                    <button type="submit" id="Button" class="btn btn-primary w-100 p-2">Submit</button>
                </div>
            </form>
        </div>
    @endsection
