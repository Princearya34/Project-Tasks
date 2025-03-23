@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User List</h2>

    <!-- Create New User Button -->
    <a href="{{ route('users.create') }}" class="btn btn-success mb-3">Create New User</a>

    <!-- Bootstrap Toast for Success Message -->
    @if(session('success'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        {{ session()->forget('success') }} <!-- Clear session message -->
    @endif

    <!-- User Table -->
    <table id="userTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Profile Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>
                    <a href="{{ route('users.show', $user->id) }}">
                        @if($user->image && Storage::disk('public')->exists($user->image))
                            <img src="{{ asset('storage/' . $user->image) }}" class="rounded-circle" width="50" height="50">
                        @else
                            <img src="{{ asset('images/default-avatar.png') }}" class="rounded-circle" width="50" height="50">
                        @endif
                    </a>
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>
                    <!-- View Button -->
                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> <!-- Font Awesome View Icon -->
                    </a>

                    <!-- Edit Button -->
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> <!-- Font Awesome Edit Icon -->
                    </a>

                    <!-- Delete Button -->
                    <button type="button" class="btn btn-danger deleteUser" data-bs-toggle="modal" data-bs-target="#deleteModal" data-userid="{{ $user->id }}">
                        <i class="fas fa-trash"></i> <!-- Font Awesome Delete Icon -->
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Font Awesome CDN (For Icons) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- DataTables & jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        // Initialize DataTable
        $('#userTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [5, 10, 25, 50, 100], 
            "pageLength": 5,        
        });

        // Handle Delete Button Click (Set Correct Form Action)
        $('.deleteUser').click(function () {
            var userId = $(this).data('userid');
            var actionUrl = "{{ url('users') }}/" + userId;
            $('#deleteForm').attr('action', actionUrl);
        });

        // Show toast notification properly
        let successToast = $('#successToast');
        if (successToast.length) {
            let toast = new bootstrap.Toast(successToast[0]);
            toast.show();

            // Auto-hide toast after 3 seconds
            setTimeout(() => {
                toast.hide();
            }, 3000);
        }
    });
</script>
@endpush
@endsection
