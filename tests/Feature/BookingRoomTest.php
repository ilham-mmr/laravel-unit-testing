<?php

namespace Tests\Feature;

use App\User;
use RoomSeeder;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingRoomTest extends TestCase {
    use RefreshDatabase;

    public function test_a_room_can_be_booked() {
        // $this->withoutExceptionHandling();
        $this->seed(RoomSeeder::class);

        $user = factory(User::class)->create(['vip' => false]);
        $response = $this->actingAs($user)->post('/room/1');

        $response->assertRedirect('/home');
        $response->assertSessionHas('message', 'room has been booked');
    }

    public function test_a_room_can_not_be_booked_because_it_doesnt_exist() {
        // $this->withoutExceptionHandling();
        $user = factory(User::class)->create(['vip' => false]);
        $response = $this->actingAs($user)->post('/room/90');

        $response->assertNotFound();
    }

    public function test_only_loggedIn_user_can_book() {
        // $this->withoutExceptionHandling();
        $this->seed(RoomSeeder::class);

        $response = $this->post('/room/1');

        $response->assertRedirect('/login');
    }

    public function test_upload_foto() {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create(['vip' => false]);

        $pic = UploadedFile::fake()->image('image.png');
        $response = $this->actingAs($user)->post('/upload_picture', ['image' => $pic]);

        $response->assertRedirect('/home');
        Storage::disk('public')->assertExists($pic->hashName());
    }
}
