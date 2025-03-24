@extends('layouts.app')

@section('content')
<div class="min-vh-100 bg-sky py-5">
    <div class="container-fluid px-4 px-md-5">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-lg-8 col-xl-6">
                <div class="card shadow-lg border-0 overflow-hidden glass-effect">
                    <div class="card-header bg-gradient-sky text-white py-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-building fa-2x me-3"></i>
                            <h4 class="mb-0 fw-bold">{{ __('Create New Department') }}</h4>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('departments.store') }}" method="POST">
                            @csrf
                            <div class="mb-5">
                                <label for="name" class="form-label fw-bold fs-5 mb-3 text-sky">
                                    <i class="fas fa-tag me-2"></i>Department Name
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-building text-sky"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control form-control-lg border-start-0 ps-0" 
                                           id="name" 
                                           name="name" 
                                           placeholder="Enter department name"
                                           required>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-5">
                                <a href="{{route('departments.index')}}" class="btn btn-outline-sky btn-lg">
                                    <i class="fas fa-arrow-left me-2"></i>Back
                                </a>
                                <button type="submit" class="btn btn-sky btn-lg px-5">
                                    <i class="fas fa-save me-2"></i>Save Department
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --sky-blue: #0ea5e9;
        --sky-blue-light: #38bdf8;
        --sky-blue-dark: #0284c7;
    }

    .bg-sky {
        background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
    }

    .bg-gradient-sky {
        background: linear-gradient(135deg, var(--sky-blue) 0%, var(--sky-blue-dark) 100%);
    }

    .text-sky {
        color: var(--sky-blue);
    }

    .btn-sky {
        background: linear-gradient(135deg, var(--sky-blue) 0%, var(--sky-blue-dark) 100%);
        border: none;
        color: white;
    }

    .btn-sky:hover {
        background: linear-gradient(135deg, var(--sky-blue-dark) 0%, #0369a1 100%);
        color: white;
    }

    .btn-outline-sky {
        color: var(--sky-blue);
        border: 2px solid var(--sky-blue);
    }

    .btn-outline-sky:hover {
        background: var(--sky-blue);
        color: white;
    }

    .glass-effect {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .card {
        border-radius: 20px;
    }

    .card-header {
        border-radius: 20px 20px 0 0 !important;
        border-bottom: none;
    }

    .input-group-text {
        border-radius: 12px 0 0 12px;
        padding: 0.75rem 1.25rem;
    }

    .form-control {
        border-radius: 0 12px 12px 0;
        padding: 0.75rem 1.25rem;
        font-size: 1.1rem;
    }

    .btn {
        border-radius: 12px;
        padding: 0.75rem 2rem;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }
    
    @media (max-width: 768px) {
        .card-body {
            padding: 2rem !important;
        }
        .btn {
            padding: 0.6rem 1.5rem;
            font-size: 1rem;
        }
        .input-group-text, .form-control {
            padding: 0.6rem 1rem;
        }
        .card {
            margin: 1rem;
        }
    }

    @media (max-width: 576px) {
        .card-header {
            padding: 1rem !important;
        }
        .card-body {
            padding: 1.5rem !important;
        }
        .btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        h4 {
            font-size: 1.2rem;
        }
    }
</style>
@endsection
