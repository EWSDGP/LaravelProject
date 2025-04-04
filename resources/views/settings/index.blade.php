@extends('layouts.app')

@section('content')

    <div style="background-color: #e9f1fa; height: 100vh">
        <div class="bg-white">
            <div class="bg-leaf text-white d-flex justify-content-center align-items-center p-4">
                <h3 class="m-0 fs-4">User Settings</h3>
            </div>

            <div class="d-flex">
                <!-- Sidebar for settings menu -->
                <div class="bg-white p-4" style="width: 25%; border-right: 1px solid #ddd;">
                    <h5 class="pb-2">Settings Menu</h5>
                    <div class="list-group">
                        <a href="{{ route('settings', ['section' => 'change-password']) }}"
                            class="list-group-item list-group-item-action {{ $section === 'change-password' ? 'active' : '' }}">
                            Change Password
                        </a>
                        <a href="{{ route('settings', ['section' => 'change-profile']) }}"
                            class="list-group-item list-group-item-action {{ $section === 'change-profile' ? 'active' : '' }}">
                            Change Profile
                        </a>
                        <a href="{{ route('settings', ['section' => 'login-history']) }}"
                            class="list-group-item list-group-item-action {{ $section === 'login-history' ? 'active' : '' }}">
                            Login History
                        </a>
                    </div>
                </div>

                <!-- Main content area -->
                <div class="p-4" style="width: 75%;">
                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($section === 'change-password')
                        <!-- Change Password Form -->
                        <div class="card">
                            <div class="card-header">{{ __('Change Password') }}</div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('change-password') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="current_password"
                                            class="form-label">{{ __('Current Password') }}</label>
                                        <input id="current_password" type="password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            name="current_password" required autocomplete="current-password">

                                        @error('current_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">{{ __('New Password') }}</label>
                                        <input id="new_password" type="password"
                                            class="form-control @error('new_password') is-invalid @enderror"
                                            name="new_password" required autocomplete="new-password">

                                        @error('new_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="new_password_confirmation"
                                            class="form-label">{{ __('Confirm New Password') }}</label>
                                        <input id="new_password_confirmation" type="password" class="form-control"
                                            name="new_password_confirmation" required autocomplete="new-password">
                                    </div>

                                    <div class="mb-0">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Change Password') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @elseif ($section === 'change-profile')
                        <!-- Change Profile Section -->
                        <div class="card">
                            <div class="card-header">{{ __('Change Profile') }}</div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('change-profile') }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="name" class="form-label">{{ __('Name') }}</label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ Auth::user()->name }}" required>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ Auth::user()->email }}" required>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="profile_picture" class="form-label">{{ __('Profile Picture') }}</label>
                                        <input id="profile_picture" type="file"
                                            class="form-control @error('profile_picture') is-invalid @enderror"
                                            name="profile_picture">

                                        @error('profile_picture')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    <div class="mt-3 mb-0">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Update Profile') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    


                    @elseif ($section === 'login-history')
                        <!-- Login History Section -->
                        <div class="card">
                            <div class="card-header">{{ __('Login History') }}</div>
                            <div class="card-body">
                                @if ($loginHistory->isEmpty())
                                    <p>No login history available.</p>
                                @else
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($loginHistory as $index => $login)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $login->login_date }}</td>
                                                    <td>{{ $login->login_time }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- Default Settings Content -->
                        <div class="card">
                            <div class="card-header">{{ __('Settings') }}</div>
                            <div class="card-body">
                                <p>Select an option from the menu to manage your settings.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
