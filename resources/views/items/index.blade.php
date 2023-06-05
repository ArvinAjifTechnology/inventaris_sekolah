@extends('layouts.main') @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @can('admin')
            <a href="{{ url('/admin/items/create') }}" class="btn btn-primary mb-2">Tambah Data</a>
            @endcan
            @can('operator')
            <a href="{{ url('/operator/items/create') }}" class="btn btn-primary mb-2">Tambah Data</a>
            @endcan

            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100"">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Room</th>
                        <th>Description</th>
                        <th>Condition</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->item_code }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->room_name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ ucfirst($item->condition)}}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>
                            @can('admin')

                            <a href=" {{ url('/admin/items', $item->id) }}" class="btn btn-sm btn-primary">View</a>
                <a href="{{ url('admin/items/'. $item->id.'/edit') }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ url('/admin/items/'. $item->id) }}" method="POST" style="display: inline-block">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure you want to delete this item?')">
                        Delete
                    </button>
                </form>
                @endcan
                @can('operator')
                <a href="{{ route('items.show', $item->id) }}" class="btn btn-sm btn-primary">View</a>
                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display: inline-block">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure you want to delete this item?')">
                        Delete
                    </button>
                </form>
                @endcan
                </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
