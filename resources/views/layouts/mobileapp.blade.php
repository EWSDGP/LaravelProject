<div class="mobile-navigation bg-nav text-white position-fixed" style="width: 100%; z-index: 1; overflow-y: auto; height: 100vh;">
    <div class="bg-nav-title d-flex justify-content-center align-items-center" style="height: 90px">
        <h3 class="m-0">
            Greenwich
        </h3>
    </div>
    <div class="navbar d-flex flex-column justify-content-center align-items-center fs-5">
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
            <li class="nav-items hover-div nav-item d-flex justify-content-center align-items-center w-100"
                style="height: 95px">
                <i class="fa-solid fa-home pe-4"></i>
                <a class="text-decoration-none" href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            @canany(['category-create', 'category-list', 'category-edit', 'category-delete'])
                <li class="nav-items hover-div nav-item d-flex justify-content-center align-items-center w-100"
                    style="height: 95px">
                    <i class="fa-solid fa-calendar-days pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('categories.index') }}">Categories</a>
                </li>
            @endcanany
            @canany(['department-create', 'department-list', 'department-edit', 'department-delete'])
                <li class="hover-div nav-item d-flex justify-content-center align-items-center w-100" style="height: 95px">
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
            @canany(['closure_date-create', 'closure_date-list', 'closure_date-edit', 'closure_date-delete'])
                <li class="hover-div nav-item d-flex justify-content-center align-items-center w-100" style="height: 95px">
                    <i class="fa-solid fa-user-tie pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('closure_dates.index') }}">Manage Closure_Dates</a>
                </li>
            @endcanany
            @role('Admin')
                <li class="nav-items hover-div d-flex justify-content-center align-items-center w-100" style="height: 95px">
                    <i class="fa-solid fa-calendar-days pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('roles.index') }}">Roles Management</a>
                </li>
            @endrole
            @canany(['user-list', 'user-create', 'user-edit', 'user-delete'])
                <li class="nav-items hover-div nav-item d-flex justify-content-center align-items-center w-100"
                    style="height: 95px">
                    <i class="fa-solid fa-user-tie pe-4"></i>
                    <a class="text-decoration-none" href="{{ route('users.index') }}">Account Management</a>
                </li>
            @endcanany

            <div class="hover-div d-flex justify-content-center align-items-center w-100" style="height: 95px;">
                <i class="fa-solid fa-gear pe-4"></i>
                <a class="text-decoration-none" href="#">Setting</a>
            </div>

            <div class="hover-div d-flex justify-content-center align-items-center w-100" style="height: 95px;">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-flex justify-content-center">

                    @csrf
                    <i class="fa-solid fa-arrow-right-from-bracket pe-4"></i>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                </form>
            </div>

            <div class="hover-div d-flex justify-content-center align-items-center w-100" style="height: 95px;" onclick="closeNavigation()">
                <i class="fa-solid fa-xmark pe-4"></i>
                <a class="text-decoration-none" href="#">Close</a>
            </div>

        @endguest
    </div>
</div>
