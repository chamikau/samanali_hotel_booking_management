<?php
namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // 📌 Show all rooms
    public function index()
    {
        $rooms = Room::with('roomType')->get();
        return view('rooms.index', compact('rooms'));
    }

    // 📌 Show create form
    public function create()
    {
        $roomTypes = RoomType::all();
        return view('rooms.create', compact('roomTypes'));
    }

    // 📌 Store room
    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms',
            'room_type_id' => 'required',
        ]);

        Room::create([
            'room_number' => $request->room_number,
            'room_type_id' => $request->room_type_id,
            'floor' => $request->floor,
            'price' => $request->price,
            'status' => 'available',
            'user_id' => null
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room created');
    }

}
