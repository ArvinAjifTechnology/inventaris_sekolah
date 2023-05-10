@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                  <tr>
                    <th>Room Code</th>
                    <th>Room Name</th>
                    <th>Capacity</th>
                    <th>User ID</th>
                    <th>Description</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($rooms as $room)
                    <tr>
                      <td>{{ $room->room_code }}</td>
                      <td>{{ $room->room_name }}</td>
                      <td>{{ $room->capacity }}</td>
                      <td>{{ $room->user_id }}</td>
                      <td>{{ $room->description }}</td>
                      <td>
                        <div class="btn-group" role="group" aria-label="Action buttons">
                          <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-info">Show</a>
                          <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning">Edit</a>
                          <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this room?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                          </form>
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
