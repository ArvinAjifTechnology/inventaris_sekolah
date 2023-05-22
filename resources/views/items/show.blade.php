@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        Item Details
    </div>
    <div class="card-body">
        <h5 class="card-title">Item Name: {{ $item->item_name }}</h5>
        <p class="card-text">Item Code: {{ $item->item_code }}</p>
        <p class="card-text">Description: {{ $item->description }}</p>
        <p class="card-text">Condition: {{ $item->condition }}</p>
        <p class="card-text">Rental Price: {{ $item->rental_price }}</p>
        <p class="card-text">Late Fee per Day: {{ $item->late_fee_per_day }}</p>
        <p class="card-text">Quantity: {{ $item->quantity }}</p>
    </div>
</div>
@endsection