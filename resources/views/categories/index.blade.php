@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
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
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchInput");
        const resetButton = document.getElementById("resetSearch");
        const tableRows = document.querySelectorAll("#categoryTable tr");

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
    });
</script>

@endsection
