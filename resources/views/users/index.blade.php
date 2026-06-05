@extends('dashboard')

@section('content')
<div class="container-fluid p-0">
    
    @if(session('success') || session('error') || $errors->any())
        @if(session('error') || $errors->any())
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
                <div class="toast show align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true" 
                     style="background-color: #0c0a0c; border: 1px solid #dc3545; border-radius: 8px;">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fa-solid fa-triangle-exclamation text-danger me-2"></i>
                            @if(session('error')) {{ session('error') }} @endif
                            @if($errors->any()) Input validation errors encountered! @endif
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @else
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
                <div class="toast show align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true" 
                     style="background-color: #0c0a0c; border: 1px solid #ff4da6; border-radius: 8px;">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fa-solid fa-circle-check text-pink me-2"></i>
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif
    @endif
    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold text-white mb-1">User Directory</h2>
            <p class="text-secondary small">Manage system user credentials and account registration status</p>
        </div>
        <button class="btn" data-bs-toggle="modal" data-bs-target="#addUserModal" 
                style="border: 1px solid #ff4da6; color: #ff4da6; font-size: 0.9rem; padding: 0.5rem 1.25rem; border-radius: 6px; background: transparent; font-weight: 500; transition: all 0.2s;">
            <i class="fa-solid fa-user-plus me-2"></i> Add New User
        </button>
    </div>

    <div class="custom-dashboard-card p-0" style="overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0" style="--bs-table-bg: #0c0a0c; --bs-table-hover-bg: rgba(255, 77, 166, 0.05); color: #ffffff;">
                <thead>
                    <tr style="border-bottom: 1px solid rgba(255, 77, 166, 0.3); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                        <th class="py-3 px-4 text-secondary">ID</th>
                        <th class="py-3 px-4 text-secondary">Full Name</th>
                        <th class="py-3 px-4 text-secondary">Email Address</th>
                        <th class="py-3 px-4 text-secondary">Created At</th>
                        <th class="py-3 px-4 text-end text-secondary">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.05); vertical-align: middle; font-size: 0.95rem;">
                            <td class="py-3 px-4 text-secondary fw-bold">#{{ $user->id }}</td>
                            <td class="py-3 px-4 fw-semibold text-white">{{ $user->name }}</td>
                            <td class="py-3 px-4 text-pink">{{ $user->email }}</td>
                            <td class="py-3 px-4 text-secondary" style="font-size: 0.85rem;">{{ $user->created_at->format('M d, Y H:i') }}</td>
                            <td class="py-3 px-4 text-end">
                                <div class="d-inline-flex gap-3">
                                    <button class="btn btn-link p-0 text-decoration-none fw-semibold" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editUserModal{{ $user->id }}"
                                            style="color: #0dcaf0; font-size: 0.9rem; transition: opacity 0.2s;"
                                            onmouseover="this.style.opacity='0.75'" 
                                            onmouseout="this.style.opacity='1'">
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
                                            style="color: #dc3545; font-size: 0.9rem; transition: opacity 0.2s;"
                                            onmouseover="this.style.opacity='0.75'" 
                                            onmouseout="this.style.opacity='1'">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="background-color: #0c0a0c; border: 1px solid #ff4da6; border-radius: 12px; color: #ffffff;">
                                    <div class="modal-header border-0 pb-0 pt-4 px-4">
                                        <h5 class="modal-title fw-bold text-pink"><i class="fa-solid fa-user-pen me-2"></i> Edit Account Settings</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label text-secondary small fw-bold text-uppercase">Full Name</label>
                                                <input type="text" name="name" class="form-control text-white" value="{{ $user->name }}" required
                                                       style="background-color: #0c0a0c; border: 1px solid rgba(255, 77, 166, 0.4); border-radius: 6px;">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-secondary small fw-bold text-uppercase">Email Address</label>
                                                <input type="email" name="email" class="form-control text-white" value="{{ $user->email }}" required
                                                       style="background-color: #0c0a0c; border: 1px solid rgba(255, 77, 166, 0.4); border-radius: 6px;">
                                            </div>
                                            <div class="mb-1">
                                                <label class="form-label text-secondary small fw-bold text-uppercase">Update Password</label>
                                                <input type="password" name="password" class="form-control text-white" placeholder="••••••••"
                                                       style="background-color: #0c0a0c; border: 1px solid rgba(255, 77, 166, 0.4); border-radius: 6px;">
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
                                            <button type="button" class="btn text-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn px-4" style="background-color: #ff4da6; color: #000000; font-weight: 600;">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-secondary">No registered system users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: #0c0a0c; border: 1px solid #ff4da6; border-radius: 12px; color: #ffffff;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-pink"><i class="fa-solid fa-user-plus me-2"></i> Create User Account</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold text-uppercase">Full Name</label>
                        <input type="text" name="name" class="form-control text-white" placeholder="Enter name" required
                               style="background-color: #0c0a0c; border: 1px solid rgba(255, 77, 166, 0.4); border-radius: 6px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold text-uppercase">Email Address</label>
                        <input type="email" name="email" class="form-control text-white" placeholder="name@example.com" required
                               style="background-color: #0c0a0c; border: 1px solid rgba(255, 77, 166, 0.4); border-radius: 6px;">
                    </div>
                    <div class="mb-1">
                        <label class="form-label text-secondary small fw-bold text-uppercase">Password</label>
                        <input type="password" name="password" class="form-control text-white" placeholder="Minimum 6 characters" required
                               style="background-color: #0c0a0c; border: 1px solid rgba(255, 77, 166, 0.4); border-radius: 6px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
                    <button type="button" class="btn text-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4" style="background-color: #ff4da6; color: #000000; font-weight: 600;">Add New User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: #0c0a0c; border: 1px solid #dc3545; border-radius: 12px; color: #ffffff;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i> Confirm Account Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteUserForm" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body p-4">
                    <p class="text-white mb-3" style="font-size: 0.95rem; line-height: 1.5;">
                        You are about to permanently delete the account for <span id="deleteTargetInfo" class="fw-bold text-danger"></span>.
                    </p>
                    <div class="mb-1">
                        <label class="form-label text-secondary small fw-bold text-uppercase">To confirm, please type <span class="text-white fw-bolder">DELETE</span> in the box below:</label>
                        <input type="text" id="deleteConfirmationInput" class="form-control text-white autocomplete-off" placeholder="Type DELETE to confirm" required
                               style="background-color: #0c0a0c; border: 1px solid rgba(220, 53, 69, 0.4); border-radius: 6px; letter-spacing: 1px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
                    <button type="button" class="btn text-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="deleteSubmitBtn" class="btn px-4" disabled style="background-color: #dc3545; color: #ffffff; font-weight: 600; transition: all 0.2s; opacity: 0.5;">Permanently Delete</button>
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
            // Reset state
            confirmationInput.value = '';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';

            // Gather elements from data tags
            const userName = this.getAttribute('data-name');
            const userEmail = this.getAttribute('data-email');
            const actionUrl = this.getAttribute('data-url');

            // Inject targets
            deleteTargetInfo.textContent = `${userName} (${userEmail})`;
            deleteForm.setAttribute('action', actionUrl);
        });
    });

    // Reactive validator looking for precise keyword match
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