@extends('layouts.dashboard')
@section('title', 'My Playlists')

@section('content')
<style>
    .modal-content { background-color: #0c0a0c !important; border: 1px solid #ff4da6 !important; color: #ffffff !important; }
    .form-control { background-color: #1a1a1a !important; color: #ffffff !important; border: 1px solid #ff4da6 !important; }
    .form-label { color: #ffffff !important; }
    .song-list { background: #0c0a0c; border: 1px solid #333; border-radius: 8px; }
</style>

<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <h2 class="fw-bold text-white mb-0 fs-3">My Playlists</h2>
        <button class="btn w-100 w-sm-auto" data-bs-toggle="modal" data-bs-target="#addPlaylistModal" style="border: 1px solid #ff4da6; color: #ff4da6;">+ Create Playlist</button>
    </div>

    <div class="custom-dashboard-card p-3 p-md-4">
        @forelse($playlists as $playlist)
            <div class="mb-4">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center text-white p-3 gap-2" style="background:#1a1a1a; border-radius: 8px 8px 0 0;">
                    <h5 class="mb-0 fw-bold fs-6">{{ $playlist->name }}</h5>
                    <form action="{{ route('playlists.destroy', $playlist->id) }}" method="POST" class="w-100 w-sm-auto text-end">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger w-100 w-sm-auto" style="font-size: 0.75rem;">Delete Playlist</button>
                    </form>
                </div>
                <div class="song-list p-3" style="border-radius: 0 0 8px 8px;">
                    @forelse($playlist->songs as $song)
                        <div class="d-flex flex-row justify-content-between align-items-center py-2 border-bottom border-secondary gap-2">
                            <span class="small text-white text-wrap" style="max-width:75%;">
                                {{ $song->title }} <br class="d-block d-sm-none"><small class="text-pink">by {{ $song->artist }}</small>
                            </span>
                            <form action="{{ route('playlists.removeSong', [$playlist->id, $song->id]) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger p-0 small text-decoration-none" style="font-size: 0.85rem;">Remove</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-secondary small mb-0 py-1">No songs in this playlist yet.</p>
                    @endforelse
                </div>
            </div>
        @empty
            <p class="text-secondary small py-2">No playlists found.</p>
        @endforelse
    </div>
</div>

<div class="modal fade" id="addPlaylistModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered px-3">
        <div class="modal-content">
            <form action="{{ route('playlists.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <label class="form-label small fw-bold">Playlist Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="E.g., Summer Vibes">
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button class="btn w-100" style="background:#ff4da6; color:#000; font-weight:600;">Save Playlist</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection