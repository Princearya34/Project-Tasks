@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
    <div class="container">
        <h1>Task List</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Project</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->project->name ?? 'No Project' }}</td>
                        <td>
                            <a href="{{ route('projects.tasks.edit', [$task->project_id, $task->id]) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('projects.tasks.update', ['project' => $task->project_id, 'task' => $task->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="title" value="{{ $task->title }}">
                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            </form>

                            <!-- Delete Button with Modal Trigger -->
                            <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal" 
                                    data-url="{{ route('projects.tasks.destroy', [$task->project_id, $task->id]) }}">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bootstrap Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this task? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var deleteForm = document.getElementById("deleteForm");

        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function () {
                var deleteUrl = this.getAttribute("data-url"); // Get delete URL
                deleteForm.setAttribute("action", deleteUrl); // Set form action dynamically
            });
        });
    });
</script>
@endsection
