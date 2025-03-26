@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white border-0">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-0">
                        <i class="fas fa-info-circle text-danger me-2"></i>
                        Are you sure you want to delete this Department?
                    </p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
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

    <div class="row g-0">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-0">
                @session('success')
                <div class="alert alert-success alert-dismissible fade show m-3 border-0 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{$value}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endsession

                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show m-3 border-0 shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="card-header bg-white py-4 border-bottom">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-building text-primary me-3 fs-2"></i>
                            <h4 class="mb-0 text-primary fs-4">{{ __('Departments') }}</h4>
                        </div>
                        <div class="d-flex gap-2 w-100 w-md-auto">
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search departments...">
                            </div>
                            <button id="resetSearch" class="btn btn-light shadow-sm">
                                <i class="fas fa-undo"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    @can('department-create')
                    <div class="mb-4">
                        <a href="{{ route('departments.create') }}" class="btn btn-primary shadow-sm">
                            <i class="fas fa-plus-circle me-2"></i>Create New Department
                        </a>
                    </div>
                    @endcan

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4">
                                        <i class="fas fa-building me-2"></i>Department Name
                                    </th>
                                    <th class="py-3 px-4 text-end">
                                        <i class="fas fa-cogs me-2"></i>Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="DepartmentTable">
                                @foreach ($departments as $department)
                                <tr>
                                    <td class="py-3 px-4">
                                        <i class="fas fa-folder text-primary me-2"></i>
                                        {{ $department->name }}
                                    </td>
                                    <td class="py-3 px-4 text-end">
                                        @can('department-edit')
                                        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-sm btn-outline-primary shadow-sm">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        @endcan
                                        @can('department-delete')
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn shadow-sm" 
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-url="{{ route('departments.destroy', $department->id) }}">
                                            <i class="fas fa-trash-alt me-1"></i>Delete
                                        </button>
                                        @endcan
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

<style>
    /* Base styles */
    body {
        background-color: #f8f9fa;
    }
    
    .table > :not(caption) > * > * {
        padding: 1rem 1.5rem;
    }
    
    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }
    
    .btn-sm:hover {
        transform: translateY(-1px);
    }
    
    .input-group-text {
        border-right: none;
        padding: 0.75rem 1rem;
    }
    
    .form-control {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        border-left: none;
    }
    
    .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }
    
    .card {
        border: none;
        border-radius: 0;
        min-height: calc(100vh - 56px);
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,.08);
        border-radius: 0 !important;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,.02);
        transition: all 0.2s ease;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Responsive styles */
    @media (max-width: 576px) {
        .card-body {
            padding: 1rem !important;
        }
        
        .table > :not(caption) > * > * {
            padding: 0.75rem 1rem;
        }
        
        .btn-sm {
            padding: 0.375rem 0.75rem;
        }
    }

    /* Animation for table rows */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    #DepartmentTable tr {
        animation: fadeIn 0.3s ease-out forwards;
    }

    /* Modal styles */
    .modal-content {
        border-radius: 12px;
        overflow: hidden;
    }

    .modal-header {
        padding: 1.25rem 1.5rem;
    }

    .modal-footer {
        padding: 1.25rem 1.5rem;
    }

    /* Alert styles */
    .alert {
        border-radius: 8px;
    }

    /* Button hover effects */
    .btn {
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .btn:active {
        transform: translateY(0);
    }
</style>

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
