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
            <div class="navbar d-flex justify-content-start align-items-center fs-5 nav-height">
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
                    <i class="fa-solid fa-home pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('statistics.index') }}">Dashboard</a>
                </li>
                @endcanany
                @canany(['category-create', 'category-list', 'category-edit', 'category-delete'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('categories*') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-calendar-days pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('categories.index') }}">Categories</a>
                </li>
                @endcanany
                @canany(['department-create', 'department-list', 'department-edit', 'department-delete'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('departments*') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-user-tie pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('departments.index') }}">Departments</a>
                </li>
                @endcanany
                @can(['coordinator-statistics'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('departments*') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-user-tie pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('reminder') }}">Reminder</a>
                </li>
                @endcan
                @canany(['manage-reports'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('manage-reports*') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-user-tie pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('manage.reports.index') }}">Manage Report</a>
                </li>
                @endcanany
                @canany(['idea-list'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('ideas') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-user-tie pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('ideas.index') }}">View Ideas</a>
                </li>
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('ideas/closed') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-user-tie pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('ideas.closed') }}">View Closed Ideas</a>
                </li>
                @endcanany
                @canany(['closure_date-create', 'closure_date-list', 'closure_date-edit', 'closure_date-delete'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('closure-date') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-user-tie pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('closure_dates.index') }}">Manage Closure_Dates</a>
                </li>
                @endcanany
                @role('Admin')
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('roles') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-calendar-days pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('roles.index') }}">Role Management</a>
                </li>
                @endrole
                @canany(['user-list', 'user-create', 'user-edit', 'user-delete'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('users') ? 'hover_active' : '' }}"
                    style="height: 7rem">
                    <i class="fa-solid fa-user-tie pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('users.index') }}">Account Management</a>
                </li>
                @endcanany

                <div class="d-flex flex-column mt-auto w-100">
                    <div class="d-flex flex-column mt-auto w-100">
                        <div class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('settings') ? 'hover_active' : '' }}"
                            style="height: 7rem">
                            <i class="fa-solid fa-gear pe-2"></i>
                            <a class="text-decoration-none" href="{{ route('settings') }}">Setting</a>
                        </div>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                        class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4"
                        style="height: 7rem">
                        @csrf
                        <i class="fa-solid fa-arrow-right-from-bracket pe-2"></i>
                        <a class="dropdown-item" href="#" id="logoutButton">
                            <i class="bi bi-box-arrow-right me-2"></i>{{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </form>
                </div>

                @endguest
            </div>
        </div>
        <div class="navi-back" style="width: 17%; height: 100vh">

        </div>

        <div class="full-content w-83">

            <div class="d-flex justify-content-between align-items-center w-100" style="height: 7rem">

                <div class="d-flex justify-content-start align-items-center px-4 w-50">
                    <i class="fa-solid fa-bars menu-bars fs-5"></i>

                    <div class="d-flex justify-content-start align-items-center gap-4 m-auto">
                        <img src=" {{ asset('images/logo.png') }}" alt="Logo" class="img-fluid rounded-circle"
                            style="width: 80px; height: 80px;">
                        <h3> {{ session('title') }} </h3>
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

                        <img src="{{ $profilePhoto }}" alt="Profile Photo" class="img-fluid rounded-circle"
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
                    <div class="last-login ps-4 d-flex flex-column justify-content-center">
                        <p>Last Login: </p>
                        <p> {{ $previousLogin->login_time }} / {{ $previousLogin->login_date }} </p>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    document.getElementById('logout-form').submit();
                }
            });
        });
    </script>


</body>

</html>