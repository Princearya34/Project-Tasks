@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- User Details Section -->
        <div class="col-md-4">
            <div class="card shadow-lg p-4 text-center bg-light text-dark border border-secondary">
                <img src="{{ asset($user->image ? 'storage/'.$user->image : 'images/default-avatar.png') }}" 
                     class="rounded-circle border border-dark mx-auto d-block mb-3" width="120" height="120" alt="User Avatar">
                <h4 class="text-dark fw-bold">{{ $user->name }}</h4>
                <p class="text-muted">
                    <i class="fas fa-envelope text-primary"></i> {{ $user->email }}
                </p>
                <p class="text-muted">
                    <i class="fas fa-phone text-success"></i> {{ $user->phone ?? 'No phone number available' }}
                </p>
            </div>
        </div>

        <!-- Assigned Projects Section -->
        <div class="col-md-8">
            <div class="card shadow-lg p-4 border-light bg-white text-dark">
                <h3 class="mb-3 text-dark"><i class="fas fa-project-diagram"></i> Assigned Projects</h3>
                <div class="accordion" id="projectsAccordion">
                    @forelse($user->projects as $project)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-{{ $project->id }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $project->id }}">
                                    <i class="fas fa-folder me-2"></i> {{ $project->name }}
                                </button>
                            </h2>
                            <div id="collapse-{{ $project->id }}" class="accordion-collapse collapse" data-bs-parent="#projectsAccordion">
                                <div class="accordion-body">
                                    <h5 class="mb-3 text-dark"><i class="fas fa-tasks"></i> Tasks for {{ $project->name }}</h5>
                                    <div class="list-group">
                                        @forelse($project->tasks as $task)
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1 text-dark"><i class="fas fa-thumbtack text-primary"></i> {{ $task->title }}</h6>
                                                    <p class="mb-1 text-muted">{{ $task->description }}</p>
                                                </div>
                                                <span class="badge {{ $task->status === 'Pending' ? 'bg-warning' : ($task->status === 'In Progress' ? 'bg-info' : 'bg-success') }}">
                                                    {{ ucfirst($task->status) }}
                                                </span>
                                            </div>
                                        @empty
                                            <p class="text-center text-muted">No tasks assigned to this project.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No projects assigned.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
