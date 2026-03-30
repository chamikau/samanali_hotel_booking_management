<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // 📌 Get all bookings
    public function index()
    {
        return Booking::with(['room', 'user'])->latest()->get();
    }

    // 📌 Store booking
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        // 🚫 Check availability
        $exists = Booking::where('room_id', $request->room_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('check_in_date', [$request->check_in_date, $request->check_out_date])
                    ->orWhereBetween('check_out_date', [$request->check_in_date, $request->check_out_date]);
            })
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Room already booked for selected dates'
            ], 400);
        }

        // 💰 Calculate price
        $room = Room::find($request->room_id);

        $days = \Carbon\Carbon::parse($request->check_in_date)
            ->diffInDays($request->check_out_date);

        $total = $days * ($room->price ?? $room->roomType->base_price);

        $booking = Booking::create([
            'user_id' => auth()->id() ?? null,
            'room_id' => $request->room_id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_price' => $total,
            'status' => 'confirmed'
        ]);

        return response()->json($booking, 201);
    }

    // 📌 Show booking
    public function show($id)
    {
        return Booking::with(['room', 'user'])->findOrFail($id);
    }

    // 📌 Cancel booking
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'cancelled']);

        return response()->json(['message' => 'Booking cancelled']);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function checkIn($id): JsonResponse
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status !== 'confirmed') {
            return response()->json([
                'message' => 'Booking not confirmed'
            ], 400);
        }

        if ($booking->checked_in_at) {
            return response()->json([
                'message' => 'Already checked-in'
            ], 400);
        }

        $booking->update([
            'checked_in_at' => now(),
            'status' => 'checked_in'
        ]);

        // 🛏️ Update room status
        $booking->room->update([
            'status' => 'occupied'
        ]);

        return response()->json([
            'message' => 'Checked-in successfully',
            'booking' => $booking
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function checkOut($id): JsonResponse
    {
        $booking = Booking::findOrFail($id);

        if (!$booking->checked_in_at) {
            return response()->json([
                'message' => 'Not checked-in yet'
            ], 400);
        }

        if ($booking->checked_out_at) {
            return response()->json([
                'message' => 'Already checked-out'
            ], 400);
        }

        // 💳 Optional: check payment
        if (!$booking->payment || $booking->payment->payment_status !== 'paid') {
            return response()->json([
                'message' => 'Payment not completed'
            ], 400);
        }

        $booking->update([
            'checked_out_at' => now(),
            'status' => 'completed'
        ]);

        // 🛏️ Free the room
        $booking->room->update([
            'status' => 'available'
        ]);

        return response()->json([
            'message' => 'Checked-out successfully',
            'booking' => $booking
        ]);
    }
}
