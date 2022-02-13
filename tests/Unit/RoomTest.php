<?php

namespace Tests\Unit;

use App\Room;
use App\User;
use Tests\TestCase;
use Illuminate\Support\Str;
use App\Service\BookingRoomService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_non_vip_user_can_only_book_one_room()
    {
        $this->withExceptionHandling();
        $room1 = Room::create(['name' => 'room1']);
        $room2 = Room::create(['name' => 'room2']);

        $user = factory(User::class)->create(['vip' => false]);

        $this->actingAs($user);
        $result1 = (new BookingRoomService())->bookTheRoom($room1->id);

        $this->assertTrue($result1);

        $result2 = (new BookingRoomService())->bookTheRoom($room2->id);
        $this->assertFalse($result2);
        $this->assertEquals(1, count($user->room()->get()));
    }

    public function test_a_vip_user_can__book_many_room()
    {
        $this->withExceptionHandling();
        $room1 = Room::create(['name' => 'room1']);
        $room2 = Room::create(['name' => 'room2']);

        $user = factory(User::class)->create(['vip' => true]);

        $this->actingAs($user);
        $result1 = (new BookingRoomService())->bookTheRoom($room1->id);

        $this->assertTrue($result1);

        $result2 = (new BookingRoomService())->bookTheRoom($room2->id);
        $this->assertTrue($result2);
        $this->assertEquals(2, count($user->room()->get()));
    }
}
