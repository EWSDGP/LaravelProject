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

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
            
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Category</span>
                <input type="text" id="searchInput" class="form-control w-25" placeholder="Search">
                <button id="resetSearch" class="btn btn-secondary ms-2">Reset</button>
            </div>

            <div class="card-body">
                @can('category-create')
                    <a href="{{ route('categories.create') }}" class="btn btn-success mb-3">Create New Category</a>
                @endcan

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoryTable">
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->category_name }}</td>
                                <td>
                                    @can('category-edit')
                                        <a href="{{ route('categories.edit', $category->category_id) }}" class="btn btn-warning">Edit</a>
                                    @endcan

                                    @can('category-delete')
                                        <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger delete-btn" 
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                    data-url="{{ route('categories.destroy', $category->category_id) }}">
                                                Delete
                                            </button>

                                        </form>
                                    @endcan
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
