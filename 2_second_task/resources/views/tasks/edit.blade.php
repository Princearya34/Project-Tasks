@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <div class="container">
        <h1>Edit Task</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('projects.tasks.update', ['project' => $task->project_id, 'task' => $task->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Task Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                       id="title" name="title" value="{{ old('title', $task->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Task Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description">{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Task</button>
            <a href="{{ route('projects.show', $task->project_id) }}" class="btn btn-secondary">Back to Project</a>
        </form>
    </div>
@endsection
