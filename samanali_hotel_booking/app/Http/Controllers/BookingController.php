<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    // 📌 Show bookings
    public function index()
    {
        $bookings = Booking::with('room')->get();
        return view('bookings.index', compact('bookings'));
    }

    // 📌 Show create form
    // 📌 Show create form
    public function create()
    {
        $rooms = Room::with('roomType')->get(); // ✅ remove filter for now

        return view('bookings.create', compact('rooms'));
    }

    // 📌 Store booking
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $room = Room::find($request->room_id);

        $days = Carbon::parse($request->check_in_date)
            ->diffInDays($request->check_out_date);

        $total = $days * ($room->price ?? $room->roomType->base_price);

        Booking::create([
            'room_id' => $request->room_id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_price' => $total,
            'status' => 'confirmed'
        ]);

        // Update room status
        $room->update(['status' => 'reserved']);

        return redirect()->route('bookings.index')->with('success', 'Booking created');
    }

    // 📌 Check-in
    public function checkIn($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'checked_in_at' => now(),
            'status' => 'checked_in'
        ]);

        $booking->room->update(['status' => 'occupied']);

        return back()->with('success', 'Checked-in');
    }

    // 📌 Check-out
    public function checkOut($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'checked_out_at' => now(),
            'status' => 'completed'
        ]);

        $booking->room->update(['status' => 'available']);

        return back()->with('success', 'Checked-out');
    }

    public function pay($id)
    {
        $booking = Booking::with('payment')->findOrFail($id);

        // If payment exists, update it
        if ($booking->payment) {
            $booking->payment->update([
                'payment_status' => 'paid',
                'payment_method' => 'cash'
            ]);
        } else {
            // Create payment
            Payment::create([
                'payment_method' => 'cash',
                'booking_id' => $booking->id,
                'amount' => $booking->total_price,
                'payment_status' => 'paid'
            ]);
        }

        return back()->with('success', 'Payment completed successfully');
    }
}
