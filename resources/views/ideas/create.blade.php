@extends('layouts.app')

@section('content')
<!-- {{ var_dump($closureDate) }} -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('ideas.index') }}" class="btn btn-outline-dark mb-3">← Back</a>

            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h5 class="card-title text-center fw-bold">💡 Share Your Idea</h5>

                    <form action="{{ route('ideas.store') }}" method="POST" enctype="multipart/form-data" id="ideaForm">
                        @csrf

                        
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="user_name" value="{{ Auth::user()->name }}">
                        <input type="hidden" name="user_department" value="{{ Auth::user()->department_id }}">

                       
                        <div class="mb-3">
                            <input type="text" name="title" id="title" class="form-control form-control-lg"
                                placeholder="What's your idea?" required maxlength="100">
                            <small class="text-muted"><span id="titleCounter">0</span>/100 characters</small>
                        </div>

                       
                        <div class="mb-3">
                            <textarea name="description" id="description" class="form-control" rows="5"
                                placeholder="Describe your idea..." required maxlength="2500"></textarea>
                            <small class="text-muted"><span id="descCounter">0</span>/2500 characters</small>
                        </div>

                       
                        <div class="mb-3">
                            <input type="checkbox" name="is_anonymous" id="is_anonymous">
                            <label for="is_anonymous">Submit Anonymously</label>
                        </div>

                        
                        <div class="mb-3">
                            <select name="category_id" id="category_id" class="form-select" required>
                                <option value="" disabled selected>Choose a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>

                       
                        <div class="mb-3">
                            <label for="documents" class="form-label fw-bold">📎 Attach Files (Optional)</label>
                            <input type="file" name="documents[]" id="documents" class="form-control" multiple>
                            <div id="filePreview" class="mt-2"></div>
                        </div>

                       
                        <div class="mb-3">
                            <input type="checkbox" name="terms" id="terms" required>
                            <label for="terms">
                                I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms & Conditions</a>
                            </label>
                        </div>

                        
                        <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="termsModalLabel">Terms & Conditions</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>By submitting an idea, you agree that...</p>
                                        <ul>
                                            <li>Your idea may be reviewed and shared within the organization.</li>
                                            <li>You are responsible for the content you submit.</li>
                                            <li>All submissions must follow the community guidelines.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @php
                            $currentDate = now();
                            $closureDate = \Carbon\Carbon::parse($closureDate->Idea_ClosureDate);
                        @endphp

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitButton"
                                @if($currentDate->greaterThanOrEqualTo($closureDate)) disabled @endif>
                                🚀 Post Idea
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const titleInput = document.getElementById("title");
        const descInput = document.getElementById("description");
        const fileInput = document.getElementById("documents");
        const termsCheckbox = document.getElementById("terms");
        const form = document.getElementById("ideaForm");
        const titleCounter = document.getElementById("titleCounter");
        const descCounter = document.getElementById("descCounter");
        const filePreview = document.getElementById("filePreview");

        
        titleInput.addEventListener("input", () => {
            titleCounter.textContent = titleInput.value.length;
        });

        descInput.addEventListener("input", () => {
            descCounter.textContent = descInput.value.length;
        });

       
        fileInput.addEventListener("change", function () {
            filePreview.innerHTML = "";
            for (let file of fileInput.files) {
                let fileSize = (file.size / 1024 / 1024).toFixed(2); 
                if (fileSize > 5) {
                    Swal.fire("File too large!", `The file "${file.name}" exceeds the 5MB limit.`, "error");
                    fileInput.value = ""; 
                    return;
                }
                filePreview.innerHTML += `<p class="text-muted">📄 ${file.name} (${fileSize} MB)</p>`;
            }
        });

       
        form.addEventListener("submit", function (event) {
            event.preventDefault();
            let errors = [];

            if (titleInput.value.trim().length === 0) {
                errors.push("Title is required.");
            } else if (titleInput.value.length > 100) {
                errors.push("Title must not exceed 100 characters.");
            }

            if (descInput.value.trim().length === 0) {
                errors.push("Description is required.");
            } else if (descInput.value.length > 2500) {
                errors.push("Description must not exceed 2,500 characters.");
            }

            if (!termsCheckbox.checked) {
                errors.push("You must accept the Terms & Conditions.");
            }

            if (errors.length > 0) {
                Swal.fire("Oops!", errors.join("<br>"), "error");
            } else {
                Swal.fire({
                    title: "Submit Idea?",
                    text: "Are you sure you want to submit this idea?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Submit!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });
    });
</script>
@endsection
