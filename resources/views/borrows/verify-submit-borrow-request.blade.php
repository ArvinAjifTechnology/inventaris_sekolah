@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            @can('admin')
            <form method="POST"
                action="{{ url('/admin/borrows/'. $borrow->borrow_code.'/verify-submit-borrow-request') }}" class="">
                @endcan
                @can('operator')
                <form method="POST"
                    action="{{ url('/operator/borrows/'. $borrow->borrow_code.'/verify-submit-borrow-request') }}"
                    class="">
                    @endcan
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="borrow_code" value="{{ $borrow->borrow_code }}">
                    <div class="form-group">
                        <label for="item_id">Item</label>
                        <input type="text" id="item_id" class="form-control"
                            value="{{ $borrow->item_name . '-' . $borrow->item_code }}">
                    </div>
                    <div class="form-group">
                        <label for="user_id">User</label>
                        <input type="text" id="user_id" class="form-control" value="{{ $borrow->full_name }}">
                    </div>
                    <input type="hidden" name="item_id" value="{{ $borrow->item_id }}">
                    <input type="hidden" name="user_id" value="{{ $borrow->user_id }}">
                    <div class="form-group">
                        <label for="borrow_date">Borrow Date</label>
                        <input type="date" id="borrow_date" name="borrow_date"
                            class="form-control @error('borrow_date') is-invalid @enderror"
                            value="{{ old('borrow_date', date('Y-m-d', strtotime($borrow->borrow_date))) }}"
                            min="{{ date('Y-m-d') }}" required>
                        @error('borrow_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="return_date">Return Date</label>
                        <input type="date" id="return_date" name="return_date"
                            class="form-control @error('return_date') is-invalid @enderror"
                            value="{{ old('return_date', date('Y-m-d', strtotime($borrow->return_date))) }}"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        @error('return_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="borrow_quantity">Jumlah Pinjam</label>
                        <input type="text" id="borrow_quantity" name="borrow_quantity"
                            class="form-control @error('borrow_quantity') is-invalid @enderror"
                            value="{{ old('borrow_quantity', $borrow->borrow_quantity) }}" required>
                        @error('borrow_quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Verifikasi Peminjaman</button>
                </form>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("form").on("submit", function() {
            updateProgressBar(3);
        });
    });
</script>
@endsection
