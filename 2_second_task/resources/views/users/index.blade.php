@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User List</h1>

    @if(session('success'))
        <div class="alert alert-success fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('users.create') }}" class="btn btn-success mb-3">Create New User</a>

    <table id="usersTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>
                        @if($user->image)
                            <img src="{{ asset('storage/' . $user->image) }}" class="rounded-circle" width="50" height="50" alt="User Image">
                        @else
                            <img src="{{ asset('default-avatar.png') }}" class="rounded-circle" width="50" height="50" alt="Default Avatar">
                        @endif
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">Show</a>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        
                        <!-- Delete Button -->
                        <button type="button" class="btn btn-danger btn-sm deleteUser" 
                                data-userid="{{ $user->id }}" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery Script -->
<script>
    $(document).ready(function () {
        // Initialize DataTable
        $('#usersTable').DataTable();

        // Handle Delete Button Click
        $('.deleteUser').click(function () {
            var userId = $(this).data('userid');
            var actionUrl = "{{ url('users') }}/" + userId;

            // Set form action dynamically
            $('#deleteForm').attr('action', actionUrl);
        });
    });
</script>

@endsection
