@extends('layouts.app') @section('content')
<div class="container">
    <div class="row">
        <div class="col">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session("status") }}
            </div>
            @endif
            <a
                href="{{ route('users.create') }}"
                class="btn btn-primary mb-4 mt-2"
                >Tambah Data</a
            >
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>User Code</th>
                        <th>Email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Level</th>
                        <th>Gender</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->first_name. ' ' . $user->last_name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->user_code }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->level }}</td>
                        <td>{{ $user->gender }}</td>
                        <td class="d-flex">
                            <a
                                href="{{ route('users.show', $user->id) }}"
                                class="btn btn-success mx-2"
                                >Show</a
                            >
                            <a
                                href="{{ route('users.edit', $user->username) }}"
                                class="btn btn-warning mx-2"
                                >Edit</a
                            >
                            <form
                                action="{{ route('users.destroy', $user->username) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this room?')"
                            >
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
