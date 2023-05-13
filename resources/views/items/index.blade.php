@extends('layouts.app') @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session("status") }}
            </div>
            @endif
            <a href="{{ route('items.create') }}" class="btn btn-primary mb-2"
                >Tambah Data</a
            >
            <table class="table table-success">
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
                        <td>{{ $item->condition }}</td>
                        <td>{{ $item->amount }}</td>
                        <td>
                            <a
                                href="{{ route('items.show', $item->id) }}"
                                class="btn btn-sm btn-primary"
                                >View</a
                            >
                            <a
                                href="{{ route('items.edit', $item->id) }}"
                                class="btn btn-sm btn-warning"
                                >Edit</a
                            >
                            <form
                                action="{{ route('items.destroy', $item->id) }}"
                                method="POST"
                                style="display: inline-block"
                            >
                                @csrf @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this item?')"
                                >
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
