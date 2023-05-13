@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form method="POST" action="{{ route('borrows.store') }}" class="">
                @csrf
                <div class="form-group">
                    <label for="borrow_code">Borrow Code</label>
                    <input type="text" id="borrow_code" name="borrow_code" class="form-control @error('borrow_code') is-invalid @enderror" value="{{ old('borrow_code') }}" required>
                    @error('borrow_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="item_id">Item</label>
                    <select id="item_id" name="item_id" class="form-control @error('item_id') is-invalid @enderror">
                        <option value="">Pilih Item</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>{{ $item->item_name }}</option>
                        @endforeach
                    </select>
                    @error('item_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="user_id">User</label>
                    <select id="user_id" name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                        <option value="">Pilih User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->full_name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="borrow_date">Borrow Date</label>
                    <input type="datetime-local" id="borrow_date" name="borrow_date" class="form-control @error('borrow_date') is-invalid @enderror" value="{{ old('borrow_date') }}" required>
                    @error('borrow_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="return_date">Return Date</label>
                    <input type="datetime-local" id="return_date" name="return_date" class="form-control @error('return_date') is-invalid @enderror" value="{{ old('return_date') }}" required>
                    @error('return_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="borrow_status">Status</label>
                    <select id="borrow_status" name="borrow_status" class="form-control @error('borrow_status') is-invalid @enderror">
                        <option value="">Pilih Status</option>
                        <option value="tersedia" {{ old('borrow_status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="dipinjam" {{ old('borrow_status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    </select>
                    @error('borrow_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-4">Submit</button>
            </form>

        </div>
    </div>
</div>
@endsection
