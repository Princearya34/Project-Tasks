<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Get the number of users per page (default to 10 if not provided)
        $perPage = $request->input('per_page', 10);
        $users = User::latest()->paginate($perPage);

        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'  => ['required', 'regex:/^[a-zA-Z_]+( [a-zA-Z_]+)+$/', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'digits:10', 'unique:users,phone'],
            'password' => ['required', 'min:6'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('user_images', 'public');
        }

        // Hash password
        $validatedData['password'] = Hash::make($request->password);

        // Create user
        User::create($validatedData);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name'  => ['required', 'regex:/^[a-zA-Z_]+( [a-zA-Z_]+)+$/', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'digits:10', 'unique:users,phone,' . $user->id],
            'password' => ['nullable', 'min:6'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $validatedData['image'] = $request->file('image')->store('user_images', 'public');
        }

        // Hash password if provided
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        // Update user
        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        // Delete image if exists
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        // Delete user
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
