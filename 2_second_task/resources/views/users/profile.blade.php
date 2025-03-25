@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm p-4">
        <h2 class="mb-4">{{ $user->name }}'s Profile</h2>

        <div class="text-center mb-4">
            <img src="{{ asset($user->image ? 'storage/'.$user->image : 'images/default-avatar.png') }}" 
                 class="rounded-circle border" width="120" height="120" alt="User Avatar">
        </div>

        <h3 class="mb-3">Assigned Projects</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Project Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user->projects as $project)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $project->name }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm view-tasks-btn" data-bs-toggle="collapse" 
                                        data-bs-target="#tasks-{{ $project->id }}">
                                    View Tasks
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="collapse" id="tasks-{{ $project->id }}">
                                    <div class="card card-body">
                                        <h5 class="mb-3">Tasks for {{ $project->name }}</h5>
                                        <table class="table table-hover">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Task Title</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($project->tasks as $task)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><strong>{{ $task->title }}</strong></td>
                                                        <td>{{ $task->description }}</td>
                                                        <td>
                                                            @if($task->status === 'pending')
                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                            @elseif($task->status === 'in_progress')
                                                                <span class="badge bg-primary">In Progress</span>
                                                            @elseif($task->status === 'completed')
                                                                <span class="badge bg-success">Completed</span>
                                                            @else
                                                                <span class="badge bg-secondary">{{ ucfirst($task->status) }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted">No tasks assigned to this project.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">No projects assigned.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript (Ensure Bootstrap is included in your layout) -->
<script>
    document.querySelectorAll('.view-tasks-btn').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-bs-target');
            const targetElement = document.querySelector(targetId);
            targetElement.classList.toggle('show');
        });
    });
</script>
@endsection
