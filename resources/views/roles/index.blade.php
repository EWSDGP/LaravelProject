@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="alert alert-danger m-0 rounded-top">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                </div>
                <div class="modal-body py-4">
                    <p class="mb-0">Are you sure you want to delete this role?</p>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-2"></i>Cancel
                    </button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Roles</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm">
                @session('success')
                <div class="alert alert-success alert-dismissible fade show m-3">
                    <i class="bi bi-check-circle-fill me-2"></i>{{$value}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endsession
                
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h5 class="mb-0">
                        <i class="bi bi-shield-lock me-2"></i>{{ __('Roles Management') }}
                    </h5>
                    <div class="d-flex gap-2 align-items-center">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Search roles...">
                        </div>
                        <button id="resetSearch" class="btn btn-light">
                            <i class="bi bi-x-circle me-2"></i>Reset
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    @can ('role-create')
                    <div class="mb-4">
                        <a href="{{route('roles.create')}}" class="btn btn-success">
                            <i class="bi bi-plus-lg me-2"></i>Create Role
                        </a>
                    </div>
                    @endcan

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Permissions</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>                      
                            <tbody id="rolesTable">
                                @foreach($roles as $role)
                                <tr>
                                    <td>{{$role->id}}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-badge me-2"></i>
                                            {{$role->name}}
                                        </div>
                                    </td>
                                    <td>
                                        @foreach($role->permissions as $permission)
                                            <span class="badge bg-primary rounded-pill">
                                                <i class="bi bi-key-fill me-1"></i>{{ $permission->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            @can ('role-list')
                                            <a href="{{route('roles.show',$role->id)}}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye me-1"></i>View
                                            </a>
                                            @endcan
                                            @can ('role-edit')
                                            <a href="{{route('roles.edit',$role->id)}}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil me-1"></i>Edit
                                            </a>
                                            @endcan
                                            @can ('role-delete')
                                            <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                                    data-id="{{$role->id}}" 
                                                    data-url="{{ route('roles.destroy', $role->id) }}" 
                                                    data-role="{{$role->name}}"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal">
                                                <i class="bi bi-trash me-1"></i>Delete
                                            </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
                        <div class="d-flex align-items-center">
                            <label class="me-2">Show entries:</label>
                            <select id="entriesSelect" class="form-select form-select-sm w-auto">
                                <option value="5">5</option>
                                <option value="10" selected>10</option>
                            </select>
                        </div>
                        <nav>
                            <ul class="pagination pagination-sm mb-0"></ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");
    const table = document.getElementById("rolesTable");
    const rows = table.getElementsByTagName("tr");

document.getElementById("resetSearch").addEventListener("click", function() {
    document.getElementById("searchInput").value = "";
    let rows = document.querySelectorAll("#rolesTable tr");
    rows.forEach(row => row.style.display = "");
});

    searchInput.addEventListener("keyup", function() {
        const filter = searchInput.value.toLowerCase();
        for (let i = 0; i < rows.length; i++) {
            let roleName = rows[i].getElementsByTagName("td")[1].textContent.toLowerCase();
            rows[i].style.display = roleName.includes(filter) ? "" : "none";
        }
    });

    const entriesSelect = document.getElementById("entriesSelect");
    let rowsPerPage = parseInt(entriesSelect.value);
    const pagination = document.querySelector(".pagination");

    function paginate() {
        let pageCount = Math.ceil(rows.length / rowsPerPage);
        pagination.innerHTML = "";
        for (let i = 0; i < pageCount; i++) {
            let li = document.createElement("li");
            li.className = "page-item";
            li.innerHTML = `<a class="page-link" href="#">${i + 1}</a>`;
            li.addEventListener("click", function() {
                showPage(i);
            });
            pagination.appendChild(li);
        }
        showPage(0);
    }

    function showPage(page) {
        for (let i = 0; i < rows.length; i++) {
            rows[i].style.display = (i >= page * rowsPerPage && i < (page + 1) * rowsPerPage) ? "" : "none";
        }
    }

    entriesSelect.addEventListener("change", function() {
        rowsPerPage = parseInt(this.value);
        paginate();
    });

    paginate();
});

document.addEventListener("DOMContentLoaded", function() {
    const deleteButtons = document.querySelectorAll(".delete-btn");
    const deleteForm = document.getElementById("deleteForm");

    deleteButtons.forEach(button => {
        button.addEventListener("click", function() {
            let deleteUrl = this.getAttribute("data-url");
            deleteForm.setAttribute("action", deleteUrl);
        });
    });
});
</script>

@endsection
