@extends('layouts.dashboard')

@section('title', 'My Songs')

@section('content')
<style>
    .modal-content { background-color: #0c0a0c !important; border: 1px solid #ff4da6 !important; color: #ffffff !important; }
    
    .form-control { 
        background-color: #1a1a1a !important; 
        color: #ffffff !important; 
        border: 1px solid #ff4da6 !important; 
    }
    
    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.6) !important;
        opacity: 1 !important;
    }

    .action-group { display: flex; align-items: center; justify-content: flex-end; gap: 8px; }
</style>

<div class="container-fluid p-0">
    <div class="mb-4">
        <form action="{{ route('songs.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Search title or artist..." value="{{ request('search') }}">
            <button type="submit" class="btn" style="border: 1px solid #ff4da6; color: #ff4da6;">Search</button>
            @if(request('search')) <a href="{{ route('songs.index') }}" class="btn btn-outline-secondary">Clear</a> @endif
        </form>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-white">My Songs</h2>
        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addSongModal" style="border: 1px solid #ff4da6; color: #ff4da6;">+ Add New Track</button>
    </div>

    <div class="custom-dashboard-card p-0" style="overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0">
                <thead>
                    <tr style="border-bottom: 1px solid #ff4da6;">
                        <th class="py-3 px-4">Title</th>
                        <th class="py-3 px-4">Artist</th>
                        <th class="py-3 px-4">Album</th>
                        <th class="py-3 px-4">Year</th>
                        <th class="py-3 px-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($songs as $song)
                        <tr>
                            <td class="py-3 px-4">{{ $song->title }}</td>
                            <td class="py-3 px-4 text-pink">{{ $song->artist }}</td>
                            <td class="py-3 px-4">{{ $song->album ?? '-' }}</td>
                            <td class="py-3 px-4">{{ $song->year ?? '-' }}</td>
                            <td class="py-3 px-4">
                                <div class="action-group">
                                    <form action="{{ route('songs.addToPlaylist', $song->id) }}" method="POST" class="d-flex gap-1">
                                        @csrf
                                        <select name="playlist_id" class="form-control form-control-sm" style="width: 120px;" required>
                                            <option value="" disabled selected>Playlist...</option>
                                            @foreach(Auth::user()->playlists as $p) 
                                                <option value="{{ $p->id }}">{{ $p->name }}</option> 
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-outline-light">Add</button>
                                    </form>
                                    <button class="btn btn-link p-0 text-info text-decoration-none" data-bs-toggle="modal" data-bs-target="#editModal{{ $song->id }}">Edit</button>
                                    <form action="{{ route('songs.destroy', $song->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0 text-danger text-decoration-none" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="editModal{{ $song->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered"><div class="modal-content"><form action="{{ route('songs.update', $song->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-body p-4">
                                    <input type="text" name="title" class="form-control mb-3" value="{{ $song->title }}" required>
                                    <input type="text" name="artist" class="form-control mb-3" value="{{ $song->artist }}" required>
                                    <input type="text" name="album" class="form-control mb-3" value="{{ $song->album }}">
                                    <input type="number" name="year" class="form-control" value="{{ $song->year }}" placeholder="YYYY" min="1900" max="{{ date('Y')+1 }}">
                                </div>
                                <div class="modal-footer border-0"><button type="submit" class="btn" style="background:#ff4da6; color: #000;">Update Track</button></div>
                            </form></div></div>
                        </div>
                    @empty
                        <tr><td colspan="5" class="text-center py-4">No tracks found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addSongModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content"><form action="{{ route('songs.store') }}" method="POST">
        @csrf
        <div class="modal-body p-4">
            <input type="text" name="title" class="form-control mb-3" placeholder="Title" required>
            <input type="text" name="artist" class="form-control mb-3" placeholder="Artist" required>
            <input type="text" name="album" class="form-control mb-3" placeholder="Album">
            <input type="number" name="year" class="form-control" placeholder="YYYY" min="1900" max="{{ date('Y')+1 }}">
        </div>
        <div class="modal-footer border-0"><button type="submit" class="btn" style="background:#ff4da6; color: #000;">Save Track</button></div>
    </form></div></div>
</div>
@endsection