@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-body text-center p-4">
                <div class="delete-icon mb-3">
                    <i class="fas fa-exclamation-circle text-danger" style="font-size: 3.5rem;"></i>
                </div>
                <h4 class="mt-3 fw-bold">Are you sure?</h4>
                <p class="text-muted mb-4">Do you really want to delete this category? This process cannot be undone.</p>
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="fas fa-trash-alt me-2"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="position-fixed top-0 start-50 translate-middle-x notification-container" style="z-index: 1070">
    <div id="notificationToast" class="toast align-items-center border-0 text-white" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center">
                <i class="fas me-2"></i>
                <span class="toast-message"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow border-0 rounded-4 mb-4">
            <div class="card-header border-0 bg-transparent pt-4 pb-3">
                <div class="row align-items-center gy-2">
                    <div class="col-lg-4 col-md-6">
                        <h4 class="mb-0 text-dark">
                            <i class="fas fa-layer-group me-2 text-primary"></i>Categories
                        </h4>
                    </div>
                    <div class="col-lg-8 col-md-6">
                        <div class="d-flex flex-wrap justify-content-md-end gap-2">
                            <div class="search-wrapper flex-grow-1 flex-md-grow-0">
                                <div class="input-group">
                                    <span class="input-group-text border-end-0 bg-transparent">
                                        <i class="fas fa-search text-primary"></i>
                                    </span>
                                    <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Search categories...">
                                    <button id="resetSearch" class="btn btn-light border" title="Reset">
                                        <i class="fas fa-undo-alt"></i>
                                    </button>
                                </div>
                            </div>
                            @can('category-create')
                                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>New Category
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body px-4 pb-4">
                <div class="table-responsive rounded-3 border">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Category Name</th>
                                <th class="text-end pe-4" width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="categoryTable">
                            @foreach ($categories as $category)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="category-icon me-3">
                                                <i class="fas fa-folder text-warning"></i>
                                            </div>
                                            <span>{{ $category->category_name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            @can('category-edit')
                                                <a href="{{ route('categories.edit', $category->category_id) }}" 
                                                   class="btn btn-sm btn-outline-primary action-btn">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </a>
                                            @endcan
                                            @can('category-delete')
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger action-btn delete-btn"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal"
                                                        data-url="{{ route('categories.destroy', $category->category_id) }}">
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

                <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 gap-3">
                    <div class="entries-wrapper">
                        <select id="entriesSelect" class="form-select form-select-sm">
                            <option value="5">5 entries</option>
                            <option value="10" selected>10 entries</option>
                            <option value="25">25 entries</option>
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

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
    body {
        background-color: #f8f9fa;
    }
    
    .card {
        background-color: #87CEEB !important; /* Sky blue color for card */
        transition: all 0.3s ease;
        box-shadow: 0 8px 32px rgba(0, 31, 63, 0.1);
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 31, 63, 0.15);
    }
    
    .card-header {
        background-color: #87CEEB !important; /* Match card background */
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    /* Update text colors for better contrast on sky blue background */
    .card-header h4 {
        color: #2c3e50;
    }
    
    .search-wrapper {
        min-width: 250px;
        max-width: 400px;
    }
    
    .input-group {
        border-radius: 0.5rem;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.9);
    }
    
    .input-group-text, .form-control {
        border-color: rgba(255, 255, 255, 0.2);
        background: transparent;
    }
    
    .form-control:focus {
        box-shadow: none;
        border-color: #4aa9e9;
        background: rgba(255, 255, 255, 0.95);
    }
    
    .table {
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 0.5rem;
        margin-bottom: 0;
    }
    
    .table thead {
        background-color: rgba(255, 255, 255, 0.1);
    }
    
    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem;
        color: #2c3e50;
    }
    
    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid rgba(135, 206, 235, 0.2);
    }
    
    .category-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background-color: rgba(255, 193, 7, 0.15);
        transition: all 0.3s ease;
    }
    
    tr:hover .category-icon {
        transform: scale(1.1);
        background-color: rgba(255, 193, 7, 0.25);
    }
    
    .btn-primary {
        background: linear-gradient(45deg, #4aa9e9, #87CEEB);
        border: none;
        box-shadow: 0 4px 15px rgba(74, 169, 233, 0.2);
    }
    
    .btn-primary:hover {
        background: linear-gradient(45deg, #3998d8, #76bde0);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(74, 169, 233, 0.25);
    }
    
    .btn-group .btn {
        border-radius: 0.375rem;
        margin: 0 0.125rem;
        backdrop-filter: blur(5px);
    }
    
    .pagination .page-link {
        border-radius: 0.375rem;
        margin: 0 0.125rem;
        padding: 0.375rem 0.75rem;
        background: rgba(255, 255, 255, 0.9);
        border-color: rgba(135, 206, 235, 0.2);
        color: #2c3e50;
    }
    
    .pagination .page-link:hover {
        background: rgba(135, 206, 235, 0.1);
        border-color: rgba(135, 206, 235, 0.3);
    }
    
    .pagination .active .page-link {
        background: linear-gradient(45deg, #4aa9e9, #87CEEB);
        border-color: transparent;
    }
    
    .entries-wrapper {
        min-width: 120px;
    }
    
    .form-select {
        background-color: rgba(255, 255, 255, 0.9);
        border-color: rgba(135, 206, 235, 0.2);
    }
    
    /* Responsive adjustments */
    @media (max-width: 991.98px) {
        .card-header {
            padding: 1.5rem 1rem;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .search-wrapper {
            width: 100%;
            max-width: none;
        }
    }
    
    @media (max-width: 767.98px) {
        .container-fluid {
            padding: 1rem !important;
        }
        
        .table thead th,
        .table tbody td {
            padding: 0.75rem;
        }
        
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
        }
    }
    
    /* Toast notification styles */
    .notification-container {
        padding: 1rem;
        z-index: 1070;
    }
    
    .toast {
        background: linear-gradient(45deg, #4aa9e9, #87CEEB);
        border: none;
        border-radius: 1rem;
        box-shadow: 0 8px 32px rgba(0, 31, 63, 0.15);
        min-width: 300px;
    }
    
    .toast.bg-success {
        background: linear-gradient(45deg, #28a745, #5cc990) !important;
    }
    
    .toast.bg-danger {
        background: linear-gradient(45deg, #dc3545, #ff6b6b) !important;
    }
    
    .toast-body {
        padding: 1rem 1.25rem;
        font-weight: 500;
    }
    
    /* Modal styles */
    .modal-content {
        background: rgba(255, 255, 255, 0.98);
        border: none;
        border-radius: 1rem;
        box-shadow: 0 10px 40px rgba(0, 31, 63, 0.2);
        backdrop-filter: blur(10px);
    }
    
    .modal-body {
        padding: 2rem;
    }

    /* Modern Button Styles */
    .action-btn {
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border-width: 2px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 80px;
    }

    .action-btn:hover {
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

    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .delete-icon {
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    /* Toast Notification Styles */
    .toast {
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        background: linear-gradient(45deg, #4aa9e9, #87CEEB);
    }

    .toast.bg-success {
        background: linear-gradient(45deg, #28a745, #5cc990);
    }

    .toast.bg-danger {
        background: linear-gradient(45deg, #dc3545, #ff6b6b);
    }

    /* Responsive Adjustments */
    @media (max-width: 576px) {
        .action-btn {
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
            min-width: 70px;
        }

        .modal-dialog {
            margin: 1rem;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
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

    // Add toast notification function
    function showNotification(message, type) {
        const toast = document.getElementById('notificationToast');
        const toastBody = toast.querySelector('.toast-body');
        const icon = toastBody.querySelector('i');
        const messageSpan = toastBody.querySelector('.toast-message');

        // Set toast classes and icon based on type
        if (type === 'success') {
            toast.classList.remove('bg-danger');
            toast.classList.add('bg-success');
            icon.classList.remove('fa-exclamation-circle');
            icon.classList.add('fa-check-circle');
        } else {
            toast.classList.remove('bg-success');
            toast.classList.add('bg-danger');
            icon.classList.remove('fa-check-circle');
            icon.classList.add('fa-exclamation-circle');
        }

        messageSpan.textContent = message;
        
        const bsToast = new bootstrap.Toast(toast, {
            autohide: true,
            delay: 3000
        });
        bsToast.show();
    }

    // Check for flash messages on page load
    @if(session('success'))
        showNotification("{{ session('success') }}", 'success');
    @endif

    @if(session('error'))
        showNotification("{{ session('error') }}", 'error');
    @endif
});


</script>

@endsection
