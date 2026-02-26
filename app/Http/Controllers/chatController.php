<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\chat;
use App\Events\preview;
use App\Events\RoomJoined;
use App\Events\RoomLeft;
use App\Models\Room;
use App\Models\Interest;

class chatController extends Controller
{
    public function broadcast(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            'room_id' => 'required|integer|exists:rooms,id',
        ]);

        event(new chat($request->username, $request->message, $request->room_id));

        return response()->json(['ok' => true]);
    }

    public function preview(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'message' => 'nullable|string|max:255',
            'room_id' => 'required|integer|exists:rooms,id',
        ]);

        event(new preview($request->username, $request->message ?? '', $request->room_id));

        return response()->json(['ok' => true]);
    }
    public function chat(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'room_name' => 'required|string|max:255|unique:rooms,name',
            'interests' => 'required|array|min:1',
        ]);

        $room = Room::firstOrCreate(['name' => $validated['room_name']]);
        $room->interests()->syncWithoutDetaching($validated['interests']);

        return view('chat', [
            'username' => $validated['username'],
            'room_name' => $room->name,
            'room_id' => $room->id,
            'interests' => $room->interests,
        ]);
    }

    public function createRoom()
    {
        $interests = Interest::orderBy('name')->get();
        return view('welcome', compact('interests'));
    }

    public function index()
    {
        return view('home');
    }

    public function rooms()
    {
        $rooms = Room::latest()->get();
        $interests = Interest::orderBy('name')->get();
        return view('rooms', compact('rooms', 'interests'));
    }

    public function notfound()
    {
        return view('welcome');
    }
    public function joinByInterests(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'interests' => 'required|array|min:1',
            // 'interests.*' => 'integer|exists:interests,id',
        ]);

        $selected = $validated['interests'];

       $room = Room::query()
    ->whereHas('interests', fn($q) => $q->whereIn('interests.id', $selected))
    ->orderByDesc('members')
    ->first();


        if (!$room) {
            return back()->withErrors(['interests' => 'No matching room found.']);
        }

        $room->increment('members');
        event(new RoomJoined($validated['username'], $room->id));

        return view('chat', [
            'username' => $validated['username'],
            'room_name' => $room->name,
            'room_id' => $room->id,
            'interests' => $room->interests,
        ]);
    }
public function storeInterest(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:interests,name',
    ]);

    Interest::create(['name' => $validated['name']]);

    return back()->with('success', 'Interest added.');
}


    public function deleteRoom($id)
    {
        Room::findOrFail($id)->delete();
        return redirect()->route('rooms');
    }

    public function leave(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|integer|exists:rooms,id',
            'username' => 'required|string|max:255',
        ]);

        $room = Room::findOrFail($validated['room_id']);
        $room->decrement('members');

        event(new RoomLeft($validated['username'], $room->id));

        return redirect()->route('user.login');
    }
}
