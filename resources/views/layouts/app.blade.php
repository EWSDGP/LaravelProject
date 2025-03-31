<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('components/style.css') }}">

</head>

<body>

    <div class="d-flex w-100" style="height: 100vh" id="app">

        @include('layouts.mobileapp')

        <div class="navigation bg-nav text-white position-fixed" style="width: 17%; height: 100vh">
            <div class="bg-nav-title d-flex justify-content-center align-items-center" style="height: 90px">
                <h3 class="m-0">
                    Greenwich
                </h3>
            </div>
            <!-- Right Side Of Navbar -->
            <div class="navbar d-flex flex-column justify-content-start align-items-center fs-5 nav-height">
                <!-- Authentication Links -->
                @guest

                @if (Route::has('login'))
                <li class="nav-items hover-div nav-item d-flex justify-content-start align-items-center w-100 ps-5"
                    style="height: 95px">
                    <i class="fa-solid fa-arrow-right-to-bracket pe-4"></i>
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @endif

                @if (Route::has('register'))
                <li class="nav-items hover-div nav-item d-flex justify-content-start align-items-center w-100 ps-5"
                    style="height: 95px">
                    <i class="fa-solid fa-arrow-right-to-bracket pe-4"></i>
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else

                @canany(['statistics'])
    <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-5"
        style="height: 95px">
        <i class="fa-solid fa-home pe-4"></i>
        <a class="text-decoration-none" href="{{ route('statistics.index') }}">Dashboard</a>
    </li>
    @endcanany
                @canany(['category-create', 'category-list', 'category-edit', 'category-delete'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-5"
                    style="height: 95px">
                    <i class="fa-solid fa-calendar-days pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('categories.index') }}">Categories</a>
                </li>
                @endcanany
                @canany(['department-create', 'department-list', 'department-edit', 'department-delete'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-5"
                    style="height: 95px">
                    <i class="fa-solid fa-user-tie pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('departments.index') }}">Departments</a>
                </li>
                @endcanany
                @canany(['manage-reports'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-5"
                    style="height: 95px">
                    <i class="fa-solid fa-user-tie pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('manage.reports.index') }}">Manage Report</a>

                </li>
                @endcanany
                @canany(['idea-list'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-5"
                    style="height: 95px">
                    <i class="fa-solid fa-user-tie pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('ideas.index') }}">View Ideas</a>
                </li>
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-5"
                    style="height: 95px">
                    <i class="fa-solid fa-user-tie pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('ideas.closed') }}">View Closed Ideas</a>
                </li>
            @endcanany
                @canany(['closure_date-create', 'closure_date-list', 'closure_date-edit', 'closure_date-delete'])
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-5"
                    style="height: 95px">
                    <i class="fa-solid fa-user-tie pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('closure_dates.index') }}">Manage Closure_Dates</a>
                </li>
                @endcanany
                @role('Admin')
                <li class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-5"
                    style="height: 95px">
                    <i class="fa-solid fa-calendar-days pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('roles.index') }}">Role Management</a>
                </li>
                @endrole
                @canany(['user-list', 'user-create', 'user-edit', 'user-delete'])
                <li class="nav-items hover-div nav-item d-flex justify-content-start align-items-center w-100 ps-5"
                    style="height: 95px">
                    <i class="fa-solid fa-user-tie pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('users.index') }}">Account Management</a>
                </li>
                @endcanany

                <div class="d-flex flex-column mt-auto w-100">
                    <div class="d-flex flex-column mt-auto w-100">
                        <div class="nav-items hover-div nav-item d-flex justify-content-start align-items-center w-100 ps-5" style="height: 95px">
                            <i class="fa-solid fa-gear pe-2"></i>
                            <a class="text-decoration-none" href="{{ route('settings') }}">Setting</a>
                        </div>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                        class="nav-items hover-div nav-item d-flex justify-content-start align-items-center w-100 ps-5"
                        style="height: 95px">
                        @csrf
                        <i class="fa-solid fa-arrow-right-from-bracket pe-2"></i>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
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

            <div class="d-flex justify-content-between align-items-center w-100" style="height: 90px">

                <div class="d-flex justify-content-start align-items-center px-4 w-50">
                    <i class="fa-solid fa-bars menu-bars fs-5"></i>

                    <div class="d-flex justify-content-start align-items-center gap-4 m-auto">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRalke-Kf6_TB5yrnMuUYP158MBQd4bezQIxw&s"
                            style="width: 80px; height: 80px;">
                        <h3> {{ session('title') }} </h3>
                    </div>

                </div>

                <div class="search d-flex justify-content-end align-items-center w-50 pe-4">

                <div class="d-flex justify-content-end align-items-center fs-2 gap-5">
    <i class="fa-solid fa-bell"></i>

    @if(Auth::check()) 
        @php
        

            $profilePhotoPath = Auth::user()->profile_photo;
            $defaultPhoto = asset('storage/profile_photos/default-profile.jpg');

            if (!empty($profilePhotoPath) && Storage::exists($profilePhotoPath)) {
                $profilePhoto = asset('storage/' . $profilePhotoPath);
            } else {
                $profilePhoto = $defaultPhoto;
            }
        @endphp

        <img src="{{ $profilePhoto }}" 
            alt="Profile Photo" 
            class="img-fluid rounded-circle" 
            width="50" 
            height="50">
            @endif
        </div>

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
                    <p>Last Login: {{ $previousLogin->login_date }} at {{ $previousLogin->login_time }}</p>
                @endif


            </div>

            <div style="background-color: #e9f1fa; height: 100vh">
                @yield('content')
            </div>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('components/script.js') }}"></script>

</body>

</html>