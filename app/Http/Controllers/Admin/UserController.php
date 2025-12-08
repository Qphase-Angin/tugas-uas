<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Display all users
    public function index(Request $request)
    {
        $query = User::select('id', 'nama', 'email', 'image', 'is_active', 'role_id', 'alamat', 'created_at');

        // Apply filters if present
        $query->when($request->filled('id'), fn($q) => $q->where('id', $request->id));
        $query->when($request->filled('nama'), fn($q) => $q->where('nama', 'like', '%'.$request->nama.'%'));
        $query->when($request->filled('email'), fn($q) => $q->where('email', 'like', '%'.$request->email.'%'));
        $query->when($request->filled('role_id'), fn($q) => $q->where('role_id', $request->role_id));
        $query->when($request->filled('is_active'), fn($q) => $q->where('is_active', $request->is_active));
        $query->when($request->filled('alamat'), fn($q) => $q->where('alamat', 'like', '%'.$request->alamat.'%'));

        // Global search
        $query->when($request->filled('search'), function($q) use ($request) {
            $search = $request->search;
            return $q->where(function($subQ) use ($search) {
                $subQ->where('nama', 'like', '%'.$search.'%')
                      ->orWhere('email', 'like', '%'.$search.'%')
                      ->orWhere('alamat', 'like', '%'.$search.'%');
            });
        });

        // Sort by column (default: id asc)
        $sortCol = in_array($request->query('sort'), ['id', 'nama', 'email', 'role_id', 'is_active', 'alamat']) ? $request->query('sort') : 'id';
        $order = strtolower($request->query('order')) === 'desc' ? 'desc' : 'asc';
        $query->orderBy($sortCol, $order);

        // Per page
        $perPage = in_array((int)$request->query('per_page'), [10, 25, 50, 100]) ? (int)$request->query('per_page') : 10;
        $users = $query->paginate($perPage)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    // Display active users (monitoring) - users that are currently active
    public function active(Request $request)
    {
        $query = User::select('id', 'nama', 'email', 'image', 'is_active', 'role_id', 'alamat', 'created_at');

        // By default show only active users, but allow overriding via the is_active GET param
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        } else {
            $query->where('is_active', true);
        }

        // Allow additional filters on active list
        $query->when($request->filled('id'), fn($q) => $q->where('id', $request->id));
        $query->when($request->filled('nama'), fn($q) => $q->where('nama', 'like', '%'.$request->nama.'%'));
        $query->when($request->filled('email'), fn($q) => $q->where('email', 'like', '%'.$request->email.'%'));
        $query->when($request->filled('role_id'), fn($q) => $q->where('role_id', $request->role_id));
        $query->when($request->filled('alamat'), fn($q) => $q->where('alamat', 'like', '%'.$request->alamat.'%'));

        // Global search
        $query->when($request->filled('search'), function($q) use ($request) {
            $search = $request->search;
            return $q->where(function($subQ) use ($search) {
                $subQ->where('nama', 'like', '%'.$search.'%')
                      ->orWhere('email', 'like', '%'.$search.'%')
                      ->orWhere('alamat', 'like', '%'.$search.'%');
            });
        });

        // Sort by column (default: id asc)
        $sortCol = in_array($request->query('sort'), ['id', 'nama', 'email', 'role_id', 'alamat', 'is_active']) ? $request->query('sort') : 'id';
        $order = strtolower($request->query('order')) === 'desc' ? 'desc' : 'asc';
        $query->orderBy($sortCol, $order);

        // Per page
        $perPage = in_array((int)$request->query('per_page'), [10, 25, 50, 100]) ? (int)$request->query('per_page') : 10;
        $users = $query->paginate($perPage)->withQueryString();

        return view('admin.users.active', compact('users'));
    }

    // Show user details
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    // Show create form
    public function create()
    {
        return view('admin.users.create');
    }

    // Store new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'alamat' => 'nullable|string|max:255',
            'role_id' => 'required|in:1,2',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['is_active'] = $request->has('is_active') ? true : false;

        User::create($validated);
        return redirect()->route('admin.users.index')->with('success', 'New user added successfully.');
    }

    // Show edit form
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'alamat' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'role_id' => 'required|in:1,2',
        ]);

        // Ensure role_id is applied when updating user
        $user->update($validated);
        return redirect()->route('admin.users.show', $user)->with('success', 'User updated successfully.');
    }

    // Activate user
    public function activate(User $user)
    {
        $user->update(['is_active' => true]);
        return redirect()->route('admin.users.active')->with('success', 'User ' . $user->nama . ' activated successfully.');
    }

    // Deactivate user
    public function deactivate(User $user)
    {
        $user->update(['is_active' => false]);
        return redirect()->route('admin.users.index')->with('success', 'User ' . $user->nama . ' deactivated successfully.');
    }

    // Destroy user
    public function destroy(User $user)
    {
        // optionally delete user image
        if ($user->image && $user->image !== 'profil-pic/default.jpg') {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }
}
