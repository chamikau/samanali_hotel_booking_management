<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(RoomType::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'base_price' => 'required|numeric',
            'max_occupancy' => 'required|integer',
        ]);

        $roomType = RoomType::create($request->all());

        return response()->json($roomType, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(RoomType::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $roomType = RoomType::findOrFail($id);

        $roomType->update($request->all());

        return response()->json($roomType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        RoomType::findOrFail($id)->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
