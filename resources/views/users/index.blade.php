@extends('layouts.app') @section('content')
<div class="container">
    <div class="row">
        <div class="col">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session("status") }}
            </div>
            @endif
            <a href="{{ route('users.create') }}" class="btn btn-primary mb-4 mt-2">Tambah Data</a>
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
                        <!-- <td>{{ $user->role }}</td> -->
                        <td>
                            @if ($user->role == 'admin')
                            <span class="badge bg-primary">{{ $user->role }}</span>
                            @elseif ($user->role == 'operator')
                            <span class="badge bg-success">{{ $user->role }}</span>
                            @elseif ($user->role == 'borrower')
                            <span class="badge bg-info">{{ $user->role }}</span>
                            @endif
                        </td>

                        <td>{{ $user->gender }}</td>
                        <td>
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-success"><i
                                    class="fas fa-eye"></i></a>
                            <a href="{{ route('users.edit', $user->username) }}" class="btn btn-sm btn-warning"><i
                                    class="fas fa-edit"></i></a>
                            <form action="{{ route('users.destroy', $user->username) }}" method="POST" class=" d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this room?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
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