<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rooms
        </h2>
    </x-slot>

    <div class="py-6 px-6">

        <a href="{{ url('/rooms/create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-3 inline-block">
            Add Room
        </a>

        <div class="bg-white shadow rounded p-4 mt-3">
            <table class="table-auto w-full border">
                <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 border">Room No</th>
                    <th class="p-2 border">Type</th>
                    <th class="p-2 border">Floor</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($rooms as $room)
                    <tr>
                        <td class="p-2 border">{{ $room->room_number }}</td>
                        <td class="p-2 border">{{ $room->roomType->name ?? 'N/A' }}</td>
                        <td class="p-2 border">{{ $room->floor }}</td>
                        <td class="p-2 border">{{ $room->status }}</td>
                        <td class="p-2 border">
                            <a href="{{ route('rooms.edit', $room->id) }}" class="text-blue-500">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-2">No rooms found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
