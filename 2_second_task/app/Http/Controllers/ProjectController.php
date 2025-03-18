<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('users')->get(); // Eager load users
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Project::create($request->only(['name', 'description']));

        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }

    public function show(Project $project)
    {
        $project->load('users'); // Load assigned users
        $users = User::all();
        return view('projects.show', compact('project', 'users'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update($request->only(['name', 'description']));

        return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
    }

    public function assignUser(Request $request, Project $project)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $project->users()->sync([$request->user_id]); // Ensures no duplicate assignments

        return redirect()->route('projects.show', $project->id)->with('success', 'User assigned successfully!');
    }

    public function destroy(Project $project)
    {
        $project->tasks()->delete(); // Delete related tasks
        $project->users()->detach(); // Detach users from project
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully!');
    }
}
