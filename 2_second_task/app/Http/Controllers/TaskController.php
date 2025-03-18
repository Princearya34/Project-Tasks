<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    /**
     * Display a list of tasks (filtered by project if needed).
     */
    public function index(Request $request)
    {
        $query = Task::with('project');

        if ($request->has('project')) {
            $query->where('project_id', $request->project);
        }

        $tasks = $query->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form to create a new task for a given project.
     */
    public function create($projectId)
    {
        $project = Project::findOrFail($projectId); // Ensure project exists
        return view('tasks.create', compact('project'));
    }

    /**
     * Store a new task under a specific project.
     */
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'nullable|in:Pending,In Progress,Completed',
        ]);

        $project = Project::findOrFail($projectId); // Ensure project exists

        $project->tasks()->create([
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => $request->status ?? 'Pending', // Default to 'Pending'
        ]);

        return redirect()->route('projects.show', $project->id)
                         ->with('success', 'Task added successfully!');
    }

    /**
     * Show the form to edit a task under a specific project.
     */
    public function edit($projectId, $taskId)
    {
        $project = Project::findOrFail($projectId); // Ensure project exists
        $task = Task::findOrFail($taskId); // Ensure task exists

        return view('tasks.edit', compact('project', 'task'));
    }

    /**
     * Update an existing task under a project.
     */
    public function update(Request $request, $projectId, $taskId)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = Task::findOrFail($taskId);
        $task->update([
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('projects.show', $projectId)
                         ->with('success', 'Task updated successfully.');
    }

    /**
     * Delete a task under a specific project.
     */
    public function destroy($projectId, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->delete();

        return redirect()->route('projects.show', $projectId)
                         ->with('success', 'Task deleted successfully.');
    }

    /**
     * Update task status.
     */
    public function updateStatus(Request $request, $projectId, $taskId)
    {
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $task = Task::findOrFail($taskId);
        $task->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Task status updated!');
    }
}
