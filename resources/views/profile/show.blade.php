@extends('layouts.dashboard')

@section('content')
<style>
    .custom-card { background-color: #121212; border: 1px solid #ff4da6; border-radius: 0; padding: 25px; color: #fff; }
    .text-pink { color: #ff4da6; font-weight: bold; }
    .btn-pink { background-color: #ff4da6; color: #000; font-weight: bold; border-radius: 0; }
    
    /* Optimized input values for visible typing text clarity */
    .form-control { background-color: #000 !important; color: #fff !important; border: 1px solid #333 !important; border-radius: 0; padding-top: 8px; height: 40px; }
    .form-control::placeholder { color: rgba(255, 255, 255, 0.4) !important; }
    
    .profile-img { width: 150px; height: 150px; border: 2px solid #ff4da6; border-radius: 50%; object-fit: cover; }
    .profile-circle { width: 150px; height: 150px; background-color: #333; border: 2px solid #ff4da6; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 3rem; font-weight: bold; margin: 0 auto; }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-4">
            <div class="custom-card text-center">
                @if($user->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" class="profile-img mb-3">
                @else
                    <div class="profile-circle mb-3">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                @endif
                <h4 class="text-white">{{ $user->name }}</h4>
                <p class="text-secondary">{{ $user->email }}</p>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="custom-card mb-4">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <h5 class="text-pink mb-3">Upload Profile Picture</h5>
                    <input type="file" name="profile_picture" class="form-control mb-3">
                    <h5 class="text-pink mb-3">Profile Information</h5>
                    <input type="text" name="name" class="form-control mb-2" value="{{ $user->name }}">
                    <input type="email" name="email" class="form-control mb-3" value="{{ $user->email }}">
                    <button type="submit" class="btn btn-pink">SAVE CHANGES</button>
                </form>
            </div>

            <div class="custom-card mb-4">
                <h5 class="text-pink mb-3">Update Password</h5>
                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf @method('PUT')
                    <label class="text-white small mb-1">Current Password:</label>
                    <input type="password" name="current_password" class="form-control mb-2">
                    <label class="text-white small mb-1">New Password:</label>
                    <input type="password" name="password" class="form-control mb-2">
                    <label class="text-white small mb-1">Confirm Password:</label>
                    <input type="password" name="password_confirmation" class="form-control mb-3">
                    <button type="submit" class="btn btn-pink">SAVE</button>
                </form>
            </div>

            <div class="custom-card">
                <h5 class="text-pink mb-3">Delete Account</h5>
                
                <p class="text-secondary small d-block mb-3">
                    Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                </p>

                <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-pink text-uppercase" style="background-color: #ff4da6; color: #000; border: none;">DELETE ACCOUNT</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection