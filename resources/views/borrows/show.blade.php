@extends('layouts.app') @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card-header">Borrow Details</div>
            <div class="card-body">
                <h5 class="card-title">
                    Borrow Code: {{ $borrow->borrow_code }}
                </h5>
                <p class="card-text">
                    Item Name: {{ $borrow->item_name }}
                </p>
                <p class="card-text">
                    Item Code: {{ $borrow->item_code }}
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
                <p class="card-text">
                    Sub Total:
                    {{ convertToRupiah($borrow->sub_total) }}
                </p>
            </div>
            <div class="card-footer">
                @if($borrow->borrow_status==='completed')
                <button type="submit" class="btn btn-success" disabled>
                    Selesai
                </button>
                @else @can('admin')
                <a href="{{ url('/admin/borrows/'. $borrow->id . '/edit') }}" class="btn btn-primary">Edit</a>
                <form action="{{ url('/admin/borrows/'. $borrow->id. '/return') }}" method="POST"
                    style="display: inline-block">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-primary" type="submit">
                        Return
                    </button>
                </form>
                @endcan @can('operator')
                <a href="{{ url('/operator/borrows/'. $borrow->id . '/edit') }}" class="btn btn-primary">Edit</a>
                <form action="{{ url('/operator/borrows/'. $borrow->id. '/return') }}" method="POST"
                    style="display: inline-block">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-primary" type="submit">
                        Return
                    </button>
                </form>
                @endcan @endif{{--
                <form action="{{ route('/admin/borrows/', $borrow->id) }}" method="POST" style="display: inline-block">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        Delete
                    </button>
                </form>
                --}}
            </div>
        </div>
    </div>
</div>
</div>
@endsection