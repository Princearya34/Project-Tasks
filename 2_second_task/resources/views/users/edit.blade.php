@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit User</h2>

    {{-- Display Validation Errors Only --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input 
                type="text" 
                class="form-control @error('name') is-invalid @enderror" 
                name="name" 
                id="name" 
                value="{{ old('name', $user->name) }}" 
                required
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input 
                type="email" 
                class="form-control @error('email') is-invalid @enderror" 
                name="email" 
                id="email" 
                value="{{ old('email', $user->email) }}" 
                required
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
