<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $regularUsers = User::where('role', 'user')->count();
        $adminUsers = User::where('role', 'admin')->count();
        $totalNotes = Note::count();
        $recentNotes = Note::with('user')
                           ->latest()
                           ->take(10)
                           ->get();

        return view('admin.dashboard', compact('regularUsers', 'adminUsers', 'totalNotes', 'recentNotes'));
    }

    public function users()
    {
        $users = User::where('role', '!=', 'super_admin')->get();
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return redirect()->route('admin.users')->with('success', 'User updated successfully');
    }

    public function deleteUser(User $user)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403);
        }
        
        $user->notes()->delete();
        $user->delete();
        
        return redirect()->route('admin.users')->with('success', 'User and all associated notes deleted successfully');
    }

    public function adminDashboard()
    {
        $regularUsers = User::where('role', 'user')->count();
        $totalNotes = Note::count();
        $recentNotes = Note::with('user')
                           ->latest()
                           ->take(10)
                           ->get();

        return view('admin.admin-dashboard', compact('regularUsers', 'totalNotes', 'recentNotes'));
    }

    public function showNote(Note $note)
    {
        abort_if(!auth()->user()->isAdmin() && !auth()->user()->isSuperAdmin(), 403);
        
        return view('admin.notes.show', compact('note'));
    }

    public function userNotes(User $user)
    {
        abort_if(!auth()->user()->isAdmin() && !auth()->user()->isSuperAdmin(), 403);
        
        $notes = $user->notes()->latest()->get();
        return view('admin.users.notes', compact('user', 'notes'));
    }
} 