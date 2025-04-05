@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Role Management</h2>

    <!-- Create Role Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Role Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Permissions</label><br>
                    @foreach($permissions as $permission)
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-check-input">
                            <label class="form-check-label">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Create Role</button>
            </form>
        </div>
    </div>

    <!-- Role List -->
    <div class="card">
        <div class="card-body">
            <h4>Existing Roles</h4>
            <table class="table table-bordered mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>
                            <a href="{{ route('roles.show', $role->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> <!-- Show Role -->
                            </a>
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> <!-- Edit Role -->
                            </a>
                            <button type="button" class="btn btn-danger btn-sm delete-role" 
                                data-role-id="{{ $role->id }}" data-role-name="{{ $role->name }}"
                                data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash"></i> <!-- Delete Role -->
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Include Font Awesome for icons -->
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endpush

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the role <strong id="roleName"></strong>?
            </div>
            <div class="modal-footer">
                <form id="deleteRoleForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Script -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-role').forEach(button => {
            button.addEventListener('click', function () {
                let roleId = this.getAttribute('data-role-id');
                let roleName = this.getAttribute('data-role-name');
                let form = document.getElementById('deleteRoleForm');

                // Update the modal text with role name
                document.getElementById('roleName').textContent = roleName;

                // Set correct action for DELETE request
                form.setAttribute('action', `/admin/roles/${roleId}`);
            });
        });
    });
</script>
@endpush

@endsection
