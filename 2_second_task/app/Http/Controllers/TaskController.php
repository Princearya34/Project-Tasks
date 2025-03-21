<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    /**
     * Display a list of tasks for a specific project.
     */
    public function index($projectId)
    {
        $project = Project::findOrFail($projectId);
        $tasks = $project->tasks; // Using Eloquent relationship

        return view('tasks.index', compact('tasks', 'project'));
    }

    /**
     * Show the form to create a new task for a specific project.
     */
    public function create($projectId)
    {
        $project = Project::findOrFail($projectId);
        return view('tasks.create', compact('project'));
    }

    /**
     * Store a new task under a specific project.
     */
    public function store(Request $request, $projectId) // Capture projectId from route
{
    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'status'      => 'required|in:Pending,In Progress,Completed',
    ]);

    // ✅ Explicitly setting 'project_id'
    Task::create([
        'project_id'  => $projectId, // Use route parameter
        'title'       => $request->title,
        'description' => $request->description,
        'status'      => $request->status,
    ]);

    return redirect()->route('projects.tasks.index', $projectId)
                     ->with('success', 'Task created successfully!');
}


    /**
     * Show the form to edit a task.
     */
    public function edit($projectId, $taskId)
    {
        $project = Project::findOrFail($projectId);
        $task = Task::findOrFail($taskId);

        return view('tasks.edit', compact('project', 'task'));
    }

    /**
     * Update an existing task.
     */
    public function update(Request $request, $projectId, $taskId)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:Pending,In Progress,Completed',
        ]);

        $task = Task::findOrFail($taskId);
        $task->update($request->all());

        return redirect()->route('projects.tasks.index', $projectId)
                         ->with('success', 'Task updated successfully.');
    }

    /**
     * Delete a task.
     */
    public function destroy($projectId, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->delete();

        return redirect()->route('projects.tasks.index', $projectId)
                         ->with('success', 'Task deleted successfully.');
    }

    /**
     * Fetch tasks for a specific project (API for AJAX).
     */
    public function fetchTasks(Project $project) // Using Route Model Binding
    {
        return response()->json([
            'success' => true,
            'tasks' => $project->tasks
        ]);
    }
}
