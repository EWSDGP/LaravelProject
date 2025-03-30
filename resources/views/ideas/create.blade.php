@extends('layouts.app')

@section('content')
<!-- {{ var_dump($closureDate) }} -->
<div class="container-fluid min-vh-100 bg-light py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <a href="{{ route('ideas.index') }}" class="btn btn-outline-primary mb-4">
                <i class="bi bi-arrow-left"></i> Back
            </a>

            <div class="card border-0 shadow-lg rounded-3">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-lightbulb display-4 text-warning"></i>
                        <h2 class="card-title fw-bold mt-3">Share Your Innovative Idea</h2>
                        <p class="text-muted">Your ideas can make a difference!</p>
                    </div>

                    <form action="{{ route('ideas.store') }}" method="POST" enctype="multipart/form-data" id="ideaForm">
                        @csrf

                        
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="user_name" value="{{ Auth::user()->name }}">
                        <input type="hidden" name="user_department" value="{{ Auth::user()->department_id }}">

                       
                        <div class="mb-4">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="bi bi-chat-square-text"></i>
                                </span>
                                <input type="text" name="title" id="title" 
                                    class="form-control form-control-lg border-start-0"
                                    placeholder="What's your brilliant idea?" required maxlength="100">
                            </div>
                            <small class="text-muted float-end"><span id="titleCounter">0</span>/100 characters</small>
                        </div>

                       
                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="bi bi-pencil-square"></i>
                                </span>
                                <textarea name="description" id="description" 
                                    class="form-control border-start-0" rows="6"
                                    placeholder="Describe your idea in detail..." required maxlength="2500"></textarea>
                            </div>
                            <small class="text-muted float-end"><span id="descCounter">0</span>/2500 characters</small>
                        </div>

                       
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="is_anonymous" id="is_anonymous" class="form-check-input">
                                    <label class="form-check-label" for="is_anonymous">
                                        <i class="bi bi-incognito"></i> Submit Anonymously
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <select name="category_id" id="category_id" class="form-select form-select-lg" required>
                                    <option value="" disabled selected>
                                        <i class="bi bi-tag"></i> Select Category
                                    </option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                       
                        <div class="mb-4">
                            <label for="documents" class="form-label">
                                <i class="bi bi-paperclip"></i> Attach Supporting Documents
                            </label>
                            <input type="file" name="documents[]" id="documents" 
                                class="form-control form-control-lg" multiple>
                            <div id="filePreview" class="mt-2"></div>
                        </div>

                       
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="terms" id="terms" class="form-check-input" required>
                                <label class="form-check-label" for="terms">
                                    <i class="bi bi-shield-check"></i> I agree to the 
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms & Conditions</a>
                                </label>
                            </div>
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

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-pill" 
                                id="submitButton" @if($currentDate->greaterThanOrEqualTo($closureDate)) disabled @endif>
                                <i class="bi bi-rocket-takeoff"></i> Launch Your Idea
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

<!-- Add Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endsection
