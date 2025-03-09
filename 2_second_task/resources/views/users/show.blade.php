@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Details</h1>
    <div class="card" style="width: 18rem;">
        @if($user->image)
            <img src="{{ asset('storage/' . $user->image) }}" class="card-img-top profile-img" alt="User Image">
        @else
            <img src="{{ asset('default-avatar.png') }}" class="card-img-top profile-img" alt="Default Avatar">
        @endif
        <div class="card-body text-center">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>

<style>
    .profile-img {
        width: 100%; 
        height: 250px; /* Adjust height as needed */
        object-fit: cover;
        border-radius: 0; /* Makes the image square */
    }
</style>
@endsection
