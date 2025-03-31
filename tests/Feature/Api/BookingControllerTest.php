<?php

namespace Tests\Feature\Api;

use App\Models\Booking;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingControllerTest extends TestCase
{


    /** @test */
    public function it_creates_a_new_booking()
    {
        $resource = Resource::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson('/api/bookings', [
            'resource_id' => $resource->id,
            'user_id' => $user->id,
            'start_time' => '2025-04-01T14:00:00Z',
            'end_time' => '2025-04-01T16:00:00Z',
        ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function it_returns_validation_error_for_invalid_data()
    {
        $response = $this->postJson('/api/bookings', [
            'resource_id' => 'invalid',
            'user_id' => 'invalid',
            'start_time' => 'invalid',
            'end_time' => 'invalid',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['resource_id', 'user_id', 'start_time', 'end_time']);
    }

    /** @test */
    public function it_returns_bookings_for_authenticated_user()
    {
        $user = User::factory()->create();
        $booking = Booking::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->getJson('/api/bookings');

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $booking->id]);
    }

}
