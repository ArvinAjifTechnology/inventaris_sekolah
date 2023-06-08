@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center d-flex align-content-center" style="height: 100vh;">
        <div class="col-md-12">
            <a href="{{ url('/borrower/borrows/create/search-item') }}" class="btn btn-primary btn-sm mb-2">Ajukan
                Peminjaman</a>
            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
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
                        <td>{{ $borrow->item_name }}</td>
                        <td>{{ $borrow->full_name }}</td>
                        <td>{{ $borrow->borrow_code }}</td>
                        <td>{{ $borrow->borrow_date }}</td>
                        <td>{{ $borrow->return_date }}</td>
                        <td>{{ $borrow->borrow_quantity }}</td>
                        <td>
                            @if($borrow->borrow_status == 'completed')
                            <span class="badge bg-success">Selesai</span>
                            @elseif($borrow->borrow_status == 'pending')
                            <span class="badge bg-warning">Belum Di Verifikasi</span>
                            @else
                            <span class="badge bg-primary">Di Pinjam</span>
                            @endif
                        </td>
                        <td>
                            @can('admin')
                            <a href="{{ url('/admin/borrows', $borrow->id) }}" class="btn btn-info"><i
                                    class="fas fa-eye"></i></a>
                            @endcan
                            @can('operator')
                            <a href="{{ url('/operator/borrows', $borrow->id) }}" class="btn btn-info"><i
                                    class="fas fa-eye"></i></a>
                            @endcan
                            @can('borrower')
                            <a href="{{ url('/borrower/borrows', $borrow->id) }}" class="btn btn-info"><i
                                    class="fas fa-eye"></i></a>
                            @endcan
                            @if($borrow->borrow_status == 'completed')
                            <button class="btn btn-success" disabled>
                                Selesai
                            </button>
                            @else
                            @can('admin')
                            <a href="{{ url('/admin/borrows/'.$borrow->id.'/edit') }}" class="btn btn-primary"><i
                                    class="fas fa-edit"></i></a>
                            @endcan
                            @can('operator')
                            <a href="{{ url('/operator/borrows/'.$borrow->id.'/edit') }}" class="btn btn-primary"><i
                                    class="fas fa-edit"></i></a>
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
                                    <i class="fas fa-undo"></i>
                                </button>
                            </form>
                            @endcan
                            @can('operator')
                            <form action="{{ url('/operator/borrows/'. $borrow->id. '/return') }}" method="POST"
                                style="display: inline-block">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-undo"></i>
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
