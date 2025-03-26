@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="alert alert-danger">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this Category?
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

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show m-3">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h5 class="mb-0"><i class="fas fa-folder me-2"></i>Categories</h5>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-md-end">
                            <div class="input-group w-auto">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search categories...">
                            </div>
                            <button id="resetSearch" class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-undo-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @can('category-create')
                    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus-circle me-2"></i>Create New Category
                    </a>
                @endcan

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Category Name</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="categoryTable">
                            @foreach ($categories as $category)
                                <tr>
                                    <td>
                                        <i class="fas fa-folder-open text-warning me-2"></i>
                                        {{ $category->category_name }}
                                    </td>
                                    <td class="text-end">
                                        @can('category-edit')
                                            <a href="{{ route('categories.edit', $category->category_id) }}" 
                                               class="btn btn-sm btn-outline-primary me-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('category-delete')
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger delete-btn"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal"
                                                    data-url="{{ route('categories.destroy', $category->category_id) }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="d-flex align-items-center">
                        <label class="me-2">Show</label>
                        <select id="entriesSelect" class="form-select form-select-sm w-auto">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                        </select>
                        <label class="ms-2">entries</label>
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

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
    body {
        background-color: #f8f9fa;
    }
    
    .card {
        background-color: #87CEEB; /* Sky blue color for container */
        transition: box-shadow 0.3s ease-in-out;
        box-shadow: 0 0.25rem 1rem rgba(0, 0, 0, 0.1);
    }
    
    .card:hover {
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.2) !important;
    }
    
    /* Make card header match the container */
    .card-header {
        background-color: #87CEEB !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    /* Make table background slightly transparent for better contrast */
    .table {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 0.5rem;
    }
    
    /* Adjust text color for better readability */
    .card-header h5 {
        color: #2c3e50;
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
    }
    
    .btn {
        border-radius: 0.5rem;
        padding: 0.375rem 0.75rem;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
    
    .pagination .page-link {
        border-radius: 0.25rem;
        margin: 0 0.125rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .alert {
        border-radius: 0.5rem;
    }
    
    @media (max-width: 768px) {
        .d-flex {
            flex-wrap: wrap;
        }
        
        .input-group {
            margin-bottom: 1rem;
        }
        
        .btn {
            margin-bottom: 0.5rem;
        }
    }
</style>

<script>
   document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");
    const resetButton = document.getElementById("resetSearch");
    const tableRows = document.querySelectorAll("#categoryTable tr");
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

    // Pagination
    const entriesSelect = document.getElementById("entriesSelect");
    const pagination = document.querySelector(".pagination");
    let rowsPerPage = parseInt(entriesSelect.value);
    const rows = document.querySelectorAll("#categoryTable tr");

    function paginate() {
        let pageCount = Math.ceil(rows.length / rowsPerPage);
        pagination.innerHTML = "";
        for (let i = 0; i < pageCount; i++) {
            let li = document.createElement("li");
            li.className = "page-item";
            li.innerHTML = `<a class="page-link" href="#">${i + 1}</a>`;
            li.addEventListener("click", function(event) {
                event.preventDefault();
                document.querySelectorAll(".pagination .page-item").forEach(item => item.classList.remove("active"));
                this.classList.add("active");
                showPage(i);
            });
            pagination.appendChild(li);
        }
        if (pagination.firstChild) {
            pagination.firstChild.classList.add("active");
        }
        showPage(0);
    }

    function showPage(page) {
        rows.forEach((row, index) => {
            row.style.display = (index >= page * rowsPerPage && index < (page + 1) * rowsPerPage) ? "" : "none";
        });
    }

    entriesSelect.addEventListener("change", function() {
        rowsPerPage = parseInt(this.value);
        paginate();
    });

    paginate();
});


</script>

@endsection
