@extends('layouts.app')

@section('title', 'Task Details')

@section('content')
    <div class="container">
        <h1>{{ $task->title }}</h1>
        <p><strong>Project:</strong> {{ $task->project->name }}</p>
        <p><strong>Description:</strong> {{ $task->description }}</p>
        <p>
            <strong>Status:</strong> 
            <span class="badge 
                {{ $task->status == 'Pending' ? 'bg-warning' : 
                   ($task->status == 'In Progress' ? 'bg-primary' : 'bg-success') }}">
                {{ $task->status }}
            </span>
        </p>

        <a href="{{ route('tasks.index') }}" class="btn btn-outline-primary">Back to Tasks</a>
        <a href="{{ route('projects.show', $task->project_id) }}" class="btn btn-outline-secondary">Back to Project</a>
    </div>
@endsection
