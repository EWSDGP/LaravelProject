@extends('layouts.app')

@section('content')

    
    <!-- {{ var_dump($closureDate) }} -->

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{ route('ideas.index') }}" class="btn btn-outline-dark">Back</a>

                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <h5 class="card-title text-center fw-bold">💡 Share Your Idea</h5>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('ideas.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <input type="text" name="title" id="title" class="form-control form-control-lg" 
                                    placeholder="What's your idea?" required>
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="user_name" value="{{ Auth::user()->name }}">
                                <input type="hidden" name="user_department" value="{{ Auth::user()->department_id }}">
                            </div>

                            <div class="mb-3">
                                <textarea name="description" id="description" class="form-control" rows="3"
                                    placeholder="Describe your idea..." required></textarea>
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
                            </div>

                          
                            @php
                                $currentDate = now();
                                $closureDate = \Carbon\Carbon::parse($closureDate->Idea_ClosureDate);
                            @endphp

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-lg" 
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
@endsection
