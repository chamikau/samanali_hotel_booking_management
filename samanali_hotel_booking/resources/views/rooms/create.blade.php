<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Room
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

        <form action="{{ route('rooms.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="block">Room Number</label>
                <input type="text" name="room_number"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('room_number') }}" required>
            </div>

            <div class="mb-3">
                <label class="block">Room Type</label>
                <select name="room_type_id" class="w-full border rounded px-3 py-2">
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block">Floor</label>
                <input type="number" name="floor"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('floor') }}">
            </div>

            <div class="mb-3">
                <label class="block">Price</label>
                <input type="number" name="price"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('price') }}">
            </div>

            <button class="bg-green-500 text-white px-4 py-2 rounded">
                Save
            </button>

            <a href="{{ url('/rooms') }}" class="ml-2 text-gray-600">
                Back
            </a>

        </form>
    </div>

</x-app-layout>
