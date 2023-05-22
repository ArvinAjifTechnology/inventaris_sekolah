@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $user->name }}</h5>
        <p class="card-text">Username: {{ $user->username }}</p>
        <p class="card-text">User Code: {{ $user->user_code }}</p>
        <p class="card-text">Email: {{ $user->email }}</p>
        <p class="card-text">First Name: {{ $user->first_name }}</p>
        <p class="card-text">Last Name: {{ $user->last_name }}</p>
        <p class="card-text">Role: {{ $user->role }}</p>
        <p class="card-text">Gender: {{ $user->gender }}</p>
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
    </div>
</div>
@endsection