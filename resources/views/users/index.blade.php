@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session("status") }}
            </div>
            @endif
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-4 mt-2">Tambah Data</a>
            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
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
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-success"><i
                                    class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.users.edit', $user->username) }}" class="btn btn-sm btn-warning"><i
                                    class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Are you sure you want to reset the password for this User?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-key"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.users.destroy', $user->username) }}" method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this User ?')">
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
