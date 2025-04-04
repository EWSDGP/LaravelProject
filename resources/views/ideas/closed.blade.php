@extends('layouts.app')

@section('content')
    <div class="container_back">

        <h2 class="py-4">Closed Ideas</h2>
        <div class="d-flex justify-content-end gap-2">
            @php

                $latestClosureDate = \App\Models\ClosureDate::latest()->first()->Idea_ClosureDate;
                $currentDate = now();
            @endphp

        </div>
        <form method="GET" action="{{ route('ideas.closed') }}" class="mb-4">
            <div class="row gap-1">
                <div class="filter-ideas col-md-4">
                    <select name="category_id" class="form-select">
                        <option value="">Filter by Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->category_id }}"
                                {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="filter-ideas col-md-4">
                    <select name="department_id" class="form-select">
                        <option value="">Filter by Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}"
                                {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-4 w-auto ms-auto">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('ideas.closed') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        <form method="GET" action="{{ route('ideas.closed') }}" class="mb-4">
            <select name="sort" id="sort" onchange="this.form.submit()" class="form-select w-100">
                <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Sorted by Latest</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Sorted by Most Popular
                </option>
                <option value="latest_comment" {{ request('sort') == 'latest_comment' ? 'selected' : '' }}>Sorted by Latest
                    Comment
                </option>
            </select>
        </form>



        <div class="row justify-content-start">
            <div class="col-lg-8 w-100 d-flex flex-wrap gap-4">
                @foreach ($ideas as $idea)
                    @php
                        $currentDate = now();
                        $closureDate = $idea->closureDate;
                        $ideaDisabled = $currentDate->greaterThanOrEqualTo($closureDate->Idea_ClosureDate);
                        $canComment = $currentDate->lessThanOrEqualTo($closureDate->Comment_ClosureDate);
                    @endphp
                    <div class="show-idea card shadow-sm rounded-3">
                        <div class="card-body d-flex flex-column gap-3 justify-content-start">
                            <div class="d-flex align-items-center mb-3">
                                @php
                                    $defaultPhoto = asset('storage/profile_photos/default-profile.jpg');

                                    if ($idea->is_anonymous) {
                                        $profilePhoto = $defaultPhoto;
                                    } else {
                                        $profilePhotoPath = $idea->user->profile_photo ?? null;

                                        if ($profilePhotoPath && Storage::exists($profilePhotoPath)) {
                                            $profilePhoto = asset('storage/' . $profilePhotoPath);
                                        } else {
                                            $profilePhoto = $defaultPhoto;
                                        }
                                    }
                                @endphp

                                <img src="{{ $profilePhoto }}" class="rounded-circle me-3" alt="User Avatar" width="50"
                                    height="50">
                                <div>
                                    <h6 class="mb-0">
                                        <strong>
                                            {{ $idea->is_anonymous ? 'Anonymous' : $idea->user->name }}
                                        </strong>
                                    </h6>
                                    <p class="text-muted small mb-0">{{ $idea->created_at->diffForHumans() }}</p>
                                </div>
                            </div>


                            <div>

                                <h5 class="fw-bold">{{ $idea->title }}</h5>
                                <p class="card-text">{{ nl2br(e(\Str::limit($idea->description, 3000))) }}</p>

                                @if ($idea->documents->isNotEmpty())
                                    <div>
                                        @foreach ($idea->documents as $document)
                                            @php
                                                $filePath = asset('storage/' . $document->file_path);
                                                $extension = pathinfo($document->file_path, PATHINFO_EXTENSION);
                                            @endphp
                                            @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']))
                                                <img src="{{ $filePath }}" alt="Document Image"
                                                    class="img-fluid rounded mb-2" style="width: 50%; aspect-ratio: 16/12;">
                                            @else
                                                <a href="{{ $filePath }}" class="btn btn-outline-primary btn-sm"
                                                    target="_blank">
                                                    <i class="bi bi-file-earmark-text"></i> View
                                                    {{ strtoupper($extension) }}
                                                    File
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif

                            </div>


                            @if ($ideaDisabled)
                                <!-- <p class="text-muted">Ideas Open Test</p> -->
                            @else
                                <!-- <p class="text-success">Ideas Close Test</p> -->
                            @endif

                            @if (!$canComment)
                                <!-- <p class="text-muted">Comments Close Test</p> -->
                            @else
                                <!-- <p class="text-success">Comment Open Test</p> -->
                            @endif


                            <div class="mt-auto">

                                <div class="d-flex justify-content-start">
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-outline-primary btn-sm me-2 vote-btn"
                                            data-idea="{{ $idea->idea_id }}" data-user="{{ Auth::id() }}"
                                            data-type="like" id="like-btn-{{ $idea->idea_id }}"
                                            {{ $ideaDisabled || $idea->votes->where('vote_type', 'like')->where('user_id', Auth::id())->isNotEmpty() ? 'disabled' : '' }}>
                                            <i class="fa-solid fa-thumbs-up"></i> Like
                                            <span
                                                class="like-count">{{ $idea->votes->where('vote_type', 'like')->count() }}</span>
                                        </button>

                                        <button class="btn btn-outline-danger btn-sm me-2 vote-btn"
                                            data-idea="{{ $idea->idea_id }}" data-user="{{ Auth::id() }}"
                                            data-type="dislike" id="dislike-btn-{{ $idea->idea_id }}"
                                            {{ $ideaDisabled || $idea->votes->where('vote_type', 'dislike')->where('user_id', Auth::id())->isNotEmpty() ? 'disabled' : '' }}>
                                            <i class="fa-solid fa-thumbs-down"></i> Dislike
                                            <span
                                                class="dislike-count">{{ $idea->votes->where('vote_type', 'dislike')->count() }}</span>
                                        </button>
                                    </div>

                                </div>

                                <div class="mt-3">
                                    <button class="btn btn-outline-secondary btn-sm" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#comments-{{ $idea->idea_id }}">
                                        <i class="fa-solid fa-comment"></i> Comments ({{ $idea->comments->count() }})
                                    </button>

                                    @can('comment-list')
                                        <div class="collapse mt-2" id="comments-{{ $idea->idea_id }}">
                                            @foreach ($idea->comments as $comment)
                                                <div class="border rounded p-2 mb-2 bg-light">
                                                    <strong>{{ $comment->is_anonymous ? 'Anonymous' : $comment->user->name }}</strong>
                                                    <p class="mb-1">{{ $comment->comment_text }}</p>
                                                    <small
                                                        class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                </div>
                                            @endforeach

                                            @can('comment-submit')
                                                @auth

                                                    @if ($canComment)
                                                        <form action="{{ route('comments.store', $idea->idea_id) }}" method="POST"
                                                            class="mt-2">
                                                            @csrf
                                                            <textarea class="form-control mb-2" name="comment_text" rows="2" placeholder="Write a comment..." required></textarea>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <input type="checkbox" name="is_anonymous"
                                                                        id="anonymous-{{ $idea->idea_id }}">
                                                                    <label for="anonymous-{{ $idea->idea_id }}">Post as
                                                                        Anonymous</label>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary btn-sm">Comment</button>
                                                            </div>
                                                        </form>
                                                    @else
                                                        <p class="text-muted">Comments Close</p>
                                                    @endif
                                                @endauth
                                            @endcan
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-center">
            {{ $ideas->appends(request()->query())->links('pagination::bootstrap-5') }}

        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const submitButton = document.getElementById('submit-button');
                const ideaClosureDate = submitButton.dataset.closureDate;

                if (ideaClosureDate) {
                    const currentDate = new Date();


                    if (new Date(ideaClosureDate) <= currentDate) {
                        submitButton.disabled = true;
                        submitButton.classList.add('disabled');
                    }
                }
            });


            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll(".vote-btn").forEach(button => {
                    let ideaId = button.getAttribute("data-idea");
                    let userId = button.getAttribute("data-user");
                    let voteType = button.getAttribute("data-type");
                    let likeButton = document.getElementById(`like-btn-${ideaId}`);
                    let dislikeButton = document.getElementById(`dislike-btn-${ideaId}`);
                    let likeCount = button.parentElement.querySelector(".like-count");
                    let dislikeCount = button.parentElement.querySelector(".dislike-count");

                    fetch(`/ideas/${ideaId}/check-vote`, {
                            method: "GET",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute("content"),
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.userHasVoted) {
                                likeButton.disabled = true;
                                dislikeButton.disabled = true;
                                if (data.voteType === 'like') {
                                    likeButton.classList.add("btn-primary");
                                    likeButton.classList.remove("btn-outline-primary");
                                    dislikeButton.classList.add("btn-outline-danger");
                                    dislikeButton.classList.remove("btn-danger");
                                } else if (data.voteType === 'dislike') {
                                    dislikeButton.classList.add("btn-danger");
                                    dislikeButton.classList.remove("btn-outline-danger");
                                    likeButton.classList.add("btn-outline-primary");
                                    likeButton.classList.remove("btn-primary");
                                }
                            }
                        });

                    button.addEventListener("click", function() {
                        if (this.disabled) return;

                        fetch(`/ideas/${ideaId}/vote`, {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute("content"),
                                    "Content-Type": "application/json",
                                },
                                body: JSON.stringify({
                                    vote_type: voteType,
                                    user_id: userId
                                }),
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === "removed") {
                                    likeButton.disabled = false;
                                    dislikeButton.disabled = false;
                                    likeButton.classList.remove("btn-primary");
                                    likeButton.classList.add("btn-outline-primary");
                                    dislikeButton.classList.remove("btn-danger");
                                    dislikeButton.classList.add("btn-outline-danger");
                                }

                                likeCount.textContent = data.like_count || 0;
                                dislikeCount.textContent = data.dislike_count || 0;
                                likeButton.disabled = true;
                                dislikeButton.disabled = true;
                            })
                            .catch(error => console.error('Error:', error));
                    });
                });
            });
        </script>

    </div>
@endsection
