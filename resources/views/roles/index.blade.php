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
                Are you sure you want to delete this role?
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

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                @session('success')
                <div class="alert alert-success">
                    {{$value}}
                </div>
                @endsession
                <div class="card-header d-flex justify-content-between align-items-center ">
                    <span>{{ __('Roles') }}</span>
                    <input type="text" id="searchInput" class="form-control w-25" placeholder="Search">
                    <button id="resetSearch" class="btn btn-secondary ms-2">Reset</button>
                </div>
                <div class="card-body">
                    @can ('role-create')
                    <a href="{{route('roles.create')}}" class="btn btn-success mb-3">Create Role</a>
                    @endcan
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>                      
                        <tbody id="rolesTable">
                            @foreach($roles as $role)
                            <tr>
                                <td>{{$role->id}}</td>
                                <td>{{$role->name}}</td>
                                <td>
                                    @foreach($role->permissions as $permission)
                                        <span class="badge bg-primary">{{ $permission->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <form action="{{route('roles.destroy',$role->id)}}" method="POST" class="d-flex flex-wrap gap-2 justify-content-center">
                                        @csrf
                                        @method ('DELETE')
                                        @can ('role-list')
                                        <a href="{{route('roles.show',$role->id)}}" class="btn btn-sm btn-info">Details</a>
                                        @endcan
                                        @can ('role-edit')
                                        <a href="{{route('roles.edit',$role->id)}}" class="btn btn-sm btn-warning">Edit</a>
                                        @endcan
                                        @can ('role-delete')
                                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{$role->id}}" data-url="{{ route('roles.destroy', $role->id) }}" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
                                        @endcan
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <label> 
                                <select id="entriesSelect" class="form-select d-inline w-auto">
                                    <option value="5">5</option>
                                    <option value="10" selected>10</option>
                                </select>
                            </label>
                        </div>

                        <nav>
                            <ul class="pagination mb-0"></ul>
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
