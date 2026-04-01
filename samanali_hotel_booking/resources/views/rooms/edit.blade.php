<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Room
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

        <form action="{{ route('rooms.update', $room->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="block">Room Number</label>
                <input type="text" name="room_number"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('room_number', $room->room_number) }}" required>
            </div>

            <div class="mb-3">
                <label class="block">Room Type</label>
                <select name="room_type_id" class="w-full border rounded px-3 py-2">
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}"
                            {{ $room->room_type_id == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block">Floor</label>
                <input type="number" name="floor"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('floor', $room->floor) }}">
            </div>

            <div class="mb-3">
                <label class="block">Price</label>
                <input type="number" name="price"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('price', $room->price) }}">
            </div>

            <div class="mb-3">
                <label class="block">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="reserved" {{ $room->status == 'reserved' ? 'selected' : '' }}>Reserved</option>
                    <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                </select>
            </div>

            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Update
            </button>

            <a href="{{ url('/rooms') }}" class="ml-2 text-gray-600">
                Back
            </a>

        </form>
    </div>

</x-app-layout>
