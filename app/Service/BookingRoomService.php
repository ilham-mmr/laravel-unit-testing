<?php

namespace App\Service;

use App\Room;
use Exception;

use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isNull;

class BookingRoomService
{

    public function bookTheRoom($roomId)
    {
        $room = Room::where('id',$roomId)->firstOrFail();
        $user = Auth::user();
        // dump("user has ".count($user->room()->get()));

        if (!$user->vip && count($user->room()->get()) == 1) {
            return false;
        }

        if (!isNull($room->guest_id)) {
            return false;
        }

        $room->guest_id = $user->id;
        $room->save();
        dump( $user->room->count());

        return true;
    }
}
