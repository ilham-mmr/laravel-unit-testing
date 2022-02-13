<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;

use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewTest extends TestCase {
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function test_welcome_page() {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSeeText('Laravel')
            ->assertViewIs('welcome');
    }


}
