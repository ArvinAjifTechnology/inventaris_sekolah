@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit Profile</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" />
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control" name="username" value="{{ $user->username }}" />
                        </div>
                        <div class="mb-3">
                            <label for="user_code" class="form-label">User Code:</label>
                            <input type="text" class="form-control" name="user_code" value="{{ $user->user_code }}" />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" name="email" value="{{ $user->email }}" />
                        </div>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name:</label>
                            <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" />
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name:</label>
                            <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" />
                        </div>
                        <!-- <div class="mb-3">
                      <label for="role" class="form-label">Role:</label>
                      <select class="form-select" name="role">
                        <option value="admin" @if ($user->role === 'admin') selected @endif>Admin</option>
                        <option value="operator" @if ($user->role === 'operator') selected @endif>Operator</option>
                        <option value="borrower" @if ($user->role === 'borrower') selected @endif>Borrower</option>
                      </select>
                    </div> -->
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender:</label>
                            <select class="form-select" name="gender">
                                <option value="laki-laki" @if ($user->gender === 'laki-laki') selected @endif>Laki-laki
                                </option>
                                <option value="perempuan" @if ($user->gender === 'perempuan') selected @endif>Perempuan
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
{{-- <h1>Edit Profile</h1>
<form action="{{ route('profile.update') }}" method="POST">
    @csrf @method('PUT')
    <label for="name">Name:</label>
    <input type="text" name="name" value="{{ $user->name }}" /><br />
    <label for="username">Username:</label>
    <input type="text" name="username" value="{{ $user->username }}" /><br />
    <label for="user_code">User Code:</label>
    <input type="text" name="user_code" value="{{ $user->user_code }}" /><br />
    <label for="email">Email:</label>
    <input type="email" name="email" value="{{ $user->email }}" /><br />
    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" value="{{ $user->first_name }}" /><br />
    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" value="{{ $user->last_name }}" /><br />
    {{-- <label for="role">Role:</label> --}}
    {{--<select name="role">
        <option value="admin" @if ($user->
            role === 'admin') selected @endif>Admin
        </option>
        <option value="operator" @if ($user->
            role === 'operator') selected @endif>Operator
        </option>
        <option value="borrower" @if ($user->
            role === 'borrower') selected @endif>Borrower
        </option></select--}}
    {{-- ><br />
    <label for="gender">Gender:</label>
    <select name="gender">
        <option value="laki-laki" @if ($user->
            gender === 'laki-laki') selected @endif>Laki-laki
        </option>
        <option value="perempuan" @if ($user->
            gender === 'perempuan') selected @endif>Perempuan
        </option>
    </select><br />
    <button type="submit">Update</button>
</form> --}}
@endsection