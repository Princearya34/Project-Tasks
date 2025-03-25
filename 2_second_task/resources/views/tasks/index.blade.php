@extends('layouts.app')

@section('title', 'Tasks for ' . (isset($project) ? $project->name : 'All Projects'))

@section('content')
    <div class="container">
        <h1><i class="fas fa-tasks"></i> Task List for {{ isset($project) ? $project->name : 'All Projects' }}</h1>

        @if(isset($project))
            <a href="{{ route('projects.tasks.create', $project->id) }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Create Task
            </a>
        @endif

        @if ($tasks->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No tasks found.
            </div>
        @else
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th><i class="fas fa-hashtag"></i> ID</th>
                        <th><i class="fas fa-heading"></i> Title</th>
                        <th><i class="fas fa-folder"></i> Project</th>
                        <th><i class="fas fa-check-circle"></i> Status</th>
                        <th><i class="fas fa-cogs"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td>
                                @if ($task->project)
                                    <a href="{{ route('projects.show', $task->project->id) }}" class="badge bg-primary text-white text-decoration-none">
                                        <i class="fas fa-folder"></i> {{ $task->project->name }}
                                    </a>
                                @else
                                    <span class="text-muted"><i class="fas fa-ban"></i> No Project</span>
                                @endif
                            </td>
                            <td>
                                @if($task->status === 'completed')
                                    <span class="badge bg-success"><i class="fas fa-check"></i> Completed</span>
                                @elseif($task->status === 'pending')
                                    <span class="badge bg-warning text-dark"><i class="fas fa-hourglass-half"></i> Pending</span>
                                @elseif($task->status)
                                    <span class="badge bg-info"><i class="fas fa-info-circle"></i> {{ ucfirst($task->status) }}</span>
                                @else
                                    <span class="badge bg-secondary"><i class="fas fa-question-circle"></i> No Status</span>
                                @endif
                            </td>
                            <td>
                                <!-- View Button -->
                                <a href="{{ route('projects.tasks.show', ['project' => $task->project_id, 'task' => $task->id]) }}" 
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('projects.tasks.edit', ['project' => $task->project_id, 'task' => $task->id]) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete Button -->
                                <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                        data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                        data-url="{{ route('projects.tasks.destroy', ['project' => $task->project_id, 'task' => $task->id]) }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if(isset($project))
            <a href="{{ route('projects.show', $project->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Project
            </a>
        @else
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Projects
            </a>
        @endif
    </div>
@endsection
