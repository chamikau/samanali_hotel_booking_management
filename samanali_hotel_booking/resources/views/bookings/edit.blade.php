<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Booking
        </h2>
    </x-slot>

    <div class="bg-white p-6 rounded shadow">

        <!-- Errors -->
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Room -->
            <div class="mb-3">
                <label class="block">Room</label>
                <select name="room_id" class="w-full border rounded px-3 py-2" required>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}"
                            {{ $booking->room_id == $room->id ? 'selected' : '' }}>
                            Room {{ $room->room_number }} ({{ $room->roomType->name ?? '' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Check-in -->
            <div class="mb-3">
                <label class="block">Check-in Date</label>
                <input type="date" name="check_in_date"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('check_in_date', $booking->check_in_date) }}" required>
            </div>

            <!-- Check-out -->
            <div class="mb-3">
                <label class="block">Check-out Date</label>
                <input type="date" name="check_out_date"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('check_out_date', $booking->check_out_date) }}" required>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label class="block">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="checked_in" {{ $booking->status == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Update Booking
            </button>

            <a href="{{ url('/bookings') }}" class="ml-2 text-gray-600">
                Back
            </a>

        </form>
    </div>

</x-app-layout>
