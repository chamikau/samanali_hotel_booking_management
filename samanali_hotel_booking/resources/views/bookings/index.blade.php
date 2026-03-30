@extends('layouts.app')

@section('content')
    <h3>Bookings</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('bookings.create') }}" class="btn btn-primary mb-3">New Booking</a>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Room</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Status</th>
            <th>Payment</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($bookings as $booking)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->room->room_number ?? 'N/A' }}</td>
                <td>{{ $booking->check_in_date ?? 'N/A' }}</td>
                <td>{{ $booking->check_out_date ?? 'N/A' }}</td>
                <td>{{ ucfirst($booking->status) }}</td>

                <!-- Payment Status -->
                <td>
                    @if(!$booking->payment || $booking->payment->payment_status !== 'paid')
                        <span class="badge bg-warning">Pending</span>
                    @else
                        <span class="badge bg-success">Paid</span>
                    @endif
                </td>

                <!-- Actions -->
                <td>
                    <!-- Check-in -->
                    @if($booking->status === 'confirmed' && !$booking->checked_in_at)
                        <form action="{{ route('bookings.checkin', $booking->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn btn-success btn-sm">Check-in</button>
                        </form>
                    @endif

                    <!-- Payment after check-in -->
                    @if($booking->status === 'checked_in' && (!$booking->payment || $booking->payment->payment_status !== 'paid'))
                        <form action="{{ route('bookings.pay', $booking->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn btn-info btn-sm">Pay</button>
                        </form>
                    @endif

                    <!-- Check-out -->
                    @if($booking->status === 'checked_in' && $booking->checked_in_at)
                        <form action="{{ route('bookings.checkout', $booking->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn btn-danger btn-sm">Check-out</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No bookings found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
