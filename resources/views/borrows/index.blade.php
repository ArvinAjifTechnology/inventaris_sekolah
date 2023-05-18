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
                        <th>Nama Peminjam</th>
                        <th>Borrow Code</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Jumlah Di Pinjam</th>
                        <th>Borrow Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrows as $borrow)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $borrow->item->item_name }}</td>
                        <td>{{ $borrow->user->full_name }}</td>
                        <td>{{ $borrow->borrow_code }}</td>
                        <td>{{ $borrow->borrow_date }}</td>
                        <td>{{ $borrow->return_date }}</td>
                        <td>{{ $borrow->borrow_quantity }}</td>
                        <td>
                            @if($borrow->borrow_status == 'selesai')
                            <span class="badge bg-success">Selesai</span>
                            @else
                            <span class="badge bg-primary">Di Pinjam</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('borrows.show', $borrow->id) }}" class="btn btn-info">Show</a>
                            @if($borrow->borrow_status == 'selesai')
                            <button class="btn btn-success" disabled>
                                Selesai
                            </button>
                            @else
                            <a href="{{ route('borrows.edit', $borrow->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('borrows.destroy', $borrow->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            <form action="{{ route('borrows.return', $borrow->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('PUT')
                                @if (Carbon\Carbon::parse($borrow->borrow_date)->diffInDays(Carbon\Carbon::now()) == 0)
                                <button class="btn btn-primary" type="submit">
                                    Return
                                </button>
                                @else
                                <button class="btn btn-primary" type="submit">
                                    Return
                                </button>
                                @endif
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