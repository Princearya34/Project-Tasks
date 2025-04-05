@extends('layouts.app')

@section('content')
<div class="container custom-container">
    <h2 class="mb-3">User Management</h2>
    <div class="mb-3">
        <a href="{{ route('users.create') }}" class="btn btn-success">Create User</a>
    </div>
    <table class="table table-striped datatable">
        <thead>
            <tr>
                <th data-column="0" class="sortable">ID <span class="sort-arrow">↑↓</span></th>
                <th>Profile Pic</th>
                <th data-column="2" class="sortable">Name <span class="sort-arrow">↑↓</span></th>
                <th data-column="3" class="sortable">Email <span class="sort-arrow">↑↓</span></th>
                <th data-column="4" class="sortable">Phone <span class="sort-arrow">↑↓</span></th>
                <th data-column="5" class="sortable">Role <span class="sort-arrow">↑↓</span></th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                @if ($user->id !== Auth::id()) <!-- Hide logged-in user -->
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        @if($user->image && Storage::disk('public')->exists($user->image))
                            <img src="{{ asset('storage/' . $user->image) }}" class="rounded-circle border shadow-sm" width="50" height="50">
                        @else
                            <img src="{{ asset('images/default-avatar.png') }}" class="rounded-circle border shadow-sm" width="50" height="50">
                        @endif
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        @if($user->roles->isNotEmpty())
                            <span class="badge bg-primary">{{ ucfirst($user->roles->first()->name) }}</span>
                        @else
                            <span class="badge bg-secondary">No Role</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('users.show', $user->id) }}" class="icon-btn text-primary" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('users.edit', $user->id) }}" class="icon-btn text-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('users.assignRole', $user->id) }}" class="icon-btn text-info" title="Manage Role">
                            <i class="fas fa-user-shield"></i>
                        </a>
                        <button class="icon-btn text-danger border-0 bg-transparent delete-btn" data-url="{{ route('users.destroy', $user->id) }}" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>

<style>
    /* Background and shadow effect */
    body {
        background-color: #f5f5f5;
    }

    .custom-container {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
        margin-top: 20px;
    }

    /* Icon button adjustments */
    .icon-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 35px; 
        height: 35px;
        text-decoration: none;
        color: inherit;
        transition: background 0.3s ease, transform 0.2s;
        border: 1px solid #ccc;
        font-size: 14px;
        margin-right: 5px;
        border-radius: 6px;
    }

    .icon-btn:hover {
        background: #e9ecef;
        transform: scale(1.1);
    }

    /* Custom sorting arrows */
    .sortable {
        cursor: pointer;
    }

    .sort-arrow {
        font-size: 14px;
        margin-left: 5px;
        color: #555;
    }
</style>

<script>
    $(document).ready(function() {
        let table = $('.datatable').DataTable({
            "order": [],
            "columnDefs": [
                { "orderable": false, "targets": [1, 6] } // Disable sorting on Profile Pic & Actions columns
            ]
        });

        $('.sortable').on('click', function() {
            let columnIndex = $(this).data('column');
            let currentOrder = table.order();

            if (currentOrder.length && currentOrder[0][0] == columnIndex) {
                let newDirection = currentOrder[0][1] === 'asc' ? 'desc' : 'asc';
                table.order([columnIndex, newDirection]).draw();
            } else {
                table.order([columnIndex, 'asc']).draw();
            }
        });
    });
</script>
@endsection
