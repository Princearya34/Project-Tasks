<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users with pagination.
     */
    public function index()
{
    $users = User::with('roles')->orderBy('created_at', 'desc')->get(); // Use get() instead of paginate()

    return view('users.index', compact('users'));
}


    /**
     * Display the specified user along with unassigned projects.
     */
    public function show(User $user)
    {
        $assignedProjectIds = $user->projects()->pluck('projects.id')->toArray();
        $projects = Project::whereNotIn('id', $assignedProjectIds)->get();

        return view('users.show', compact('user', 'projects'));
    }

    public function profile()
{
    $user = auth()->user()->load('projects.tasks'); // Load projects along with their tasks

    // Get all tasks from assigned projects
    $tasks = $user->projects->flatMap->tasks; 

    return view('users.profile', compact('user', 'tasks'));
}

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => ['required', 'regex:/^[a-zA-Z\s]+$/', 'min:3'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'phone'    => ['required', 'digits:10', 'unique:users,phone'],
            'password' => ['required', 'min:6'],
            'image'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('user_images', 'public');
        }

        $validatedData['password'] = Hash::make($request->password);
        User::create($validatedData);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name'     => ['required', 'regex:/^[a-zA-Z\s]+$/', 'min:3'],
            'email'    => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone'    => ['required', 'digits:10', 'unique:users,phone,' . $user->id],
            'password' => ['nullable', 'min:6'],
            'image'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $validatedData['image'] = $request->file('image')->store('user_images', 'public');
        }

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    /**
     * Assign a project to the user.
     */
    public function assignProject(Request $request, User $user)
    {
        $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
        ]);

        $user->load('projects');
        $user->projects()->syncWithoutDetaching([$request->project_id]);

        return redirect()->back()->with('success', 'Project assigned successfully!');
    }

    /**
     * Show the role assignment form.
     */
    public function showAssignRole(User $user)
    {
        $roles = Role::all();
        return view('users.assign-role', compact('user', 'roles'));
    }

    /**
     * Assign a role to the user.
     */
    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'Role assigned successfully!');
    }
}
