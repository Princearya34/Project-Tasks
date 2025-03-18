@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4 text-primary">Welcome to Laravel</h1>

        <a href="{{ route('users.index') }}" class="btn btn-primary mb-3">View Users</a>

        <h2 class="mb-3">Projects List</h2>

        @if($projects->isEmpty())
            <div class="alert alert-warning">No projects found.</div>
        @else
            <div class="list-group">
                @foreach($projects as $project)
                    <a href="{{ route('projects.show', $project->id) }}" class="list-group-item list-group-item-action">
                        {{ $project->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <a href="{{ route('projects.create') }}" class="btn btn-success mt-3">Create New Project</a>
    </div>
@endsection
