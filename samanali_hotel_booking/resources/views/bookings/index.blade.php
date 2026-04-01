<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bookings
        </h2>
    </x-slot>

    <div class="py-6 px-6">

        <a href="{{ url('/bookings/create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-3 inline-block">
            New Booking
        </a>

        <div class="bg-white shadow rounded p-4 mt-3">
            <table class="table-auto w-full border">
                <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">Room</th>
                    <th class="p-2 border">Check-in</th>
                    <th class="p-2 border">Check-out</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td class="p-2 border">{{ $booking->id }}</td>
                        <td class="p-2 border">{{ $booking->room->room_number ?? 'N/A' }}</td>
                        <td class="p-2 border">{{ $booking->check_in_date }}</td>
                        <td class="p-2 border">{{ $booking->check_out_date }}</td>
                        <td class="p-2 border">{{ $booking->status }}</td>
                        <td class="p-2 border">

                            <!-- Check-in -->
                            @if($booking->status === 'confirmed')
                                <form action="{{ route('bookings.checkin', $booking->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="text-green-600">Check-in</button>
                                </form>
                            @endif

                            <!-- Check-out -->
                            @if($booking->status === 'checked_in')
                                <form action="{{ route('bookings.checkout', $booking->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="text-red-600">Check-out</button>
                                </form>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-2">No bookings found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
