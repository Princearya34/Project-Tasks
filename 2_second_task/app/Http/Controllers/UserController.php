<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $users = User::latest()->paginate($perPage);
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        $projects = Project::all();
        $assignedProjects = $user->projects;
        return view('users.show', compact('user', 'projects', 'assignedProjects'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => ['required', 'regex:/^[a-zA-Z]+(?: [a-zA-Z]+)*$/', 'min:3'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'phone'    => ['required', 'digits:10', 'unique:users,phone'],
            'password' => ['required', 'min:6'],
            'image'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('user_images', 'public');
            $validatedData['image'] = $imagePath;  // Save path in DB
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
            'name'     => ['required', 'regex:/^[a-zA-Z]+(?: [a-zA-Z]+)*$/', 'min:3'],
            'email'    => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone'    => ['required', 'digits:10', 'unique:users,phone,' . $user->id],
            'password' => ['nullable', 'min:6'],
            'image'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $imagePath = $request->file('image')->store('user_images', 'public');
            $validatedData['image'] = $imagePath;  // Save new path in DB
        }

        // Hash password if provided
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
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
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        // Delete user
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function assignProject(Request $request, User $user)
    {
        $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
        ]);

        if (!$user->projects->contains($request->project_id)) {
            $user->projects()->attach($request->project_id);
            return redirect()->back()->with('success', 'Project assigned successfully!');
        }

        return redirect()->back()->with('info', 'Project is already assigned to the user.');
    }
}
