@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary fw-bold">Projects List</h1>
            <a href="{{ route('projects.create') }}" class="btn btn-success shadow-sm">
                <i class="fas fa-plus me-1"></i> Create New Project
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover rounded shadow">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Assigned Users</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td>{{ $project->id }}</td>
                            <td class="fw-bold">{{ $project->name }}</td>
                            <td>{{ Str::limit($project->description, 50) }}</td>
                            <td>
                                @if($project->users->count() > 0)
                                    @foreach($project->users as $user)
                                        <span class="badge bg-primary fade-in">{{ $user->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No users assigned</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('projects.show', $project->id) }}" class="btn btn-info btn-sm animated-icon">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning btn-sm animated-icon">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('projects.tasks.index', $project->id) }}" class="btn btn-primary btn-sm animated-icon">
                                    <i class="fas fa-tasks"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm animated-icon delete-btn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal" 
                                        data-url="{{ route('projects.destroy', $project->id) }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No projects found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <a href="{{ url('/') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-home"></i> Back to Home
        </a>
    </div>
@endsection

<!-- Custom Styling -->
<style>
    .table th, .table td {
        text-align: center;
        vertical-align: middle;
    }

    .btn {
        font-size: 14px;
        padding: 8px 16px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .animated-icon i {
        transition: transform 0.3s ease;
    }

    .animated-icon:hover i {
        transform: rotate(15deg);
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Hover effect on table rows */
    tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 10px;
    }
</style>
