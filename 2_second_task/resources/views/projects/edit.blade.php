@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
    <div class="container">
        <h1>Edit Project</h1>

        <!-- Display validation errors -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('projects.update', $project->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Project Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $project->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Project Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="4">{{ old('description', $project->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Project</button>
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back to Projects</a>
        </form>
    </div>
@endsection
