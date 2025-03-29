@extends('layouts.app')

@section('title', 'Tasks for ' . (isset($project) ? $project->name : 'All Projects'))

@section('content')
    <div class="container">
        <h1 class="mb-4">
            <i class="fas fa-tasks text-primary"></i> Task List for {{ isset($project) ? $project->name : 'All Projects' }}
        </h1>

        @if(isset($project))
            <a href="{{ route('projects.tasks.create', $project->id) }}" class="btn btn-success mb-3 shadow-sm btn-animate">
                <i class="fas fa-plus"></i> Create Task
            </a>
        @endif

        @if ($tasks->isEmpty())
            <div class="alert alert-info d-flex align-items-center">
                <i class="fas fa-info-circle me-2"></i> No tasks found.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Project</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->title }}</td>
                                <td>
                                    @if ($task->project)
                                        <a href="{{ route('projects.show', $task->project->id) }}" 
                                           class="badge bg-primary text-white text-decoration-none shadow-sm">
                                            <i class="fas fa-folder"></i> {{ $task->project->name }}
                                        </a>
                                    @else
                                        <span class="text-muted"><i class="fas fa-ban"></i> No Project</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge 
                                        {{ $task->status === 'Pending' ? 'bg-warning' : ($task->status === 'In Progress' ? 'bg-primary' : 'bg-success') }}">
                                        {{ $task->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('projects.tasks.show', ['project' => $task->project_id, 'task' => $task->id]) }}" 
                                       class="btn btn-info btn-sm action-btn">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('projects.tasks.edit', ['project' => $task->project_id, 'task' => $task->id]) }}" 
                                       class="btn btn-warning btn-sm action-btn">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm delete-btn action-btn" 
                                            data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                            data-url="{{ route('projects.tasks.destroy', ['project' => $task->project_id, 'task' => $task->id]) }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if(isset($project))
            <a href="{{ route('projects.show', $project->id) }}" class="btn btn-secondary shadow-sm btn-animate">
                <i class="fas fa-arrow-left"></i> Back to Project
            </a>
        @else
            <a href="{{ route('projects.index') }}" class="btn btn-secondary shadow-sm btn-animate">
                <i class="fas fa-arrow-left"></i> Back to Projects
            </a>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-trash"></i> Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this task? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Delete Button -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function () {
                    let url = this.getAttribute('data-url');
                    document.getElementById('deleteForm').setAttribute('action', url);
                });
            });
        });
    </script>

    <style>
        .btn-animate {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .btn-animate:hover {
            transform: scale(1.05);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .action-btn {
            transition: transform 0.2s ease-in-out;
        }
        .action-btn:hover {
            transform: scale(1.2);
        }
    </style>
@endsection
