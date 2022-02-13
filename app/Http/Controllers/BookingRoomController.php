<?php

namespace App\Http\Controllers;

use App\Room;
use App\Service\BookingRoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class
BookingRoomController extends Controller {
    public function book(Room $room) {
        (new BookingRoomService)->bookTheRoom($room->id);
        return redirect()->route('home')->with('message', 'room has been booked');
    }

    public function upload(Request $request) {

        $request->file('image')->store('public');

        return redirect()->route('home');
    }
}
