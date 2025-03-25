@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="container mt-5 text-center">
        <h1 class="mb-4 text-primary">Welcome to Laravel</h1>

        <!-- View Users Button -->
        <a href="{{ route('users.index') }}" class="btn btn-info mb-3">
            <i class="fas fa-users"></i> View Users
        </a>

        <!-- View Projects Button -->
        <a href="{{ route('projects.index') }}" class="btn btn-primary mb-3">
            <i class="fas fa-folder-open"></i> View Projects
        </a>
    </div>
@endsection
