@extends('layouts.app') @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('borrows.create') }}" class="btn btn-primary btn-sm mb-2">Tambah Data Peminjaman</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Item Name</th>
                        <th>Item Code</th>
                        <th>Nama Peminjam</th>
                        <th>Borrow Code</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Jumlah Di Pinjam</th>
                        <th>Borrow Status</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrows as $borrow)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $borrow->item->item_name }}</td>
                        <td>{{ $borrow->item->item_code }}</td>
                        <td>{{ $borrow->user->full_name }}</td>
                        <td>{{ $borrow->borrow_code }}</td>
                        <td>{{ $borrow->borrow_date }}</td>
                        <td>{{ $borrow->return_date }}</td>
                        <td>{{ $borrow->borrow_quantity }}</td>
                        <td>{{ $borrow->borrow_status }}</td>
                        <td>
                            {{-- @if (!$borrow->borrow_status)
                            <form action="{{ route('borrows.return', $borrow->id) }}" method="POST">
                                @csrf @method('PUT')
                                <button type="submit" class="btn btn-sm btn-success">
                                    Return
                                </button>
                            </form>
                            @endif --}}

                            @if($borrow->borrow_status == 'selesai')
                            <button class="btn btn-success" disabled>Selesai</button>
                            @else
                            <form action="{{ route('borrows.return', $borrow->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-primary" type="submit">Return</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection