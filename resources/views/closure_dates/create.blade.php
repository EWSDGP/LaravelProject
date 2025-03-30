@extends('layouts.app')

@section('content')
<div class="container-fluid min-vh-100 py-4 bg-light">
    <div class="row justify-content-center">
        <div class="col-xxl-8 col-xl-9 col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white p-3 d-flex align-items-center">
                    <i class="bi bi-calendar-plus fs-4 me-2"></i>
                    <h4 class="mb-0">{{ __('Create Closure Date') }}</h4>
                </div>
                
                <div class="card-body p-4">   
                    <form action="{{ route('closure_dates.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="date" id="Idea_ClosureDate" name="Idea_ClosureDate" class="form-control form-control-lg" required>
                                    <label for="Idea_ClosureDate">
                                        <i class="bi bi-lightbulb me-2"></i>Idea Closure Date
                                    </label>
                                    <div id="ideaDateWarning" class="text-danger mt-2 small" style="display: none;">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i>Invalid selection: The closure date cannot be in the past!
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="date" id="Comment_ClosureDate" name="Comment_ClosureDate" class="form-control form-control-lg" required>
                                    <label for="Comment_ClosureDate">
                                        <i class="bi bi-chat me-2"></i>Comment Closure Date
                                    </label>
                                    <div id="commentDateWarning" class="text-danger mt-2 small" style="display: none;">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i>Invalid selection: The closure date cannot be in the past!
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-4">
                                <div class="form-floating">
                                    <input type="text" name="Academic_Year" class="form-control form-control-lg" required>
                                    <label for="Academic_Year">
                                        <i class="bi bi-mortarboard me-2"></i>Academic Year
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{route('closure_dates.index')}}" class="btn btn-outline-dark btn-lg px-4">
                                <i class="bi bi-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-success btn-lg px-4">
                                <i class="bi bi-check-lg me-2"></i>Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let ideaDateInput = document.getElementById("Idea_ClosureDate");
        let commentDateInput = document.getElementById("Comment_ClosureDate");
        let ideaWarning = document.getElementById("ideaDateWarning");
        let commentWarning = document.getElementById("commentDateWarning");

        function checkDate(input, warningDiv) {
            let selectedDate = new Date(input.value);
            let today = new Date();
            today.setHours(0, 0, 0, 0);

            if (selectedDate < today) {
                warningDiv.style.display = "block";
            } else {
                warningDiv.style.display = "none";
            }
        }

        ideaDateInput.addEventListener("change", function () {
            checkDate(ideaDateInput, ideaWarning);
        });

        commentDateInput.addEventListener("change", function () {
            checkDate(commentDateInput, commentWarning);
        });
    });
</script>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endpush
@endsection
