@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <h1>Welcome to Laravel</h1>
    <a href="{{ route('users.index') }}">View Users</a>
@endsection
