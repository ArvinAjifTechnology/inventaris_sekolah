@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center d-flex align-content-center" style="height: 100vh;">
        <div class="col-lg-6">
                @can('admin')
                <form method="POST" action="{{ url('admin/items') }}" class="">
                @endcan
                @can('operator')
                <form method="POST" action="{{ url('operator/items') }}" class="">
                    @endcan
                    @csrf
                    <!-- <div class="form-group">
                    <label for="item_code">Item Code</label>
                    <input type="text" id="item_code" name="item_code"
                        class="form-control @error('item_code') is-invalid @enderror" value="{{ old('item_code') }}"
                        required>
                    @error('item_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> -->
                    <div class="form-group">
                        <label for="item_name">Item Name</label>
                        <input type="text" id="item_name" name="item_name"
                            class="form-control @error('item_name') is-invalid @enderror" value="{{ old('item_name') }}"
                            required>
                        @error('item_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="room_id">Room ID</label>
                        <select id="room_id" name="room_id" class="form-control @error('room_id') is-invalid @enderror select2" data-toggle="select2">
                            <option value="">Pilih Room</option>
                            @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id')==$room->id ? 'selected' : '' }}>{{
                                $room->room_name }}</option>
                            @endforeach
                        </select>
                        @error('room_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description"
                            class="form-control @error('description') is-invalid @enderror"
                            rows="3">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="condition">Condition</label>
                        <select id="condition" name="condition"
                            class="form-control @error('condition') is-invalid @enderror select2" data-toggle="select2">
                            <option value="">Pilih Condition</option>
                            <option value="good" {{ old('condition')=='good' ? 'selected' : '' }}>Baik</option>
                            <option value="fair" {{ old('condition')=='fair' ? 'selected' : '' }}>Sedang</option>
                            <option value="bad" {{ old('condition')=='bad' ? 'selected' : '' }}>Rusak</option>
                        </select>
                        @error('condition')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                    </div>
                    <div class="form-group">
                        <label for="rental_price">Harga Pinjam</label>
                        <input type="number" id="rental_price" name="rental_price"
                            class="form-control @error('rental_price') is-invalid @enderror"
                            value="{{ old('rental_price') }}" required>
                        @error('rental_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="late_fee_per_day">Denda/Hari</label>
                        <input type="number" id="late_fee_per_day" name="late_fee_per_day"
                            class="form-control @error('late_fee_per_day') is-invalid @enderror"
                            value="{{ old('late_fee_per_day') }}" required>
                        @error('late_fee_per_day')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <label for="quantity">Jumlah</label>
                    <input type="text" id="quantity" name="quantity" data-toggle="touchspin"
                        class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}"
                        required>
                    @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary mt-4">Submit</button>
        </div>
        </form>

    </div>
</div>
</div>
@endsection
