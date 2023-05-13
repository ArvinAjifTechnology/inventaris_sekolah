@extends('layouts.app') @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a
                href="{{ route('borrows.create') }}"
                class="btn btn-primary btn-sm mb-2"
                >Tambah Data Peminjaman</a
            >
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item ID</th>
                        <th>User ID</th>
                        <th>Borrow Code</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Borrow Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrows as $borrow)
                    <tr>
                        <td>{{ $borrow->item_id }}</td>
                        <td>{{ $borrow->user_id }}</td>
                        <td>{{ $borrow->borrow_code }}</td>
                        <td>{{ $borrow->borrow_date }}</td>
                        <td>{{ $borrow->return_date }}</td>
                        <td>{{ $borrow->borrow_status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
