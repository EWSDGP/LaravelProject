{{-- @extends('layouts.app')

@section('content')

    <div style="background-color: #e9f1fa; height: 100vh">
        <div class="bg-white">
            <div class="bg-leaf text-white d-flex justify-content-center align-items-center p-4">
                <h3 class="m-0 fs-4">User Settings</h3>
            </div>


            




            <div class="d-flex border-bottom">
                <!-- Sidebar for settings menu -->
                <div class="bg-white" style="width: 100%; border-right: 1px solid #ddd;">
                    <div class="d-flex list-group-flush">
                        <a href="{{ route('settings', ['section' => 'change-password']) }}"
                            class="px-3 py-4 list-group-item list-group-item-action {{ $section === 'change-password' ? 'active' : '' }}">
                            Change Password
                        </a>
                        <a href="{{ route('settings', ['section' => 'change-profile']) }}"
                            class="px-3 py-4 list-group-item list-group-item-action {{ $section === 'change-profile' ? 'active' : '' }}">
                            Change Profile
                        </a>
                        <a href="{{ route('settings', ['section' => 'login-history']) }}"
                            class="px-3 py-4 list-group-item list-group-item-action {{ $section === 'login-history' ? 'active' : '' }}">
                            Login History
                        </a>
                    </div>
                </div>

                <div class="bg-white" style="width: 75%; background-color: #ddd;">


                </div>
                
            </div>

            <div class="p-5" style="width: 100%;">
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
                            @if (empty($loginHistory))
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

@endsection --}}




@extends('layouts.app')

@section('content')


    <div class="setting-con container m-0 p-3">
        <div class="bg-white rounded shadow-sm" style="border-top: 1px solid white">

            <!-- Tab navigation -->
            <ul class="nav nav-pills justify-content-center mt-4" id="settings-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ route('settings', ['section' => 'change-password']) }}"
                class="nav-link {{ $section === 'change-password' ? 'active' : '' }}" id="change-password-tab"
                role="tab" aria-controls="change-password"
                aria-selected="{{ $section === 'change-password' ? 'true' : 'false' }}">Change Password</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('settings', ['section' => 'change-profile']) }}"
                class="nav-link {{ $section === 'change-profile' ? 'active' : '' }}" id="change-profile-tab"
                role="tab" aria-controls="change-profile"
                aria-selected="{{ $section === 'change-profile' ? 'true' : 'false' }}">Change Profile</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('settings', ['section' => 'login-history']) }}"
                class="nav-link {{ $section === 'login-history' ? 'active' : '' }}" id="login-history-tab"
                role="tab" aria-controls="login-history"
                aria-selected="{{ $section === 'login-history' ? 'true' : 'false' }}">Login History</a>
            </li>
            </ul>

            <div class="tab-content" id="settings-tabs-content">

            <!-- Change Password Section -->

            @if ($section === 'change-password')
                <div class="tab-pane fade {{ $section === 'change-password' ? 'show active' : '' }}"
                id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
                <div class="mt-4 p-4 shadow-sm bg-light border-top">
                    <h5 class="mb-3 text-primary">{{ __('Change Password') }}</h5>
                    <form method="POST" action="{{ route('change-password') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                        <input id="current_password" type="password"
                        class="form-control @error('current_password') is-invalid @enderror"
                        name="current_password" required>
                        @error('current_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">{{ __('New Password') }}</label>
                        <input id="new_password" type="password"
                        class="form-control @error('new_password') is-invalid @enderror" name="new_password"
                        required>
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
                        name="new_password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Change Password') }}</button>
                    </form>
                </div>
                </div>

                <!-- Change Profile Section -->
            @elseif ($section === 'change-profile')
                <div class="tab-pane fade {{ $section === 'change-profile' ? 'show active' : '' }}" id="change-profile"
                role="tabpanel" aria-labelledby="change-profile-tab">
                <div class="mt-4 p-4 border-top shadow-sm bg-light">
                    <h5 class="mb-3 text-primary">{{ __('Change Profile') }}</h5>
                    <form method="POST" action="{{ route('change-profile') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input id="name" type="text"
                        class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ Auth::user()->name }}" required>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ Auth::user()->email }}" required>
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
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Update Profile') }}</button>
                    </form>
                </div>
                </div>

                <!-- Login History Section -->
            @elseif ($section === 'login-history')
                <div class="tab-pane fade {{ $section === 'login-history' ? 'show active' : '' }}" id="login-history"
                role="tabpanel" aria-labelledby="login-history-tab">
                <div class="mt-4 p-4 border-top shadow-sm bg-light">
                    <h5 class="mb-3 text-primary">{{ __('Login History') }}</h5>
                    @if (empty($loginHistory))
                    <p>No login history available.</p>
                    @else
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Time</th>
                            <th>Day</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($loginHistory->take(13) as $index => $login)
                            <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $login->login_time }}</td>
                            <td>{{ \Carbon\Carbon::parse($login->login_date)->format('l') }}</td>
                            <td>{{ $login->login_date }}</td>


                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
                </div>
            @elseif (empty($section))
                <!-- Default Settings Content -->
                <div class="tab-pane fade {{ empty($section) ? 'show active' : '' }}" id="default-settings"
                role="tabpanel">
                <div class="mt-4 p-4 border rounded shadow-sm bg-light">
                    <h5 class="mb-3 text-primary">{{ __('Settings') }}</h5>
                    <p>Select an option from the menu to manage your settings.</p>
                </div>
                </div>

            @endif

            </div>
        </div>
    </div>

@endsection
