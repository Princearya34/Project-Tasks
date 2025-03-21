@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Projects List</h1>

        <a href="{{ route('projects.create') }}" class="btn btn-success mb-3">Create New Project</a>

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
                            <a href="{{ route('projects.show', $project->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('projects.tasks.index', $project->id) }}" class="btn btn-primary btn-sm">Manage Tasks</a> <!-- ✅ FIXED -->

                            <!-- Delete Button with Modal Trigger -->
                            <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal" 
                                    data-url="{{ route('projects.destroy', $project->id) }}">
                                Delete
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

        <a href="{{ url('/') }}" class="btn btn-secondary">Back to Home</a>
    </div>
@endsection
