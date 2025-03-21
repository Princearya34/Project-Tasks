@extends('layouts.app')

@section('title', $user->name . "'s Details")

@section('content')
<div class="container">
    <h2>{{ $user->name }}'s Details</h2>

    <!-- User Profile Card -->
    <div class="card mb-4" style="width: 18rem;">
        @if($user->image)
            <img src="{{ asset('storage/' . $user->image) }}" class="card-img-top profile-img" alt="User Image">
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
    <h4>Assigned Projects</h4>
    <table class="table">
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
                        <!-- View Tasks Button (Now Redirects) -->
                        <a href="{{ route('projects.tasks.index', $project->id) }}" class="btn btn-info">
                            View Tasks
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Assign New Project -->
    <h4>Assign New Project</h4>
    <form action="{{ route('users.assignProject', $user) }}" method="POST">
        @csrf
        <div class="input-group mb-3">
            <select name="project_id" class="form-control" required>
                <option value="">Select Project</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-success">Assign</button>
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
