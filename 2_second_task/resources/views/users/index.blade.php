@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">User Management</h2>
    <div class="mb-3">
        <a href="{{ route('users.create') }}" class="btn btn-success">Create User</a>
    </div>
    <table class="table table-striped datatable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Profile Pic</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
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
                        <a href="{{ route('users.show', $user->id) }}" class="icon-btn text-primary me-2" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('users.edit', $user->id) }}" class="icon-btn text-warning me-2" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('users.assignRole', $user->id) }}" class="icon-btn text-info me-2" title="Manage Role">
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
    .icon-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px; 
        height: 40px;
        background: #f8f9fa;
        clip-path: polygon(50% 0%, 100% 38%, 82% 100%, 18% 100%, 0% 38%);
        text-decoration: none;
        color: inherit;
        transition: background 0.3s ease, transform 0.2s;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    .icon-btn:hover {
        background: #e9ecef;
        transform: scale(1.1);
    }
</style>
@endsection
