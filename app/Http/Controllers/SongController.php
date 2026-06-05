<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SongController extends Controller
{
    public function index(Request $request)
    {
        $userCount = User::count();
        $query = Song::where('user_id', Auth::id());

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('artist', 'like', "%{$searchTerm}%");
            });
        }

        $songs = $query->latest()->get();
        return view('songs.index', compact('songs', 'userCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'album' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        $validated['user_id'] = Auth::id();
        Song::create($validated);

        return redirect()->back()->with('success', 'Track cataloged successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'album' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        $song = Song::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $song->update($validated);

        return redirect()->back()->with('success', 'Track updated successfully!');
    }

    public function destroy($id)
    {
        $song = Song::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $song->delete();

        return redirect()->back()->with('success', 'Track removed from registry.');
    }

    public function addToPlaylist(Request $request, Song $song)
    {
        $request->validate(['playlist_id' => 'required|exists:playlists,id']);
        $song->playlists()->syncWithoutDetaching([$request->playlist_id]);
        return redirect()->back()->with('success', 'Added to playlist!');
    }
}