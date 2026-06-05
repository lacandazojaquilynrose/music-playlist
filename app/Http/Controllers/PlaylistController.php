<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    public function index()
    {
        $playlists = Playlist::where('user_id', Auth::id())->with('songs')->get();
        return view('playlists.index', compact('playlists'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        
        Playlist::create([
            'name' => $request->name,
            'user_id' => Auth::id()
        ]);
        
        return redirect()->back()->with('success', 'Playlist created!');
    }

    public function removeSong(Request $request, $playlistId, $songId)
    {
        $playlist = Playlist::where('id', $playlistId)->where('user_id', Auth::id())->firstOrFail();
        $playlist->songs()->detach($songId);
        
        return redirect()->back()->with('success', 'Song removed from playlist.');
    }

    public function destroy($id)
    {
        $playlist = Playlist::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $playlist->delete();
        
        return redirect()->back()->with('success', 'Playlist removed.');
    }
}