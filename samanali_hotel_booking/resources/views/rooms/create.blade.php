@extends('layouts.app')

@section('content')

    <form action="{{ route('rooms.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Room Number</label>
            <input type="text" name="room_number" class="form-control">
        </div>

        <div class="mb-3">
            <label>Room Type</label>
            <select name="room_type_id" class="form-control">
                @foreach($roomTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Floor</label>
            <input type="number" name="floor" class="form-control">
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control">
        </div>

        <button class="btn btn-success">Save</button>
    </form>

@endsection
