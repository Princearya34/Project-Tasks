@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Assign Role to User</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Role Assignment Form -->
    <form action="{{ route('users.assignRole', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="role" class="form-label">Select Role</label>
            <select name="role" id="role" class="form-control">
                <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ $user->hasRole('user') ? 'selected' : '' }}>User</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Assign Role</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
