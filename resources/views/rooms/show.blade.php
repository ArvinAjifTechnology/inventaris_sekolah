@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Room Details
                </div>
                <div class="card-body">
                    <h5 class="card-title">Room Name: {{ $room->room_name }}</h5>
                    <p class="card-text">Room Code: {{ $room->room_code }}</p>
                    <p class="card-text">Description: {{ $room->description }}</p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    Items in the Room
                </div>
                <div class="card-body">
                    @if ($room->items->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>Description</th>
                                <th>Condition</th>
                                <th>Rental Price</th>
                                <th>Late Fee per Day</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($room->items as $item)
                            <tr>
                                <td>{{ $item->item_code }}</td>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->condition }}</td>
                                <td>{{ $item->rental_price }}</td>
                                <td>{{ $item->late_fee_per_day }}</td>
                                <td>{{ $item->quantity }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>No items found in this room.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection