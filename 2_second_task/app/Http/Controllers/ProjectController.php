<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index()
    {
        $projects = Project::with('users')->get(); // Eager load users for efficiency
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Project::create($request->only(['name', 'description']));

        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        $project->load('users'); // Load assigned users
        $users = User::all(); // Get all users for assignment

        return view('projects.show', compact('project', 'users'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update($request->only(['name', 'description']));

        return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
    }

    /**
     * Assign a user to the project.
     */
    public function assignUser(Request $request, Project $project)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Assign user without removing existing users
        $project->users()->syncWithoutDetaching([$request->user_id]);

        return redirect()->route('projects.show', $project->id)
                         ->with('success', 'User assigned successfully!');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        $project->tasks()->delete(); // Delete related tasks
        $project->users()->detach(); // Detach users from project
        $project->delete(); // Delete project itself

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully!');
    }
}
