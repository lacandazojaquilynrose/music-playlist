<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Display users list
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        
        // Count total platform users so dashboard layout template doesn't break
        $userCount = User::count();
        
        return view('users.index', compact('users', 'userCount'));
    }

    // Add User Action
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User added successfully!');
    }

    // Edit User Action
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $request->validate(['password' => 'nullable|string|min:6']);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    // Delete User Action
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Using explicit user instantiation protects IDE type checking
        if (Auth::check() && $user->id === Auth::user()->id) {
            return redirect()->route('users.index')->with('error', 'Cannot delete your own active session!');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}