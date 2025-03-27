@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Past Ideas (Commenting Closed)</h2>

    <form method="GET" action="{{ route('ideas.past_comment_closure') }}" class="mb-4">
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
                        <option value="{{ $department->department_id }}" {{ request('department_id') == $department->department_id ? 'selected' : '' }}>
                            {{ $department->department_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <select name="sort" class="form-select">
                    <option value="">Sort by</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                    <option value="latest_comment" {{ request('sort') == 'latest_comment' ? 'selected' : '' }}>Latest Comment</option>
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest</option>
                </select>
            </div>

            <div class="col-md-12 mt-2">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </div>
        </div>
    </form>

    @if($ideas->isEmpty())
        <p class="text-center">No ideas found.</p>
    @else
        <div class="list-group">
            @foreach($ideas as $idea)
                <div class="list-group-item">
                    <h5>
                        @if($idea->is_anonymous)
                            <i>(Anonymous)</i>
                        @else
                            {{ $idea->user->name }}
                        @endif
                        - {{ $idea->title }}
                    </h5>

                    <p>{{ Str::limit($idea->description, 150) }}</p>
                    
                    <p>
                        <strong>Category:</strong> {{ $idea->category->category_name }} |
                        <strong>Department:</strong> {{ $idea->user->department->department_name }}
                    </p>

                    <p>
                        <strong>Created:</strong> {{ $idea->created_at->format('d M Y') }} |
                        <strong>Likes:</strong> {{ $idea->likes_count ?? 0 }} |
                        <strong>Dislikes:</strong> {{ $idea->dislikes_count ?? 0 }}
                    </p>

                    <p>
                        <strong>Idea Closure Date:</strong> {{ $idea->closureDate->Idea_ClosureDate->format('d M Y') }} |
                        <strong>Comment Closure Date:</strong> {{ $idea->closureDate->Comment_ClosureDate->format('d M Y') }}
                    </p>

                    @if(!$idea->can_comment)
                        <span class="badge bg-danger">Commenting Closed</span>
                    @endif

                    <a href="{{ route('ideas.show', $idea->idea_id) }}" class="btn btn-sm btn-outline-primary">View Idea</a>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $ideas->links() }}
        </div>
    @endif
</div>
@endsection
