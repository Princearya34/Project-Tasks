@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-3"><i class="fas fa-folder"></i> {{ $project->name }}</h1>
        <p><strong>Description:</strong> {{ $project->description }}</p>

        <!-- Assigned Users -->
        <h3><i class="fas fa-users"></i> Assigned Users</h3>
        @if($project->users->isEmpty())
            <p class="text-muted">No users assigned yet.</p>
        @else
            <ul class="list-group mb-3">
                @foreach ($project->users as $user)
                    <li class="list-group-item"><i class="fas fa-user"></i> {{ $user->name }}</li>
                @endforeach
            </ul>
        @endif

        <!-- Assign User Form -->
        <form action="{{ route('projects.assignUser', $project->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="user_id" class="form-label">Assign User</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <option value="" disabled selected>Select a user</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Assign</button>
        </form>

        <hr>

        <!-- Project Tasks -->
        <h3><i class="fas fa-tasks"></i> Project Tasks</h3>
        @if($project->tasks->isEmpty())
            <p class="text-muted">No tasks added yet.</p>
        @else
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($project->tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td>
                                <span class="badge {{ $task->status === 'Pending' ? 'bg-warning' : ($task->status === 'In Progress' ? 'bg-primary' : 'bg-success') }}">
                                    {{ $task->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('projects.tasks.show', [$project->id, $task->id]) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('projects.tasks.edit', [$project->id, $task->id]) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger delete-btn" data-action="{{ route('projects.tasks.destroy', [$project->id, $task->id]) }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Add Task Button -->
        <a href="{{ route('projects.tasks.create', $project->id) }}" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Add Task
        </a>

        <hr>

        <!-- Edit & Delete Buttons -->
        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <button class="btn btn-danger delete-btn" data-action="{{ route('projects.destroy', $project->id) }}">
            <i class="fas fa-trash"></i> Delete
        </button>

        <hr>

        <!-- Navigation Buttons -->
        <a href="{{ route('projects.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Back to Projects
        </a>
        <a href="{{ url('/') }}" class="btn btn-outline-secondary">
            <i class="fas fa-home"></i> Home
        </a>
    </div>
@endsection
