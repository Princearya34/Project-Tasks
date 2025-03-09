@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit User</h2>
        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
            </div>

            <div class="form-group">
                <label>Upload New Image:</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            @if ($user->image)
                <div class="form-group">
                    <label>Current Image:</label>
                    <img src="{{ asset('storage/' . $user->image) }}" alt="User  Image" style="width: 100px; height: auto;">
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
@endsection