

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
                Are you sure you want to delete this Department?
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
    @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
                                    {{$value}}
                        </div>
                        @endsession  
                        <div class="card-header d-flex justify-content-between align-items-center ">
                    <span>{{ __('Departments') }}</span>
                    <input type="text" id="searchInput" class="form-control w-25" placeholder="Search">
                    <button id="resetSearch" class="btn btn-secondary ms-2">Reset</button>
                </div>
                <div class="card-body">
@can ('department-create')         
    <a href="{{ route('departments.create') }}" class="btn btn-success">Create New Department</a>
@endcan  
<table class="table table-bordered mt-4">
    <thead>
        <tr>
            <th>Department Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="DepartmentTable">
        @foreach ($departments as $department)
        <tr>
            <td>{{ $department->name }}</td>
            <td>
                @can ('department-edit')
                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-warning">Edit</a>
              @endcan
              <!-- @can ('department-delete')
                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this category?');">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger delete-btn" 
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-url="{{ route('departments.destroy', $department->id) }}">
                                Delete                 
                        </button>
                @endcan -->
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

<script>
   document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchInput");
        const resetButton = document.getElementById("resetSearch");
        const tableRows = document.querySelectorAll("#DepartmentTable tr");
        const deleteButtons = document.querySelectorAll(".delete-btn");
        const deleteForm = document.getElementById("deleteForm");

        
        searchInput.addEventListener("keyup", function () {
            let query = searchInput.value.toLowerCase();

            tableRows.forEach(row => {
                const departmentName = row.querySelector("td").textContent.toLowerCase();
                row.style.display = departmentName.includes(query) ? "" : "none";
            });
        });

        resetButton.addEventListener("click", function () {
            searchInput.value = "";
            tableRows.forEach(row => row.style.display = "");
        });

        deleteButtons.forEach(button => {
            button.addEventListener("click", function() {
                let deleteUrl = this.getAttribute("data-url");
                deleteForm.setAttribute("action", deleteUrl);
            });
        });
    });

</script>
@endsection
