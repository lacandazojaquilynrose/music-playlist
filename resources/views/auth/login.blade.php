<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - My Playlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #0c0a0c; color: #ffffff; font-family: 'Segoe UI', sans-serif; }
        .card-custom { 
            background-color: #0c0a0c; 
            border: 1px solid #ff4da6; 
            border-radius: 12px; 
            width: 100%; 
            max-width: 400px;
            padding: 2.5rem;
        }
        .text-pink { color: #ff4da6; }
        .btn-pink { 
            background-color: #ff4da6; 
            color: #000000; 
            border: none; 
            border-radius: 4px;
            padding: 0.6rem;
            font-weight: bold;
        }
        .btn-pink:hover { background-color: #e03d93; color: #ffffff; }
        
        .form-control-dark { 
            background-color: #1c181c !important; 
            border: 1px solid #ff4da6 !important; 
            color: #ffffff !important; 
            font-weight: 500 !important;
            border-radius: 4px;
        }
        .form-control-dark:focus { 
            background-color: #1c181c !important; 
            border-color: #ff4da6 !important; 
            box-shadow: 0 0 8px rgba(255, 77, 166, 0.4) !important; 
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: #ffffff !important;
            -webkit-box-shadow: 0 0 0px 1000px #1c181c inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .toast-container-custom { position: fixed; top: 20px; right: 20px; z-index: 1060; }
    </style>
</head>
<body>

<div class="toast-container-custom">
    @if(session('toast_success'))
        <div class="toast show align-items-center text-white bg-success border-0 mb-2" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('toast_success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif
</div>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card card-custom shadow-lg">
        <div class="text-center mb-4">
            <h1 class="fw-bold text-pink display-5 mb-3">Login</h1>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger bg-danger text-white border-0 py-2 small mb-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold text-secondary">Email</label>
                <input type="email" name="email" class="form-control form-control-dark" value="{{ old('email') }}" required autocomplete="off">
            </div>
            
            <div class="mb-4">
                <label class="form-label small fw-bold text-secondary">Password</label>
                <input type="password" name="password" class="form-control form-control-dark" required>
            </div>

            <button type="submit" class="btn btn-pink w-100 mb-3">Log in</button>
        </form>

        <div class="text-center">
            <p class="small text-secondary mb-0">Don't have an account yet? <a href="{{ route('register') }}" class="text-pink text-decoration-none">Register</a></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>