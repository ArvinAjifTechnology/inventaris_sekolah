@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form method="POST" action="{{ route('rooms.update', $room[0]->id) }}" class="">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="form-group">
                    <label for="room_code">Room Code</label>
                    <input type="text" id="room_code" name="room_code"
                        class="form-control @error('room_code') is-invalid @enderror"
                        value="{{ old('room_code', $room[0]->room_code ?? '') }}" required>
                    @error('room_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="room_name">Room Name</label>
                    <input type="text" id="room_name" name="room_name"
                        class="form-control @error('room_name') is-invalid @enderror"
                        value="{{ old('room_name', $room[0]->room_name ?? '') }}" required>
                    @error('room_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="capacity">Capacity</label>
                    <input type="text" id="capacity" name="capacity"
                        class="form-control @error('capacity') is-invalid @enderror"
                        value="{{ old('capacity', $room[0]->capacity ?? '') }}" required>
                    @error('capacity')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="user_id">User ID</label>
                    <select id="user_id" name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                        <option value="">Pilih User</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $room[0]->user_id ?? '') == $user->id ?
                            'selected' : '' }}>{{ $user->full_name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"
                        class="form-control @error('description') is-invalid @enderror"
                        rows="3">{{ old('description', $room[0]->description ?? '') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-4">Submit</button>
            </form>

        </div>
    </div>
</div>
@endsection