@extends('layouts.dashboard')

@section('content')
<style>
    .form-control {
        background-color: #0c0a0c !important;
        color: #ffffff !important;
    }
    .form-control::placeholder {
        color: #7a7a7a !important;
        opacity: 1 !important;
    }
    .form-control:focus {
        background-color: #0c0a0c !important;
        color: #ffffff !important;
        border-color: #ff4da6 !important;
        box-shadow: 0 0 0 0.25rem rgba(255, 77, 166, 0.25) !important;
    }
    #deleteConfirmationInput:focus {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
    }
</style>

<div class="container-fluid p-0">
    
    @if(session('success') || session('error') || $errors->any())
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080; max-width: calc(100% - 20px);">
            @if(session('error') || $errors->any())
                <div class="toast show align-items-center text-white border-0 mb-2" role="alert" style="background-color: #0c0a0c; border: 1px solid #dc3545 !important; border-radius: 8px;">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fa-solid fa-triangle-exclamation text-danger me-2"></i>
                            @if(session('error')) {{ session('error') }} @endif
                            @if($errors->any()) Input validation errors encountered! @endif
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            @else
                <div class="toast show align-items-center text-white border-0" role="alert" style="background-color: #0c0a0c; border: 1px solid #ff4da6 !important; border-radius: 8px;">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fa-solid fa-circle-check text-pink me-2"></i>
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            @endif
        </div>
    @endif
    
    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-white mb-1 fs-3">User Directory</h2>
            <p class="text-secondary small mb-0">Manage system user credentials and account registration status</p>
        </div>
        <button class="btn w-100 w-sm-auto text-nowrap" data-bs-toggle="modal" data-bs-target="#addUserModal" 
                style="border: 1px solid #ff4da6; color: #ff4da6; font-size: 0.9rem; padding: 0.5rem 1.25rem; border-radius: 6px; background: transparent; font-weight: 500;">
            <i class="fa-solid fa-user-plus me-2"></i> Add New User
        </button>
    </div>

    <div class="custom-dashboard-card p-0" style="overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle" style="--bs-table-bg: #0c0a0c; --bs-table-hover-bg: rgba(255, 77, 166, 0.05); color: #ffffff;">
                <thead>
                    <tr style="border-bottom: 1px solid rgba(255, 77, 166, 0.3); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">
                        <th class="py-3 px-3 text-secondary">ID</th>
                        <th class="py-3 px-3 text-secondary">Full Name</th>
                        <th class="py-3 px-3 text-secondary">Email Address</th>
                        <th class="py-3 px-3 text-secondary text-nowrap">Created At</th>
                        <th class="py-3 px-3 text-end text-secondary">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.05); font-size: 0.9rem;">
                            <td class="py-3 px-3 text-secondary fw-bold">#{{ $user->id }}</td>
                            <td class="py-3 px-3 fw-semibold text-white text-wrap" style="max-width: 130px;">{{ $user->name }}</td>
                            <td class="py-3 px-3 text-pink text-break" style="max-width: 150px;">{{ $user->email }}</td>
                            <td class="py-3 px-3 text-secondary small text-nowrap">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="py-3 px-3 text-end">
                                <div class="d-inline-flex gap-2 gap-md-3">
                                    <button class="btn btn-link p-0 text-decoration-none fw-semibold" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editUserModal{{ $user->id }}"
                                            style="color: #0dcaf0; font-size: 0.85rem;">
                                        Edit
                                    </button>
                                    <button type="button" 
                                            class="btn btn-link p-0 text-decoration-none fw-semibold btn-delete-trigger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteUserModal"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-email="{{ $user->email }}"
                                            data-url="{{ route('users.destroy', $user->id) }}"
                                            style="color: #dc3545; font-size: 0.85rem;">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered px-3">
                                <div class="modal-content" style="background-color: #0c0a0c; border: 1px solid #ff4da6; border-radius: 12px; color: #ffffff;">
                                    <div class="modal-header border-0 pb-0 pt-4 px-4">
                                        <h5 class="modal-title fw-bold text-pink"><i class="fa-solid fa-user-pen me-2"></i> Edit Account Settings</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label text-secondary small fw-bold text-uppercase">Full Name</label>
                                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required style="border: 1px solid rgba(255, 77, 166, 0.4); border-radius: 6px;">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-secondary small fw-bold text-uppercase">Email Address</label>
                                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required style="border: 1px solid rgba(255, 77, 166, 0.4); border-radius: 6px;">
                                            </div>
                                            <div class="mb-1">
                                                <label class="form-label text-secondary small fw-bold text-uppercase">Update Password</label>
                                                <input type="password" name="password" class="form-control" placeholder="••••••••" style="border: 1px solid rgba(255, 77, 166, 0.4); border-radius: 6px;">
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex justify-content-end gap-2">
                                            <button type="button" class="btn text-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-sm px-4" style="background-color: #ff4da6; color: #000000; font-weight: 600;">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-secondary small">No registered system users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered px-3">
        <div class="modal-content" style="background-color: #0c0a0c; border: 1px solid #ff4da6; border-radius: 12px; color: #ffffff;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-pink"><i class="fa-solid fa-user-plus me-2"></i> Create User Account</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold text-uppercase">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter name" required style="border: 1px solid rgba(255, 77, 166, 0.4); border-radius: 6px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold text-uppercase">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="name@example.com" required style="border: 1px solid rgba(255, 77, 166, 0.4); border-radius: 6px;">
                    </div>
                    <div class="mb-1">
                        <label class="form-label text-secondary small fw-bold text-uppercase">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required style="border: 1px solid rgba(255, 77, 166, 0.4); border-radius: 6px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn text-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm px-4" style="background-color: #ff4da6; color: #000000; font-weight: 600;">Add New User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered px-3">
        <div class="modal-content" style="background-color: #0c0a0c; border: 1px solid #dc3545; border-radius: 12px; color: #ffffff;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i> Confirm Account Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="deleteUserForm" action="" method="POST">
                @csrf @method('DELETE')
                <div class="modal-body p-4">
                    <p class="text-white mb-3 small" style="line-height: 1.5;">
                        You are about to permanently delete the account for <span id="deleteTargetInfo" class="fw-bold text-danger text-break"></span>.
                    </p>
                    <div class="mb-1">
                        <label class="form-label text-secondary small fw-bold text-uppercase" style="font-size:0.75rem;">To confirm, please type <span class="text-white fw-bolder">DELETE</span> in the box below:</label>
                        <input type="text" id="deleteConfirmationInput" class="form-control" placeholder="Type DELETE to confirm" required style="border: 1px solid rgba(220, 53, 69, 0.4); border-radius: 6px; letter-spacing: 1px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn text-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="deleteSubmitBtn" class="btn btn-sm px-3" disabled style="background-color: #dc3545; color: #ffffff; font-weight: 600; opacity: 0.5;">Permanently Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-delete-trigger');
    const deleteForm = document.getElementById('deleteUserForm');
    const deleteTargetInfo = document.getElementById('deleteTargetInfo');
    const confirmationInput = document.getElementById('deleteConfirmationInput');
    const submitBtn = document.getElementById('deleteSubmitBtn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            confirmationInput.value = '';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';

            const userName = this.getAttribute('data-name');
            const userEmail = this.getAttribute('data-email');
            const actionUrl = this.getAttribute('data-url');

            deleteTargetInfo.textContent = `${userName} (${userEmail})`;
            deleteForm.setAttribute('action', actionUrl);
        });
    });

    confirmationInput.addEventListener('input', function() {
        if (this.value === 'DELETE') {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
        } else {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';
        }
    });
});
</script>
@endsection