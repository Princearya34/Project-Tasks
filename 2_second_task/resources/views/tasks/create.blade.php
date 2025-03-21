@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
    <div class="container">
        <h1>Create Task for 
            @isset($project)
                {{ $project->name }}
            @else
                <span class="text-danger">[Project Not Found]</span>
            @endisset
        </h1>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('projects.tasks.store', $project->id ?? 0) }}" method="POST">
            @csrf

            <!-- ✅ Hidden Project ID -->
            <input type="hidden" name="project_id" value="{{ $project->id ?? '' }}">

            <!-- ✅ Task Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Task Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                       id="title" name="title" value="{{ old('title') }}" required>

                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- ✅ Task Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="4">{{ old('description') }}</textarea>

                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- ✅ Task Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>

                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- ✅ Submit & Cancel Buttons -->
            <button type="submit" class="btn btn-success">Create Task</button>

            @isset($project)
                <a href="{{ route('projects.tasks.index', $project->id) }}" class="btn btn-secondary">Cancel</a>
            @else
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back to Projects</a>
            @endisset
        </form>
    </div>
@endsection
