@extends('layouts.app')

@section('content')
    <div class="container mt-4">
    @can ('idea-submit')         
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
                                    <h6 class="mb-0">
                                        <strong>{{ $idea->user->name }}</strong>
                                    </h6>
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
  
    <button class="btn btn-outline-primary btn-sm me-2">
        <i class="bi bi-hand-thumbs-up-fill"></i> Like
    </button>

    
    <button class="btn btn-outline-danger btn-sm me-2">
        <i class="bi bi-hand-thumbs-down-fill"></i> Dislike
    </button>

  
    <button class="btn btn-outline-secondary btn-sm me-2">
        <i class="bi bi-chat-left-text"></i> Comment
    </button>


</div>
@can ('idea-list')
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

    </div>
@endsection
