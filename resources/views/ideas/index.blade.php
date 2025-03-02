@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        @can('idea-submit')
            <a href="{{ route('ideas.create') }}" class="btn btn-success">Submit Ideas</a>
        @endcan

        <h2 class="mb-4">Submitted Ideas</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @foreach($ideas as $idea)
                    <div class="card shadow-sm mb-4 rounded-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($idea->user->email))) }}?s=50" class="rounded-circle me-3" alt="User Avatar" width="50" height="50">
                                <div>
                                    <h6 class="mb-0"><strong>{{ $idea->user->name }}</strong></h6>
                                    <p class="text-muted small mb-0">{{ $idea->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <h5 class="fw-bold">{{ $idea->title }}</h5>
                            <p class="card-text">{{ nl2br(e(\Str::limit($idea->description, 300))) }}</p>

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

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="d-flex align-items-center mt-2">
                                    <button class="btn btn-outline-primary btn-sm me-2 vote-btn" 
                                            data-idea="{{ $idea->idea_id }}" 
                                            data-user="{{ Auth::id() }}" 
                                            data-type="like"
                                            id="like-btn-{{ $idea->idea_id }}" 
                                            {{ $idea->votes->where('vote_type', 'like')->where('user_id', Auth::id())->isNotEmpty() ? 'disabled' : '' }}>
                                        <i class="bi bi-hand-thumbs-up-fill"></i> Like 
                                        <span class="like-count">{{ $idea->votes->where('vote_type', 'like')->count() }}</span>
                                    </button>

                                    <button class="btn btn-outline-danger btn-sm me-2 vote-btn" 
                                            data-idea="{{ $idea->idea_id }}" 
                                            data-user="{{ Auth::id() }}" 
                                            data-type="dislike"
                                            id="dislike-btn-{{ $idea->idea_id }}"
                                            {{ $idea->votes->where('vote_type', 'dislike')->where('user_id', Auth::id())->isNotEmpty() ? 'disabled' : '' }}>
                                        <i class="bi bi-hand-thumbs-down-fill"></i> Dislike 
                                        <span class="dislike-count">{{ $idea->votes->where('vote_type', 'dislike')->count() }}</span>
                                    </button>
                                

                                <button class="btn btn-outline-secondary btn-sm me-2">
                                    <i class="bi bi-chat-left-text"></i> Comment
                                </button>
                                </div>
                                @can('idea-list')
                                    <a href="{{ route('ideas.show', $idea->idea_id) }}" class="btn btn-info btn-sm">View</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-center">
            {{ $ideas->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>

        <script>
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
