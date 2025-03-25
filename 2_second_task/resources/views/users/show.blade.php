@extends('layouts.app')

@section('title', $user->name . "'s Details")

@section('content')
<div class="container">
    <h2 class="mb-4">{{ $user->name }}'s Details</h2>

    <!-- User Profile Card -->
    <div class="card mb-4 shadow-sm" style="width: 18rem;">
        @if($user->image && Storage::disk('public')->exists($user->image))
            <img src="{{ asset('storage/' . $user->image) }}" class="card-img-top profile-img" alt="{{ $user->name }}">
        @else
            <img src="{{ asset('images/default-avatar.png') }}" class="card-img-top profile-img" alt="Default Avatar">
        @endif
        <div class="card-body text-center">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Phone:</strong> {{ $user->phone }}</p>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <!-- Assigned Projects -->
    <h4 class="mb-3">Assigned Projects</h4>

    @if($user->projects->count())
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Project Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user->projects as $project)
                    <tr>
                        <td>{{ $project->name }}</td>
                        <td>
                            <!-- View Project -->
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-folder-open"></i> View Project
                            </a>

                            <!-- View Tasks -->
                            <a href="{{ route('projects.tasks.index', $project) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-tasks"></i> View Tasks
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">No projects assigned yet.</p>
    @endif

    <!-- Assign New Project -->
    <h4 class="mt-4">Assign New Project</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.assignProject', $user) }}" method="POST">
        @csrf
        <div class="input-group mb-3">
            <select name="project_id" class="form-control" required>
                <option value="">Select Project</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Assign</button>
        </div>
    </form>
</div>

<!-- Custom Styles -->
<style>
    .profile-img {
        width: 100%; 
        height: 250px; 
        object-fit: cover;
        border-radius: 0;
    }
</style>

@endsection
