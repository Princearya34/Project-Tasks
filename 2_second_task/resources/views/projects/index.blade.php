@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Projects List</h1>

        <a href="{{ route('projects.create') }}" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Create New Project
        </a>

        <table class="table table-bordered table-hover">
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
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->description }}</td>
                        <td>
                            @if($project->users->count() > 0)
                                @foreach($project->users as $user)
                                    <span class="badge bg-primary">{{ $user->name }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">No users assigned</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('projects.show', $project->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('projects.tasks.index', $project->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-tasks"></i>
                            </a>
                            <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal" 
                                    data-url="{{ route('projects.destroy', $project->id) }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No projects found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <a href="{{ url('/') }}" class="btn btn-secondary">
            <i class="fas fa-home"></i> Back to Home
        </a>
    </div>
@endsection

@push('scripts')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush
