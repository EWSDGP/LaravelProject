@extends('layouts.app')

@section('content')

<div class="container">
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="alert alert-danger">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this User?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="background-color: #e9f1fa; height: 100vh">
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

                                <!-- Only show the delete button if the user doesn't have the "Admin" role -->
                                @if (!in_array('Admin', $user->getRoleNames()->toArray()))
                                @can('user-delete')
                                <button type="button" class="btn btn-danger delete-btn"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-url="{{ route('users.destroy', $user->id) }}">
                                    Delete
                                </button>
                                @endcan
                                @endif
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
    // Handle modal delete URL dynamically
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener("click", function() {
            let deleteUrl = this.getAttribute("data-url");
            const deleteForm = document.getElementById("deleteForm");
            deleteForm.setAttribute("action", deleteUrl);
        });
    });

    // Handle user details view
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

        let profilePhoto = user.profile_photo ?
            (user.profile_photo.startsWith('http') ?
                user.profile_photo :
                `{{ asset('storage/') }}/${user.profile_photo}`) :
            'https://cdn1.hammers.news/uploads/25/2023/08/GettyImages-1342442688-1024x693.jpg';

        userDetailsDiv.innerHTML = `
        <div class="edit-show d-flex align-items-start p-5 bg-white border-bottom gap-5" style="height: 220px;">
            <img src="${profilePhoto}" 
                 class="h-100 rounded-circle" style="aspect-ratio: 1/1;">
            <div class="position-relative d-flex justify-content-start align-items-center h-100">
                <div class="d-flex flex-column justify-content-between align-items-start h-100 px-5">
                    <p class="m-0 fw-bold">Name :</p>
                    <p class="m-0 fw-bold">Email :</p>
                    <p class="m-0 fw-bold">Department :</p>
                    <p class="m-0 fw-bold">Position :</p>
                </div>
                <div class="d-flex flex-column justify-content-between h-100 pe-5">
                    <p class="m-0">${user.name}</p>
                    <p class="m-0">${user.email}</p>
                    <p class="m-0">${user.department ? user.department.name : 'Not Assigned'}</p>
                    <p class="m-0">${roles || 'N/A'}</p>
                </div>
            </div>
        </div>
    `;
        showUserDetails.previoususerid = user.id;
    }
</script>

@endsection