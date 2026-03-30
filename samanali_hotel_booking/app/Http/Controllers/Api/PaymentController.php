<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // 📌 Get all payments
    public function index()
    {
        return Payment::with('booking')->latest()->get();
    }

    // 📌 Store payment
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|in:cash,card,online',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        // 🚫 Prevent duplicate payment
        if ($booking->payment) {
            return response()->json([
                'message' => 'Payment already exists for this booking'
            ], 400);
        }

        $payment = Payment::create([
            'booking_id' => $request->booking_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);

        return response()->json($payment, 201);
    }

    // 📌 Show single payment
    public function show($id)
    {
        return Payment::with('booking')->findOrFail($id);
    }

    // 📌 Update payment (optional)
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update($request->all());

        return response()->json($payment);
    }

    // 📌 Delete payment
    public function destroy($id)
    {
        Payment::findOrFail($id)->delete();

        return response()->json(['message' => 'Payment deleted']);
    }
}
