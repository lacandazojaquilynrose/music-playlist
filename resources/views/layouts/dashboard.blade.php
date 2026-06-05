<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - My Playlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #0c0a0c; color: #ffffff; font-family: 'Segoe UI', sans-serif; margin: 0; min-height: 100vh; }
        
        /* Responsive Top Header adjustments */
        .top-navbar { background-color: #0c0a0c; border-bottom: 2px solid #ff4da6; min-height: 75px; padding: 1rem 1.5rem; }
        .text-pink { color: #ff4da6 !important; }
        
        /* Flex wrapper changes layout automatically based on device screen sizes */
        .page-wrapper { display: flex; flex-direction: column; min-height: calc(100vh - 75px); }
        
        /* Sidebar container styles - adapts safely to phones vs desktops */
        .sidebar-wrapper { width: 100%; padding: 1rem; background-color: #0c0a0c; flex-shrink: 0; }
        .sidebar-box-container { background-color: #0c0a0c; border: 1px solid #ff4da6; border-radius: 8px; padding: 1.25rem 1rem; display: flex; flex-direction: column; }
        .sidebar-title { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1.5px; color: #8c8c8c; font-weight: 700; margin-bottom: 1.25rem; padding-left: 0.5rem; }
        
        .nav-link-custom { color: #ffffff; display: flex; align-items: center; padding: 0.7rem 0.85rem; border-radius: 6px; text-decoration: none; margin-bottom: 0.4rem; font-size: 0.95rem; font-weight: 500; transition: all 0.2s ease; }
        .nav-link-custom i { margin-right: 0.85rem; width: 20px; text-align: center; }
        .nav-link-custom:hover { color: #ff4da6; }
        .nav-link-custom.active-link { background-color: rgba(255, 77, 166, 0.15); color: #ff4da6; }
        .sidebar-divider { border-top: 1px solid rgba(255, 77, 166, 0.4); margin: 1rem 0; }
        
        /* Flexible viewport area padding */
        .main-viewport { flex-grow: 1; padding: 1.25rem; background-color: #0c0a0c; width: 100%; overflow-x: hidden; }
        .custom-dashboard-card { background-color: #0c0a0c; border: 1px solid #ff4da6; border-radius: 8px; padding: 1.75rem; }
        .card-icon-round { width: 48px; height: 48px; border-radius: 50%; border: 1px solid #ff4da6; display: flex; align-items: center; justify-content: center; color: #ff4da6; }

        /* Media queries rule sets specifically targeting tablet / computer screens */
        @media (min-width: 768px) {
            .top-navbar { padding: 0 2.5rem; }
            .page-wrapper { flex-direction: row; }
            .sidebar-wrapper { width: 280px; padding: 2rem 1.5rem; }
            .sidebar-box-container { height: 100%; }
            .main-viewport { padding: 2.5rem; width: calc(100% - 280px); }
        }
    </style>
</head>
<body>

<div class="top-navbar d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-2">
    <span class="text-pink fw-bold h4 mb-0"><i class="fa-solid fa-compact-disc me-2"></i> MY PLAYLIST</span>
    <span class="text-white fs-6 fs-md-5">Welcome, <strong class="text-pink">{{ Auth::user()->name ?? 'user' }}</strong></span>
</div>

<div class="page-wrapper">
    <div class="sidebar-wrapper">
        <div class="sidebar-box-container">
            <div class="sidebar-title">Navigation</div>
            <a href="{{ route('dashboard') }}" class="nav-link-custom {{ Request::is('dashboard') ? 'active-link' : '' }}"><i class="fa-solid fa-chart-simple"></i> Dashboard Overview</a>
            <a href="{{ route('users.index') }}" class="nav-link-custom {{ Request::is('users*') ? 'active-link' : '' }}"><i class="fa-solid fa-users"></i> User Directory</a>
            <a href="{{ route('songs.index') }}" class="nav-link-custom {{ Request::is('songs*') ? 'active-link' : '' }}"><i class="fa-solid fa-music"></i> My Songs</a>
            <a href="{{ route('playlists.index') }}" class="nav-link-custom {{ Request::is('playlists*') ? 'active-link' : '' }}"><i class="fa-solid fa-layer-group"></i> Playlists</a>

            <div class="mt-md-auto">
                <div class="sidebar-divider"></div>
                <a href="{{ route('profile.show') }}" class="nav-link-custom {{ Request::is('profile*') ? 'active-link' : '' }}"><i class="fa-solid fa-user-gear"></i> My Profile</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link-custom text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </div>
    </div>

    <div class="main-viewport">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>