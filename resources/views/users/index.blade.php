@extends('layouts.app')

@section('content')
    <div class="" style="background-color: #e9f1fa; height: 100vh">

        <div class="bg-white">

            <div class="bg-leaf text-white d-flex justify-content-center align-items-center p-4">
                <h3 class="m-0 fs-4">Staff Management System</h3>
            </div>
        
            <div class="bg-white" id="user-details">
                <!-- User details will be displayed here -->
            </div>

            <div>

                <div class="p-4">
                    <h4 class="pb-2">Staff List</h4>
                    @can('user-create')
                        <a href="{{ route('users.create') }}" class="btn btn-success">Create New Account</a>
                    @endcan
                </div>

                <table class="w-100 table-border text-center border px-3">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->getRoleNames() as $role)
                                        {{ $role }}
                                    @endforeach
                                </td>
                                <td>{{ $user->department ? $user->department->name : 'No Department Assigned' }}</td>
                                <td>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-flex flex-wrap gap-2 justify-content-center">
                                        @csrf
                                        @method('DELETE')
                                        @can('user-list')
                                            <button type="button" class="btn btn-sm btn-info user-details-btn"
                                                data-user='@json($user)'
                                                data-roles="{{ $user->getRoleNames()->implode(', ') }}">
                                                Details
                                            </button>
                                        @endcan
                                        @can('user-edit')
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                        @endcan
                                        @can('user-delete')
                                        <button class="btn btn-danger btn-sm delete-btn">Delete</button>
                                        <script>
                                            var userRole = "{{ Auth::user()->id }}"; 

                                            if (userRole === "1") {
                                                document.querySelector(".delete-btn").style.display = "none";
                                            }
                                        </script>
                                        @endcan
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.user-details-btn').forEach(button => {
            button.addEventListener('click', function() {
                let user = JSON.parse(this.getAttribute('data-user'));
                let roles = this.getAttribute('data-roles');
                showUserDetails(user, roles);
            });
        });

        function showUserDetails(user, roles) {
            const userDetailsDiv = document.getElementById('user-details');
            let previoususerid = showUserDetails.previoususerid || 0;

            if (user.id === previoususerid) {
                userDetailsDiv.innerHTML = '';
                showUserDetails.previoususerid = 0;
                return;
            }

            userDetailsDiv.innerHTML = `
                <div class="edit-show d-flex align-items-start p-5 bg-white border-bottom gap-5" style="height: 220px;">
                        <img src="https://cdn1.hammers.news/uploads/25/2023/08/GettyImages-1342442688-1024x693.jpg" class="h-100 rounded-circle" style="aspect-ratio: 1/1;">
                    <div class="position-relative d-flex justify-content-start align-items-center h-100">
                        <div class="d-flex flex-column justify-content-between align-items-start h-100 px-5">
                            <p class="m-0 fw-bold">Name :</p>
                            <p class="m-0 fw-bold">Email :</p>
                            <p class="m-0 fw-bold">Phone Number :</p>
                            <p class="m-0 fw-bold">Department :</p>
                            <p class="m-0 fw-bold">Position :</p>
                        </div>
                        <div class="d-flex flex-column justify-content-between h-100 pe-5">
                            <p class="m-0">${user.name}</p>
                            <p class="m-0">${user.email}</p>
                            <p class="m-0">${user.phone_number || 'N/A'}</p>
                            <p class="m-0">${user.department ? user.department.name : 'N/A'}</p>
                            <p class="m-0">${roles || 'N/A' }</p>
                        </div>
                    </div>
                </div>
            `;
            showUserDetails.previoususerid = user.id;
        }
    </script>
    </body>

    </html>
@endsection
