<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - My Playlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0c0a0c; color: #ffffff; font-family: 'Segoe UI', sans-serif; }
        .card-custom { 
            background-color: #0c0a0c; 
            border: 1px solid #ff4da6; 
            border-radius: 12px; 
            width: 100%; 
            max-width: 460px;
            padding: 2.5rem;
        }
        .text-pink { color: #ff4da6; }
        .btn-pink { 
            background-color: #ff4da6; 
            color: #ffffff; 
            border: none; 
            border-radius: 6px;
            padding: 0.6rem;
            font-weight: bold;
        }
        .btn-pink:hover { background-color: #e03d93; color: #ffffff; }
        
      
        .form-control-dark { 
            background-color: #000000 !important; 
            border: 1px solid #ff4da6 !important; 
            color: #ffffff !important; 
            font-weight: 500 !important;
            border-radius: 6px;
        }
        .form-control-dark:focus { 
            background-color: #000000 !important; 
            border-color: #ff4da6 !important; 
            color: #ffffff !important;
            box-shadow: 0 0 8px rgba(255, 77, 166, 0.5) !important; 
        }
        
  
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: #ffffff !important;
            -webkit-box-shadow: 0 0 0px 1000px #000000 inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .error-text {
            color: #ff4da6;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card card-custom shadow-lg">
        <div class="text-center mb-4">
            <h1 class="fw-bold text-pink h2 mb-1">Create Account</h1>
            <p class="text-secondary small">Join the My Playlist System</p>
        </div>

        <form action="{{ route('register.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold text-secondary">Full Name</label>
                <input type="text" name="name" class="form-control form-control-dark" value="{{ old('name') }}" required autocomplete="off">
                @error('name') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label small fw-bold text-secondary">Email Address</label>
                <input type="email" name="email" class="form-control form-control-dark" value="{{ old('email') }}" required autocomplete="off">
                @error('email') <div class="error-text">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-secondary">Password</label>
                <input type="password" name="password" class="form-control form-control-dark" required>
                @error('password') <div class="error-text">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold text-secondary">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control form-control-dark" required>
            </div>

            <button type="submit" class="btn btn-pink w-100 mb-3">Register</button>
        </form>

        <div class="text-center">
            <p class="small text-secondary mb-0">Already have an account? <a href="{{ route('login') }}" class="text-pink text-decoration-none fw-bold">Login here</a></p>
        </div>
    </div>
</div>

</body>
</html>