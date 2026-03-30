<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // 📌 Get all rooms (with filters)
    public function index(Request $request)
    {
        $query = Room::with(['roomType', 'user']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->room_type_id) {
            $query->where('room_type_id', $request->room_type_id);
        }

        if ($request->floor) {
            $query->where('floor', $request->floor);
        }

        return response()->json($query->latest()->get());
    }

    // 📌 Create room
    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms',
            'room_type_id' => 'required|exists:room_types,id',
            'price' => 'nullable|numeric',
        ]);

        $room = Room::create([
            'room_number' => $request->room_number,
            'room_type_id' => $request->room_type_id,
            'user_id' => auth()->id(),
            'floor' => $request->floor,
            'price' => $request->price,
            'status' => $request->status ?? 'available',
        ]);

        return response()->json($room, 201);
    }

    // 📌 Show single room
    public function show($id)
    {
        $room = Room::with(['roomType', 'user'])->findOrFail($id);

        return response()->json($room);
    }

    // 📌 Update room
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'room_number' => 'required|unique:rooms,room_number,' . $id,
            'room_type_id' => 'required|exists:room_types,id',
        ]);

        $room->update($request->all());

        return response()->json($room);
    }

    // 📌 Delete room
    public function destroy($id)
    {
        Room::findOrFail($id)->delete();

        return response()->json(['message' => 'Room deleted']);
    }
}
