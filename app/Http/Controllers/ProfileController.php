<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show() { 
        return view('profile.show', ['user' => Auth::user()]); 
    }

    public function update(Request $request) {
        $user = User::findOrFail(Auth::id());
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) Storage::disk('public')->delete($user->profile_picture);
            $user->profile_picture = $request->file('profile_picture')->store('profiles', 'public');
        }

        $user->update($request->only('name', 'email'));
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request) {
        $request->validate(['current_password' => 'required', 'password' => 'required|confirmed|min:8']);
        $user = User::findOrFail(Auth::id());
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Incorrect password.']);
        }
        
        $user->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password updated successfully!');
    }

    public function destroy() {
        $user = User::findOrFail(Auth::id());
        Auth::logout();
        $user->delete();
        return redirect('/')->with('success', 'Account deleted.');
    }
}