@extends('layouts.app')

@section('content')

<div class="container">
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle text-danger me-3 fs-4"></i>
                        <p class="mb-0">Are you sure you want to delete this user? This action cannot be undone.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-2"></i>Delete
                        </button>
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
                                <button type="button" class="btn btn-sm btn-outline-primary user-details-btn"
                                    data-user='@json($user)'
                                    data-roles="{{ $user->getRoleNames()->implode(', ') }}">
                                    <i class="fas fa-info-circle me-1"></i>Details
                                </button>
                                @endcan
                                @can('user-edit')
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="btn btn-sm btn-outline-warning edit-btn"
                                    data-user-name="{{ $user->name }}">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                @endcan

                                @if (!in_array('Admin', $user->getRoleNames()->toArray()))
                                @can('user-delete')
                                <button type="button" class="btn btn-sm btn-outline-danger delete-btn"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-url="{{ route('users.destroy', $user->id) }}">
                                    <i class="fas fa-trash-alt me-1"></i>Delete
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

<style>
    .btn {
        transition: all 0.3s ease;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 500;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .btn-outline-primary {
        color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: white;
    }
    
    .btn-outline-warning {
        color: #ffc107;
        border-color: #ffc107;
    }
    
    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: black;
    }
    
    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }
    
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
    
    .modal-content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .modal-header {
        border-radius: 12px 12px 0 0;
    }
    
    @media (max-width: 576px) {
        .btn {
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
        }
        
        .modal-dialog {
            margin: 1rem auto;
        }
    }

    .swal2-popup {
        border-radius: 12px !important;
    }

    .swal2-title {
        font-size: 1.5rem !important;
    }

    .swal2-html-container {
        font-size: 1.1rem !important;
    }

    .swal2-confirm, .swal2-cancel {
        padding: 0.5rem 1.5rem !important;
        font-size: 1rem !important;
        border-radius: 8px !important;
        transition: all 0.3s ease !important;
    }

    .swal2-confirm:hover, .swal2-cancel:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
    }
</style>

<script>
    // Add Font Awesome if not already included
    if (!document.querySelector('link[href*="font-awesome"]')) {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css';
        document.head.appendChild(link);
    }

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

        let Defaultphoto = `{{ asset('storage/profile_photos/default-profile.jpg') }}`;

    let profilePhoto = user.profile_photo && user.profile_photo !== "0"
        ? `{{ asset('storage') }}/${user.profile_photo}`
        : Defaultphoto;

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

    // Handle edit button click with confirmation
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const userName = this.getAttribute('data-user-name');
            const editUrl = this.getAttribute('href');
            
            Swal.fire({
                title: 'Edit User',
                html: `Are you sure you want to edit <strong>${userName}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-edit me-2"></i>Yes, Edit',
                cancelButtonText: '<i class="fas fa-times me-2"></i>Cancel',
                customClass: {
                    confirmButton: 'btn btn-warning',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = editUrl;
                }
            });
        });
    });
</script>

<!-- Add SweetAlert2 CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection