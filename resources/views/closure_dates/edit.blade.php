@extends('layouts.app')

@section('content')
<div class="container-fluid min-vh-100 py-4 bg-light">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10 col-md-11">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white d-flex align-items-center">
                    <i class="bi bi-calendar-event me-2"></i>
                    <h5 class="mb-0">{{ __('Edit Closure Date') }}</h5>
                </div>
                <div class="card-body p-4">   
                    <form action="{{ route('closure_dates.update', $closureDate->ClosureDate_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="form-floating">
                                    <input type="date" 
                                           name="Idea_ClosureDate" 
                                           class="form-control" 
                                           id="Idea_ClosureDate"
                                           value="{{ $closureDate->Idea_ClosureDate }}" 
                                           required>
                                    <label for="Idea_ClosureDate">
                                        <i class="bi bi-lightbulb me-1"></i> Idea Closure Date
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" 
                                           name="Comment_ClosureDate" 
                                           class="form-control" 
                                           id="Comment_ClosureDate"
                                           value="{{ $closureDate->Comment_ClosureDate }}" 
                                           required>
                                    <label for="Comment_ClosureDate">
                                        <i class="bi bi-chat-dots me-1"></i> Comment Closure Date
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-floating">
                                <input type="text" 
                                       name="Academic_Year" 
                                       class="form-control" 
                                       id="Academic_Year"
                                       value="{{ $closureDate->Academic_Year }}" 
                                       required>
                                <label for="Academic_Year">
                                    <i class="bi bi-mortarboard me-1"></i> Academic Year
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{route('closure_dates.index')}}" class="btn btn-outline-warning btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
