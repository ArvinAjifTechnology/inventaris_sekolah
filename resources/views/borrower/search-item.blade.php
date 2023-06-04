@extends('layouts.app')

@section('content')
<!-- resources/views/item-report/index.blade.php -->
<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('borrower.borrow.search-item') }}" method="post" class="card-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-10 mb-3">
                            <input type="text" id="search" name="search" class="form-control"
                                placeholder="Cari Nama Barang ..." value="{{ old('search') }}" />
                        </div>
                        <div class="col-md-2 my-0">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Cari Barang</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<div class="container">
    <div class="row">
        <div class="col">
            @if (!empty($items))
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th>Kode Item</th>
                        <th>Nama Barang</th>
                        <th>Nama Ruangan</th>
                        <th>Description</th>
                        <th>condition</th>
                        <th>Harga Pinjam</th>
                        <th>Harga Denda/ Hari</th>
                        <th>Jumlah Stok</th>
                        <th>Action</th>
                        <!-- Tambahkan field lainnya sesuai dengan struktur tabel "items" -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->item_code }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->room_name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->condition }}</td>
                        <td>{{ convertToRupiah($item->rental_price) }}</td>
                        <td>{{ convertToRupiah($item->late_fee_per_day) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>
                            <a href="{{ url('/borrower/borrows/create/'.$item->item_code.'/submit-borrow-request') }}"
                                class="btn btn-primary"> Ajukan
                                Peminjaman</a>
                        </td>
                        <!-- Tambahkan field lainnya sesuai dengan struktur tabel "items" -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>Tidak ada data peminjaman yang ditemukan.</p>
            @endif
        </div>
    </div>
</div>
@endsection
