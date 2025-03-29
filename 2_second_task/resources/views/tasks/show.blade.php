@extends('layouts.app')

@section('title', 'Task Details')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4 text-primary">Task: {{ $task->title }}</h1>

        <!-- Task Details Card -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Task Information</h5>
                
                <p><strong>Description:</strong> {{ $task->description ?? 'No description provided.' }}</p>

                <p><strong>Project:</strong> 
                    @if ($task->project)
                        <a href="{{ route('projects.show', $task->project->id) }}" class="text-primary">{{ $task->project->name }}</a>
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

        <!-- Action Buttons -->
        <div class="mt-4 d-flex justify-content-start gap-3">
            @if ($task->project)
                <a href="{{ route('projects.tasks.edit', ['project' => $task->project_id, 'task' => $task->id]) }}" 
                   class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit Task
                </a>

                <form action="{{ route('projects.tasks.destroy', ['project' => $task->project_id, 'task' => $task->id]) }}" 
                      method="POST" 
                      class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this task?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Delete Task
                    </button>
                </form>

                <a href="{{ route('projects.tasks.index', $task->project_id) }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to Tasks
                </a>
            @else
                <a href="{{ route('projects.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to Projects
                </a>
            @endif
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .card {
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .card-body {
            padding: 1.5rem;
        }

        .badge.bg-warning { background-color: #ffc107 !important; }
        .badge.bg-primary { background-color: #007bff !important; }
        .badge.bg-success { background-color: #28a745 !important; }

        .btn-sm {
            font-size: 14px;
            padding: 5px 15px;
        }

        .btn-warning {
            color: #fff;
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-secondary {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn i {
            margin-right: 5px;
        }

        .text-primary {
            color: #007bff !important;
        }
    </style>
@endsection
