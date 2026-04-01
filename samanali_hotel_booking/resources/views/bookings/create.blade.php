<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Booking
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

        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf

            <!-- Room -->
            <div class="mb-3">
                <label class="block">Room</label>
                <select name="room_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Select Room --</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}">
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
                       value="{{ old('check_in_date') }}" required>
            </div>

            <!-- Check-out -->
            <div class="mb-3">
                <label class="block">Check-out Date</label>
                <input type="date" name="check_out_date"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('check_out_date') }}" required>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label class="block">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="confirmed">Confirmed</option>
                    <option value="pending">Pending</option>
                </select>
            </div>

            <button class="bg-green-500 text-white px-4 py-2 rounded">
                Create Booking
            </button>

                <a href="{{ url('/bookings') }}" class="ml-2 text-gray-600">
                Back
            </a>

        </form>
    </div>

</x-app-layout>
