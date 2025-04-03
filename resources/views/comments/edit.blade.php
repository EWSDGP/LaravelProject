@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">{{ __('Edit Comment') }}</div>
        <div class="card-body">
            <form method="POST" action="{{ route('comments.update', $comment->comment_id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="comment_text" class="form-label">{{ __('Comment Text') }}</label>
                    <textarea id="comment_text" name="comment_text" class="form-control @error('comment_text') is-invalid @enderror" rows="4" required>{{ old('comment_text', $comment->comment_text) }}</textarea>

                    @error('comment_text')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_anonymous" name="is_anonymous" {{ $comment->is_anonymous ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_anonymous">{{ __('Post as Anonymous') }}</label>
                </div>

                <div class="mb-0">
                    <button type="submit" class="btn btn-primary">{{ __('Update Comment') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection