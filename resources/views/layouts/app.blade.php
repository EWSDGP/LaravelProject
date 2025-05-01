<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('components/style.css') }}">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .navigation {
            scrollbar-width: none;
            /* Firefox */
        }

        .navigation::-webkit-scrollbar {
            display: none;
            /* WebKit */
        }

        .ps-4 {
            padding-left: 2.5rem !important;
        }
            .header-container {
        display: flex;
        align-items: center;
        padding: 0 2rem;
        width: 50%;
        background-color: #f8f9fa;
        border-radius: 12px;
        transition: all 0.3s ease-in-out;
        }


        .menu-bars {
            font-size: 1.5rem;
            color: #007bff;
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }

        .menu-bars:hover {
            transform: scale(1.1);
        }

        .logo-title {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 0 auto;
        }

        .logo-title img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #007bff;
            transition: transform 0.3s ease-in-out;
        }

        .logo-title img:hover {
            transform: rotate(3deg) scale(1.05);
        }

        .logo-title h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            letter-spacing: 0.5px;
        }

        .profile-pic {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
            margin-right: 10px;
        }

        .profile-pic:hover {
             transform: scale(1.05);
        }

        .badge-login {
            display: flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #007bff, #00c6ff);
            color: #fff;
            padding: 8px 16px;
            border-radius: 30px;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .badge-login i {
            font-size: 1.2rem;
            color: #fff;
        }

        .last-login-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .hover-div i {
            width: 30px;
        }
    </style>
</head>

<body>

    <div class="d-flex w-100" style="height: 100vh" id="app">

        @include('layouts.mobileapp')

        <div class="navigation bg-nav text-white position-fixed overflow-auto"
            style="width: 17%; height: 100vh; overflow-y: auto;">
            <div class="bg-nav-title d-flex justify-content-center align-items-center" style="height: 7rem">
                <h3 class="m-0">
                    Bright Path
                </h3>
            </div>
            <!-- Right Side Of Navbar -->
            <div class="navbar d-flex flex-column justify-content-between align-items-center fs-5 nav-height" style="height: calc(100vh - 7rem);">
                @php
                    $navItems = [];
                    if (Auth::check()) {
                        if (Auth::user()->can('statistics')) {
                            $navItems[] = 'statistics';
                        }
                        if (Auth::user()->canAny(['category-create', 'category-list', 'category-edit', 'category-delete'])) {
                            $navItems[] = 'categories';
                        }
                        if (Auth::user()->canAny(['department-create', 'department-list', 'department-edit', 'department-delete'])) {
                            $navItems[] = 'departments';
                        }
                        if (Auth::user()->can('coordinator-statistics')) {
                            $navItems[] = 'reminder';
                        }
                        if (Auth::user()->canAny(['manage-reports'])) {
                            $navItems[] = 'manage-reports';
                        }
                        if (Auth::user()->canAny(['idea-list'])) {
                            $navItems[] = 'ideas';
                            $navItems[] = 'closed-ideas';
                        }
                        if (Auth::user()->canAny(['closure_date-create', 'closure_date-list', 'closure_date-edit', 'closure_date-delete'])) {
                            $navItems[] = 'closure-date';
                        }
                        if (Auth::user()->hasRole('Admin')) {
                            $navItems[] = 'roles';
                        }
                        if (Auth::user()->canAny(['user-list', 'user-create', 'user-edit', 'user-delete'])) {
                            $navItems[] = 'users';
                        }
                    }
                    $showSettingsAtBottom = count($navItems) <= 5;
                @endphp
                <div class="w-100">
                <!-- Authentication Links -->
                @guest
                @if (Route::has('login'))
                <li class="nav-items hover-div nav-item d-flex justify-content-start align-items-center w-100 ps-4"
                    style="height: 7rem">
                    <i class="fa-solid fa-arrow-right-to-bracket pe-4"></i>
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @endif

                @if (Route::has('register'))
                <li class="nav-items hover-div nav-item d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('register*') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-arrow-right-to-bracket pe-4"></i>
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                @canany(['statistics'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('statistics*') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-chart-line pe-3"></i>
                    <a class="text-decoration-none" href="{{ route('statistics.index') }}">Dashboard</a>
                </li>
                @endcanany
                @canany(['category-create', 'category-list', 'category-edit', 'category-delete'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('categories*') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-tags pe-3"></i>
                    <a class="text-decoration-none" href="{{ route('categories.index') }}">Categories</a>
                </li>
                @endcanany
                @canany(['department-create', 'department-list', 'department-edit', 'department-delete'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('departments*') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-building pe-3"></i>
                    <a class="text-decoration-none" href="{{ route('departments.index') }}">Departments</a>
                </li>
                @endcanany
                @can(['coordinator-statistics'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('departments*') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-bell pe-3"></i>
                    <a class="text-decoration-none" href="{{ route('reminder') }}">Reminder</a>
                </li>
                @endcan
                @canany(['manage-reports'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('manage-reports*') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-file-lines pe-3"></i>
                    <a class="text-decoration-none" href="{{ route('manage.reports.index') }}">Manage Report</a>
                </li>
                @endcanany
                @canany(['idea-list'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('ideas') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-lightbulb pe-3"></i>
                    <a class="text-decoration-none" href="{{ route('ideas.index') }}">View Ideas</a>
                </li>
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('ideas/closed') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-lock pe-3"></i>
                    <a class="text-decoration-none" href="{{ route('ideas.closed') }}">View Closed Ideas</a>
                </li>
                @endcanany
                @canany(['closure_date-create', 'closure_date-list', 'closure_date-edit', 'closure_date-delete'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('closure-date') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-clock pe-3"></i>
                    <a class="text-decoration-none" href="{{ route('closure_dates.index') }}">Manage Closure_Dates</a>
                </li>
                @endcanany
                @role('Admin')
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('roles') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-user-shield pe-3"></i>
                    <a class="text-decoration-none" href="{{ route('roles.index') }}">Role Management</a>
                </li>
                @endrole
                @canany(['user-list', 'user-create', 'user-edit', 'user-delete'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('users') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-users-gear pe-3"></i>
                    <a class="text-decoration-none" href="{{ route('users.index') }}">Account Management</a>
                </li>
                @endcanany

                    @if(!$showSettingsAtBottom)
                        <div class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('settings') ? 'hover_active' : '' }}"
                            style="height: 7rem">
                            <i class="fa-solid fa-gear pe-3"></i>
                            <a class="text-decoration-none" href="{{ route('settings') }}">Setting</a>
                        </div>
                    <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4" style="height: 7rem">
                        <i class="fa-solid fa-right-from-bracket pe-3"></i>
                        <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button id="logoutButton" type="submit" class="btn btn-link nav-link text-white p-0" style="text-decoration: none;">
                                Logout
                            </button>
                        </form>
                    </li>
                    @endif
                    @endguest
                </div>

                @if($showSettingsAtBottom)
                <div class="w-100 mt-auto">
                    <div class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('settings') ? 'hover_active' : '' }}"
                        style="height: 7rem">
                        <i class="fa-solid fa-gear pe-3"></i>
                        <a class="text-decoration-none" href="{{ route('settings') }}">Setting</a>
                    </div>
                    <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4" style="height: 7rem">
                        <i class="fa-solid fa-right-from-bracket pe-3"></i>
                        <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button id="logoutButton" type="submit" class="btn btn-link nav-link text-white p-0" style="text-decoration: none;">
                                Logout
                            </button>
                        </form>
                    </li>
                </div>
                @endif
            </div>
        </div>
        <div class="navi-back" style="width: 17%; height: 100vh">

        </div>

        <div class="full-content w-83">

            <div class="d-flex justify-content-between align-items-center w-100" style="height: 7rem">

            <div class="header-container">
                <i class="fa-solid fa-bars menu-bars"></i>
                
                <div class="logo-title">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                    <h3>{{ session('title') }}</h3>
                </div>
            </div>


                <div class="search d-flex justify-content-end align-items-center w-50 pe-4">

                    <div class="d-flex justify-content-end align-items-center fs-2 gap-5">

                        @if (Auth::check())
                        @php

                        $profilePhotoPath = Auth::user()->profile_photo;
                        $defaultPhoto = asset('storage/profile_photos/default-profile.jpg');

                        if (!empty($profilePhotoPath) && Storage::exists($profilePhotoPath)) {
                        $profilePhoto = asset('storage/' . $profilePhotoPath);
                        } else {
                        $profilePhoto = $defaultPhoto;
                        }
                        @endphp

                        <img src="{{ $profilePhoto }}" alt="Profile Photo"  class="profile-pic"
                            width="50" height="50">
                        @endif



                    </div>


                    @php
                    use App\Models\UserLogin;

                    $previousLogin = null;

                    if (Auth::check()) {
                    $logins = UserLogin::where('user_id', Auth::id())
                    ->orderBy('login_date', 'desc')
                    ->orderBy('login_time', 'desc')
                    ->take(2)
                    ->get();

                    if ($logins->count() > 1) {
                    $previousLogin = $logins[1];
                    }
                    }
                    @endphp

                    @if ($previousLogin)
                <div class="badge badge-login">
                    <i class="fas fa-clock"></i>
                    <div class="last-login-text">
                        <span>Last Login:</span>
                        <span>{{ $previousLogin->login_time }} / {{ $previousLogin->login_date }}</span>
                    </div>
                </div>
                    @endif

                </div>


            </div>

            <div class="pb-3" style="background-color: #e9f1fa; height: auto;">
                @yield('content')
            </div>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('components/script.js') }}"></script>
    

    <script>
        document.getElementById('logoutButton').addEventListener('click', function(event) {
        event.preventDefault();
        Swal.fire({
            title: "Are you sure?",
            text: "You will be logged out from your account!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, logout",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    });


    </script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>