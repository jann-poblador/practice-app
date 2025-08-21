<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::latest()->paginate(15);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = [
            'user' => 'Regular User',
            'admin' => 'Administrator',
            'moderator' => 'Moderator',
        ];
        
        // dd('users', $roles);

        return view('components.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,admin,moderator',
            'active' => 'boolean'
        ]);

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);

        // Handle checkbox - if not checked, it won't be in request
        $validated['active'] = $request->boolean('active');

        // dd('users', $validated);
        User::create($validated);

        return redirect()->back()
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:user,admin,moderator',
            'active' => 'boolean'
        ]);

        // Only hash password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Handle checkbox
        $validated['active'] = $request->boolean('active');

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    // public function destroy(User $user)
    // {
    //     // Prevent deleting yourself or other admins (optional safety check)
    //     if ($user->id === auth()->id()) {
    //         return redirect()->route('users.index')
    //                        ->with('error', 'You cannot delete your own account.');
    //     }

    //     $user->delete();

    //     return redirect()->route('users.index')
    //                      ->with('success', 'User deleted successfully.');
    // }

    /**
     * Toggle user active status
     */
    // public function toggleStatus(User $user)
    // {
    //     $user->update(['active' => !$user->active]);

    //     $status = $user->active ? 'activated' : 'deactivated';

    //     return redirect()->back()
    //                      ->with('success', "User {$status} successfully.");
    // }
}
