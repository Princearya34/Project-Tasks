@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User List</h2>

    <!-- Create New User Button -->
    <a href="{{ route('users.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> Create New User
    </a>

    <!-- User Table -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Profile Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
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
                    @if($user->roles->isNotEmpty())
                        <span class="badge bg-primary">{{ ucfirst($user->roles->first()->name) }}</span>
                    @else
                        <span class="badge bg-secondary">No Role</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="{{ route('users.showAssignRole', $user->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-user-shield"></i>
                    </a>
                    <button type="button" class="btn btn-danger btn-sm delete-btn" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteModal" 
                            data-url="{{ route('users.destroy', $user->id) }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
