@extends('layouts.app')

@section('title', 'Task Details')

@section('content')
    <div class="container">
        <h1 class="mb-4">Task: {{ $task->title }}</h1>

        <div class="card">
            <div class="card-body">
                <p><strong>Description:</strong> {{ $task->description ?? 'No description provided.' }}</p>

                <p><strong>Project:</strong> 
                    @if ($task->project)
                        <a href="{{ route('projects.show', $task->project->id) }}">{{ $task->project->name }}</a>
                    @else
                        <span class="text-muted">No Project Assigned</span>
                    @endif
                </p>

                <p><strong>Status:</strong> 
                    <span class="badge 
                        {{ $task->status == 'Pending' ? 'bg-warning' : ($task->status == 'In Progress' ? 'bg-primary' : 'bg-success') }}">
                        {{ $task->status }}
                    </span>
                </p>
            </div>
        </div>

        <div class="mt-4">
            @if ($task->project)
                <a href="{{ route('projects.tasks.edit', ['project' => $task->project_id, 'task' => $task->id]) }}" 
                   class="btn btn-warning">Edit Task</a>

                <form action="{{ route('projects.tasks.destroy', ['project' => $task->project_id, 'task' => $task->id]) }}" 
                      method="POST" 
                      class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this task?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Task</button>
                </form>

                <a href="{{ route('projects.tasks.index', $task->project_id) }}" class="btn btn-secondary">Back to Tasks</a>
            @else
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back to Projects</a>
            @endif
        </div>
    </div>
@endsection
