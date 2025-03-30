@extends('layouts.app')

@section('content')
<!-- Only Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="container-fluid px-4">
    <div class="row my-4">
        <div class="col">
            <h2 class="display-6 mb-4 text-primary">
                <i class="fas fa-flag me-2"></i>
                Manage Reports
            </h2>
            
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-25 p-2 rounded-circle me-2">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                        </div>
                        <strong class="me-2">Success!</strong> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4">ID</th>
                                    <th>Reporter</th>
                                    <th>Idea Title</th>
                                    <th>Idea Author</th>
                                    <th>Description</th>
                                    <th>Reason</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    <tr>
                                        <td class="px-4"><span class="badge bg-primary rounded-pill">{{ $report->id }}</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-user-circle fs-5 text-primary me-2"></i>
                                                <span>{{ $report->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-lightbulb fs-5 text-warning me-2"></i>
                                                <span>{{ $report->idea->title }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-user-edit fs-5 text-success me-2"></i>
                                                <span>{{ $report->idea->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 200px;">
                                                <i class="fas fa-align-left text-secondary me-2"></i>
                                                {{ $report->idea->description }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 150px;">
                                                <i class="fas fa-exclamation-circle text-danger me-2"></i>
                                                {{ $report->reason }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <button type="button" class="btn btn-danger btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal{{ $report->id }}"
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-title="Delete Report">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                
                                                <button type="button" class="btn btn-danger btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#banModal{{ $report->idea->user->id }}"
                                                        {{ $report->idea->user->is_banned ? 'disabled' : '' }}
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-title="Ban User">
                                                    <i class="fas fa-ban"></i>
                                                </button>

                                                <button type="button" class="btn btn-success btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#unbanModal{{ $report->idea->user->id }}"
                                                        {{ !$report->idea->user->is_banned ? 'disabled' : '' }}
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-title="Unban User">
                                                    <i class="fas fa-user-check"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modals for each action -->
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{ $report->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirm Delete
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-0">Are you sure you want to delete this report? This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('manage.reports.delete', $report->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Report</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Ban Modal -->
<div class="modal fade" id="banModal{{ $report->idea->user->id }}" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title" id="banModalLabel">
                    <i class="fas fa-ban me-2"></i>
                    Confirm Ban User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-0">Are you sure you want to ban this user? They will no longer be able to access the system.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('manage.reports.ban', $report->idea->user->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Ban User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Unban Modal -->
<div class="modal fade" id="unbanModal{{ $report->idea->user->id }}" tabindex="-1" aria-labelledby="unbanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white border-0">
                <h5 class="modal-title" id="unbanModalLabel">
                    <i class="fas fa-user-check me-2"></i>
                    Confirm Unban User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-0">Are you sure you want to unban this user? They will regain access to the system.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('manage.reports.unban', $report->idea->user->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">Unban User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize Bootstrap tooltips and modals
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Auto-hide success alert after 3 seconds
    var successAlert = document.querySelector('.alert-success');
    if (successAlert) {
        setTimeout(function() {
            var alert = bootstrap.Alert.getOrCreateInstance(successAlert);
            alert.close();
        }, 3000);
    }
});
</script>
@endsection
