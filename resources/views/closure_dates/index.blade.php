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
                Are you sure you want to delete this Closure Date?
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
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card-header d-flex justify-content-between align-items-center">
                <span>Closure Date</span>
                <input type="text" id="searchInput" class="form-control w-25" placeholder="Search">
                <button id="resetSearch" class="btn btn-secondary ms-2">Reset</button>
            </div>
            <div class="card-body">
        @can ('closure_date-create')
        <a href="{{ route('closure_dates.create') }}" class="btn btn-success mb-3">Create New Closure Date</a>
        @endcan
      
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Academic Year</th>
                    <th>Idea Closure Date</th>
                    <th>Comment Closure Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id=DateTable>
                @foreach($closureDates as $closureDate)
                    <tr>
                        <td>{{ $closureDate->Academic_Year }}</td>
                        <td>{{ $closureDate->Idea_ClosureDate }}</td>
                        <td>{{ $closureDate->Comment_ClosureDate }}</td>
                        <td>
                            @can ('closure_date-edit')
                            <a href="{{ route('closure_dates.edit', $closureDate->ClosureDate_id) }}" class="btn btn-warning">Edit</a>
                            @endcan
                           
                            <form action="{{ route('closure_dates.destroy', $closureDate->ClosureDate_id) }}" method="POST" style="display:inline;"  onsubmit="return confirm('Are you sure you want to delete this category?');">
                                @csrf
                                @method('DELETE')
                                @can ('closure_date-delete')
                                <button type="button" class="btn btn-danger delete-btn" 
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                    data-url="{{ route('closure_dates.destroy', $closureDate->ClosureDate_id) }}">
                                                Delete
                                            </button>
                                @endcan
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");
    const resetButton = document.getElementById("resetSearch");
    const tableRows = document.querySelectorAll("#DateTable tr");
    const deleteButtons = document.querySelectorAll(".delete-btn");
    const deleteForm = document.getElementById("deleteForm");

    searchInput.addEventListener("keyup", function() {
        let searchText = searchInput.value.toLowerCase();
        tableRows.forEach(row => {
            let categoryName = row.cells[0].textContent.toLowerCase();
            row.style.display = categoryName.includes(searchText) ? "" : "none";
        });
    });

    resetButton.addEventListener("click", function() {
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
