<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function index(): View
    {
        return view('admin.rooms', [
            'rooms' => Room::orderBy('id')->withCount('appointments')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        Room::create(['name' => $validated['name'], 'is_active' => true]);

        return back()->with('status', 'Treatment room added.');
    }

    public function toggle(Room $room): RedirectResponse
    {
        $room->update(['is_active' => ! $room->is_active]);

        return back()->with('status', "Room \"{$room->name}\" " . ($room->is_active ? 'activated' : 'deactivated') . '.');
    }
}
