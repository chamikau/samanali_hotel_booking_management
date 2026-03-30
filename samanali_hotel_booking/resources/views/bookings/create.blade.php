@extends('layouts.app')

@section('content')

    <h3>Create Booking</h3>

    <!-- ✅ Show Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf

        <!-- 🛏️ Select Room -->
        <div class="mb-3">
            <label class="form-label">Room</label>
            <select name="room_id" class="form-control" required>
                <option value="">-- Select Room --</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">
                        Room {{ $room->room_number }} ({{ $room->roomType->name }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- 📅 Check-in Date -->
        <div class="mb-3">
            <label class="form-label">Check-in Date</label>
            <input type="date" name="check_in_date" class="form-control" required>
        </div>

        <!-- 📅 Check-out Date -->
        <div class="mb-3">
            <label class="form-label">Check-out Date</label>
            <input type="date" name="check_out_date" class="form-control" required>
        </div>

        <!-- 💰 Submit -->
        <button type="submit" class="btn btn-success">Create Booking</button>
        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Back</a>
    </form>

@endsection
