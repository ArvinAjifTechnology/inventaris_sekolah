@extends('layouts.app') @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session("status") }}
            </div>
            @endif
            @can('admin')
            <a href="{{ url('/admin/borrows/create') }}" class="btn btn-primary btn-sm mb-2">Tambah Data Peminjam an</a>
            @endcan
            @can('operator')
            <a href="{{ url('/operator/borrows/create') }}" class="btn btn-primary btn-sm mb-2">Tambah Data Peminjam an</a>
            @endcan
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
                            @can('admin')
                            <a href="{{ url('/admin/borrows', $borrow->id) }}" class="btn btn-info">Show</a>
                            @endcan
                            @can('operator')
                            <a href="{{ url('/operator/borrows', $borrow->id) }}" class="btn btn-info">Show</a>
                            @endcan
                            @can('borrower')
                            <a href="{{ url('/borrower/borrows', $borrow->id) }}" class="btn btn-info">Show</a>
                            @endcan
                            @if($borrow->borrow_status == 'selesai')
                            <button class="btn btn-success" disabled>
                                Selesai
                            </button>
                            @else
                            @can('admin')
                            <a href="{{ url('/admin/borrows/'.$borrow->id.'/edit') }}" class="btn btn-primary">Edit</a>
                            @endcan
                            @can('operator')
                            <a href="{{ url('/operator/borrows/'.$borrow->id.'/edit') }}"
                                class="btn btn-primary">Edit</a>
                            @endcan
                            {{-- <form action="{{ url('/admin/borrows/destroy', $borrow->id) }}" method="POST"
                                style="display: inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    Delete
                                </button>
                            </form> --}}
                            @can('admin')
                            <form action="{{ url('/admin/borrows/'. $borrow->id. '/return') }}" method="POST"
                                style="display: inline-block">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-primary" type="submit">
                                    Return
                                </button>
                            </form>
                            @endcan
                            @can('operator')
                            <form action="{{ url('/operator/borrows/'. $borrow->id. '/return') }}" method="POST"
                                style="display: inline-block">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-primary" type="submit">
                                    Return
                                </button>
                            </form>
                            @endcan
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
