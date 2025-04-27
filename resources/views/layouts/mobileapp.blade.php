<div class="mobile-navigation bg-nav text-white position-fixed"
    style="width: 100%; z-index: 1; overflow-y: auto; height: 100vh;">
    <div class="bg-nav-title d-flex justify-content-center align-items-center" style="height: 90px">
        <h3 class="m-0">
            Bright Path
        </h3>
    </div>
    <div class="navbar d-flex flex-column justify-content-center align-items-center fs-5">
        <!-- Authentication Links -->
        @guest

            @if (Route::has('login'))
                <li class="nav-items hover-div nav-item d-flex justify-content-start align-items-center w-100"
                    style="height: 6rem">
                    <i class="fa-solid fa-arrow-right-to-bracket pe-4"></i>
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif

            @if (Route::has('register'))
                <li class="nav-items hover-div nav-item d-flex justify-content-start align-items-center w-100"
                    style="height: 6rem">
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

                <div class="d-flex flex-column mt-auto w-100">
                    <div class="d-flex flex-column mt-auto w-100">
                        <div class="nav-items hover-div d-flex justify-content-start align-items-center w-100 ps-4 {{ request()->is('settings') ? 'hover_active' : '' }}"
                            style="height: 7rem">
                            <i class="fa-solid fa-gear pe-3"></i>
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

                <div class="hover-div d-flex justify-content-center align-items-center w-100" style="height: 6rem"
                onclick="closeNavigation()">
                <i class="fa-solid fa-xmark pe-4"></i>
                <a class="text-decoration-none" href="#">Close</a>
                </div>
                    @endguest
    </div>
</div>
