@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Role Details</h2>

    <div class="card">
        <div class="card-body">
            <h4><strong>Role:</strong> {{ $role->name }}</h4>
            <h5 class="mt-3"><strong>Permissions:</strong></h5>
            
            @if($role->permissions->isNotEmpty())
                <ul class="list-group">
                    @foreach($role->permissions as $permission)
                        <li class="list-group-item">{{ $permission->name }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">No permissions assigned to this role.</p>
            @endif

            <a href="{{ route('roles.index') }}" class="btn btn-secondary mt-3">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>

<!-- Include Font Awesome for icons -->
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endpush

@endsection
