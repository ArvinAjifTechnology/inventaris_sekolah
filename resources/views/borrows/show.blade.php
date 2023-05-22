@extends('layouts.app') @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Borrow Details</div>
                <div class="card-body">
                    <h5 class="card-title">
                        Borrow Code: {{ $borrow->borrow_code }}
                    </h5>
                    <p class="card-text">
                        Item Name: {{ $borrow->item->item_name }}
                    </p>
                    <p class="card-text">
                        Item Code: {{ $borrow->item->item_code }}
                    </p>
                    <p class="card-text">
                        Borrow Date: {{ $borrow->borrow_date }}
                    </p>
                    <p class="card-text">
                        Return Date: {{ $borrow->return_date }}
                    </p>
                    <p class="card-text">
                        Borrow Quantity: {{ $borrow->borrow_quantity }}
                    </p>
                    <p class="card-text">
                        Borrow Status: {{ $borrow->borrow_status }}
                    </p>
                    <p class="card-text">
                        Late Fee: {{ convertToRupiah($borrow->late_fee) }}
                    </p>
                    <p class="card-text">
                        Total Rental Price:
                        {{ convertToRupiah($borrow->total_rental_price) }}
                    </p>
                </div>
                <div class="card-footer">
                    @if($borrow->borrow_status==='selesai')
                    <button type="submit" class="btn btn-success" disabled>
                        Selesai
                    </button>
                    @else
                    @can('admin')
                    <a href="{{ url('/admin/borrows/'. $borrow->id . '/edit') }}" class="btn btn-primary">Edit</a>
                    @endcan
                    @can('operator')
                    <a href="{{ url('/operator/borrows/'. $borrow->id . '/edit') }}" class="btn btn-primary">Edit</a>
                    @endcan
                    @endif
                    {{-- <form action="{{ route('/admin/borrows/', $borrow->id) }}" method="POST"
                        style="display: inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            Delete
                        </button>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection