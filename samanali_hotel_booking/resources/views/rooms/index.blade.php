@extends('layouts.app')

@section('content')

    <a href="{{ route('rooms.create') }}" class="btn btn-primary mb-3">Add Room</a>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Room No</th>
            <th>Type</th>
            <th>Floor</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rooms as $room)
            <tr>
                <td>{{ $room->room_number }}</td>
                <td>{{ $room->roomType->name }}</td>
                <td>{{ $room->floor }}</td>
                <td>{{ $room->status }}</td>
                <td>
                    <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
