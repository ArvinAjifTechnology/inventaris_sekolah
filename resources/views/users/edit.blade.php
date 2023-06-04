@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form method="POST" action="{{ route('admin.users.update', $user[0]->username) }}" class="">
                @csrf
                @method('PUT')
                @include('users.form')
                <button type="submit" class="btn btn-primary mt-4">Submit</button>
            </form>

        </div>
    </div>
</div>
@endsection
