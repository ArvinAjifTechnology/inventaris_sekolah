@extends('layouts.main') @section('content')
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            @can('admin')
            <a href="{{ route('rooms.create') }}" class="btn btn-primary mb-2">Tambah Data</a>
            @endcan
            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Room Code</th>
                        <th>Room Name</th>
                        <th>Penanggung Jawab</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $room->room_code }}</td>
                        <td>{{ $room->room_name }}</td>
                        <td>{{ $room->user_name }}</td>
                        <td>{{ $room->description }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Action buttons mx-2">
                                @can('operator')
                                <a href="{{ url('operator/rooms', $room->id) }}" class="btn btn-info mx-2">Show</a>
                                @endcan
                                @can('admin')
                                <a href="{{ url('admin/rooms', $room->id) }}" class="btn btn-info mx-2">Show</a>
                                <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning mx-2">Edit</a>
                                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this room?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        Delete
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
