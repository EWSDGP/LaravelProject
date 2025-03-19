@extends('layouts.app')

@section('content')
   
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-success text-white">{{ __('Create Closure Date') }}</div>
                <div class="card-body">   
                <form action="{{ route('closure_dates.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="Idea_ClosureDate" class="form-label">Idea Closure Date:</label>
            <input type="date" id="Idea_ClosureDate" name="Idea_ClosureDate" class="form-control" required>
            <div id="ideaDateWarning" class="text-danger mt-2" style="display: none;">Invalid selection: The closure date cannot be in the past!</div>
        </div>

        <div class="mb-3">
            <label for="Comment_ClosureDate" class="form-label">Comment Closure Date:</label>
            <input type="date" id="Comment_ClosureDate" name="Comment_ClosureDate" class="form-control" required>
            <div id="commentDateWarning" class="text-danger mt-2" style="display: none;">Invalid selection: The closure date cannot be in the past!</div>
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


            <div class="mb-3">
                <label for="Academic_Year" class="form-label">Academic Year:</label>
                <input type="text" name="Academic_Year" class="form-control" required>
            </div>

        <div class="mt-2 d-flex justify-content-between">
           <a href="{{route('closure_dates.index')}}" class="btn btn-outline-dark">Back</a>
           <button type="submit" class="btn btn-success">Create</button>
        </div>
        
    </form>
</div>
@endsection
