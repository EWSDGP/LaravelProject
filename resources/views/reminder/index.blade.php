@extends('layouts.app')

@section('content')
<div class="modal fade" id="reminderModal" tabindex="-1" aria-labelledby="reminderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reminderModalLabel">Send Reminder Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to send a reminder email to this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmSendReminder">Send Reminder</button>
            </div>
        </div>
    </div>
</div>
                <div class="row">
                    <div class="col-12">
                    @session('success')
                <div class="alert alert-success alert-dismissible fade show m-3 border-0 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{$value}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endsession

                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show m-3 border-0 shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                    <div class="card border-0 shadow-sm rounded-0" style="margin: 30px;">
                    
                <div class="card-header bg-white py-4 border-bottom">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle text-primary me-3 fs-2"></i>
                            <h4 class="mb-0 text-primary fs-4">Reminder</h4>
                        </div>
                
                    </div>
                </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Profile Photo</th>
                                <th>Name</th>
                                <th>Idea Count</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($usersWithIdeaCount as $deptUser)
                            @if ($deptUser->id !== $user->id)
                                <tr>
                                    <td class="py-3 px-4">{{ $deptUser->profile_photo }}</td>
                                    <td class="py-3 px-4">{{ $deptUser->name }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-badge me-2"></i>
                                            {{ $deptUser->ideas_count }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="justify-content-center">
                                            @if ($deptUser->ideas_count == 0)
                                                <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                                        data-bs-toggle="modal" data-bs-target="#reminderModal"
                                                        data-user-id="{{ $deptUser->id }}">
                                                    <i class="bi bi-trash me-1"></i>Reminder
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>
<div class="toast-container position-fixed top-15  p-3">
    <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Action completed successfully!
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>


<script>
    let selectedUserId = null;
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            selectedUserId = this.getAttribute('data-user-id');
        });
    });
    document.getElementById('confirmSendReminder').addEventListener('click', function () {
        if (selectedUserId) {
            sendReminderEmail(selectedUserId);
        }
    });
    function sendReminderEmail(userId) {
        fetch(`/send-reminder-email/${userId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        })
        .catch(error => console.error('Error:', error))
        .finally(() => {
        var reminderModal = document.getElementById('reminderModal');
        var modalInstance = bootstrap.Modal.getInstance(reminderModal);
        modalInstance.hide();
        var toastElement = document.getElementById('successToast');
        var toast = new bootstrap.Toast(toastElement);
        toast.show();
    });
    }
</script>




@endsection


