@extends('layouts.app')

@section('content')
    <!-- @component('components.navigation', ['title' => session('title')])
    @endcomponent -->
    <div class="container mt-4">
        <div class="d-flex justify-content-end mb-3">
        @php
   
    $latestClosureDate = \App\Models\ClosureDate::latest()->first()->Idea_ClosureDate;
    $currentDate = now();
@endphp

@can('idea-submit')
    <a href="{{ route('ideas.create') }}" 
       class="btn btn-outline-success btn-sm me-2" 
       id="submit-button"
       data-closure-date="{{ $latestClosureDate }}"
       @if($currentDate->greaterThanOrEqualTo($latestClosureDate)) disabled @endif>
       Submit Ideas
    </a>
@endcan

      
        </div>
        @can('download-ideas')
            <!-- <a href="{{ route('ideas.export.combined') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-file-earmark-zip"></i> Download CSV & Documents (ZIP)
            </a> -->
            <form action="{{ route('ideas.export.combined') }}" method="GET">
                <label for="academic_year">Select Academic Year:</label>
                <select name="academic_year" id="academic_year" class="form-select" required>
                    <option value="">-- Choose Academic Year --</option>
                    @foreach($academicYears as $id => $year)
                        <option value="{{ $id }}">{{ $year }}</option>
                    @endforeach
                </select>
                
                <button type="submit" class="btn btn-primary mt-2">Download Ideas</button>
            </form>

            @endcan
        <form method="GET" action="{{ route('ideas.index') }}" class="mb-4">
    <div class="row">
        <div class="col-md-4">
            <select name="category_id" class="form-select">
                <option value="">Filter by Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->category_id }}" {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>

       
        <div class="col-md-4">
            <select name="department_id" class="form-select">
                <option value="">Filter by Department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div>

       
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Apply Filters</button>
            <a href="{{ route('ideas.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </div>
</form>

<form method="GET" action="{{ route('ideas.index') }}" class="mb-4">
    <label for="sort">Sort by:</label>
    <select name="sort" id="sort" onchange="this.form.submit()">
        <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Latest</option>
        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
        <option value="latest_comment" {{ request('sort') == 'latest_comment' ? 'selected' : '' }}>Latest Comment</option>
    </select>
</form>


        <h2 class="mb-4">Submitted Ideas</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @foreach($ideas as $idea)
                    @php
                        $currentDate = now(); 
                        $closureDate = $idea->closureDate; 
                        $ideaDisabled = $currentDate->greaterThanOrEqualTo($closureDate->Idea_ClosureDate); 
                        $canComment = $currentDate->lessThanOrEqualTo($closureDate->Comment_ClosureDate); 
                    @endphp
                    <div class="card shadow-sm mb-4 rounded-3">
                        <div class="card-body">
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

                        <img src="{{ $profilePhoto }}" class="rounded-circle me-3" alt="User Avatar" width="50" height="50">
                    <div>
                         <h6 class="mb-0">
                            <strong>
                                {{ $idea->is_anonymous ? 'Anonymous' : $idea->user->name }}
                            </strong>
                        </h6>
                                    <p class="text-muted small mb-0">{{ $idea->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <h5 class="fw-bold">{{ $idea->title }}</h5>
                            <p class="card-text">{{ nl2br(e(\Str::limit($idea->description, 3000))) }}</p>

                            @if($idea->documents->isNotEmpty())
                                <div class="mb-3">
                                    @foreach($idea->documents as $document)
                                        @php
                                            $filePath = asset('storage/' . $document->file_path);
                                            $extension = pathinfo($document->file_path, PATHINFO_EXTENSION);
                                        @endphp
                                        @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']))
                                            <img src="{{ $filePath }}" alt="Document Image" class="img-fluid rounded mb-2">
                                        @else
                                            <a href="{{ $filePath }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i class="bi bi-file-earmark-text"></i> View {{ strtoupper($extension) }} File
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            
                            @if($ideaDisabled)
                                <!-- <p class="text-muted">Ideas Open Test</p> -->
                            @else
                                <!-- <p class="text-success">Ideas Close Test</p> -->
                            @endif

                            @if(!$canComment)
                                <!-- <p class="text-muted">Comments Close Test</p> -->
                            @else
                                <!-- <p class="text-success">Comment Open Test</p> -->
                            @endif

                            <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="d-flex align-items-center mt-2">
                                <button class="btn btn-outline-primary btn-sm me-2 vote-btn" 
                                        data-idea="{{ $idea->idea_id }}" 
                                        data-user="{{ Auth::id() }}" 
                                        data-type="like"
                                        id="like-btn-{{ $idea->idea_id }}" 
                                        {{ $ideaDisabled || $idea->votes->where('vote_type', 'like')->where('user_id', Auth::id())->isNotEmpty() ? 'disabled' : '' }}>
                                    <i class="bi bi-hand-thumbs-up-fill"></i> Like 
                                    <span class="like-count">{{ $idea->votes->where('vote_type', 'like')->count() }}</span>
                                </button>

                                <button class="btn btn-outline-danger btn-sm me-2 vote-btn" 
                                        data-idea="{{ $idea->idea_id }}" 
                                        data-user="{{ Auth::id() }}" 
                                        data-type="dislike"
                                        id="dislike-btn-{{ $idea->idea_id }}"
                                        {{ $ideaDisabled || $idea->votes->where('vote_type', 'dislike')->where('user_id', Auth::id())->isNotEmpty() ? 'disabled' : '' }}>
                                    <i class="bi bi-hand-thumbs-down-fill"></i> Dislike 
                                    <span class="dislike-count">{{ $idea->votes->where('vote_type', 'dislike')->count() }}</span>
                                </button>
                            </div>
                            @if($idea->user_id !== Auth::id()) 
    <div class="mt-3">
        <button class="btn btn-outline-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#reportModal-{{ $idea->idea_id }}">
            <i class="bi bi-flag"></i> Report
        </button>
    </div>

   
    <div class="modal fade" id="reportModal-{{ $idea->idea_id }}" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Report Idea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('ideas.report', $idea->idea_id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label for="reason" class="form-label">Reason:</label>
                        
                        
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" value="Inappropriate Content" id="reason1" required>
                            <label class="form-check-label" for="reason1">Inappropriate Content</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" value="Spam" id="reason2" required>
                            <label class="form-check-label" for="reason2">Spam</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" value="Harassment" id="reason3" required>
                            <label class="form-check-label" for="reason3">Harassment</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" value="Copyright Violation" id="reason4" required>
                            <label class="form-check-label" for="reason4">Copyright Violation</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" value="False Information" id="reason5" required>
                            <label class="form-check-label" for="reason5">False Information</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" value="Offensive Language" id="reason6" required>
                            <label class="form-check-label" for="reason6">Offensive Language</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" value="Personal Attacks" id="reason7" required>
                            <label class="form-check-label" for="reason7">Personal Attacks</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" value="Discrimination" id="reason8" required>
                            <label class="form-check-label" for="reason8">Discrimination</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" value="Violence" id="reason9" required>
                            <label class="form-check-label" for="reason9">Violence</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Submit Report</button>
                    </div>
                </form>

                    </div>
                </div>
            </div>
        @endif

                        </div>

            <div class="mt-3">
                <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#comments-{{ $idea->idea_id }}">
                    <i class="bi bi-chat-left-text"></i> Comments ({{ $idea->comments->count() }})
                </button>

                @can('comment-list')
                <div class="collapse mt-2" id="comments-{{ $idea->idea_id }}">
                    @foreach($idea->comments as $comment)
                        <div class="border rounded p-2 mb-2 bg-light d-flex align-items-start">
                        
                            @if(!$comment->is_anonymous)
                                <img src="{{ $comment->user->profile_photo ? asset('storage/' . $comment->user->profile_photo) : asset('storage/profile_photos/default-profile.jpg') }}" 
                                    alt="User Profile" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                            @else
                                <img src="{{ asset('storage/profile_photos/default-profile.jpg') }}" 
                                    alt="Anonymous" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                            @endif

                            <div>
                                <strong>{{ $comment->is_anonymous ? 'Anonymous' : $comment->user->name }}</strong>
                                <p class="mb-1">{{ $comment->comment_text }}</p>
                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    @endforeach

                    @can('comment-submit')
                    @auth
                        @if($canComment)
                            <form action="{{ route('comments.store', $idea->idea_id) }}" method="POST" class="mt-2">
                                @csrf
                                <textarea class="form-control mb-2" name="comment_text" rows="2" placeholder="Write a comment..." required></textarea>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <input type="checkbox" name="is_anonymous" id="anonymous-{{ $idea->idea_id }}">
                                        <label for="anonymous-{{ $idea->idea_id }}">Post as Anonymous</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Comment</button>
                                </div>
                            </form>
                        @else
                            <p class="text-muted">Comments Closed</p>
                        @endif
                    @endauth
                    @endcan
                </div>
                @endcan
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
            document.addEventListener("DOMContentLoaded", function () {
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


            document.addEventListener("DOMContentLoaded", function () {
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
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
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

                    button.addEventListener("click", function () {
                        if (this.disabled) return;

                        fetch(`/ideas/${ideaId}/vote`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify({ vote_type: voteType, user_id: userId }),
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
