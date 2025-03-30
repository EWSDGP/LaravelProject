@extends('layouts.app')
 
@section('content')
<!-- Add Font Awesome CDN in the head section -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
 
<div class="container-fluid px-4">
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="mb-0">Are you sure you want to delete this Closure Date?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
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
 
    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
 
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <h5 class="mb-0">
                                <i class="fas fa-calendar-alt me-2"></i>Closure Dates
                            </h5>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex justify-content-md-end">
                                <div class="input-group w-auto">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" id="searchInput" class="form-control" placeholder="Search academic year...">
                                    <button id="resetSearch" class="btn btn-outline-secondary">
                                        <i class="fas fa-undo-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
 
                <div class="card-body">
                    @can ('closure_date-create')
                    <div class="mb-4">
                        <a href="{{ route('closure_dates.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Create New Closure Date
                        </a>
                    </div>
                    @endcan
                   
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="fas fa-graduation-cap me-2"></i>Academic Year</th>
                                    <th><i class="fas fa-lightbulb me-2"></i>Idea Closure Date</th>
                                    <th><i class="fas fa-comments me-2"></i>Comment Closure Date</th>
                                    <th><i class="fas fa-cogs me-2"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="DateTable">
                                @foreach($closureDates as $closureDate)
                                    <tr>
                                        <td>{{ $closureDate->Academic_Year }}</td>
                                        <td>{{ $closureDate->Idea_ClosureDate }}</td>
                                        <td>{{ $closureDate->Comment_ClosureDate }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                @can ('closure_date-edit')
                                                <a href="{{ route('closure_dates.edit', $closureDate->ClosureDate_id) }}"
                                                   class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </a>
                                                @endcan
                                               
                                                @can ('closure_date-delete')
                                                <button type="button"
                                                        class="btn btn-danger btn-sm delete-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal"
                                                        data-url="{{ route('closure_dates.destroy', $closureDate->ClosureDate_id) }}">
                                                    <i class="fas fa-trash-alt me-1"></i>Delete
                                                </button>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
 
<style>
.container-fluid {
    padding-top: 2rem;
    padding-bottom: 2rem;
}
 
.card {
    border: none;
    border-radius: 0.5rem;
}
 
.table th {
    border-top: none;
    font-weight: 600;
}
 
.btn-group .btn {
    margin: 0 2px;
}
 
.alert {
    border-radius: 0.5rem;
}
 
@media (max-width: 768px) {
    .card-header .row {
        flex-direction: column;
    }
   
    .card-header .col-md-8 {
        margin-top: 1rem;
    }
   
    .input-group {
        width: 100% !important;
    }
   
    .table-responsive {
        font-size: 0.9rem;
    }
   
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
}
</style>
@endsection