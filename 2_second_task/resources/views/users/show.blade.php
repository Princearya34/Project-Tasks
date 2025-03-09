@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User Details</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>

    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>

    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
    </form>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection

