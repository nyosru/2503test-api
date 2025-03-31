<?php

namespace Tests\Feature\Api;

use App\Models\Booking;
use App\Models\Resource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResourceBookingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_all_bookings_for_a_resource()
    {
        $resource = Resource::factory()->create();
        $booking = Booking::factory(3)->create(['resource_id' => $resource->id]);

        $response = $this->getJson("/api/resources/{$resource->id}/bookings");

//        $response->assertStatus(200)
//            ->assertJsonFragment([
//                'id' => $booking->id,
//                'resource_id' => $resource->id,
//            ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [ // Проверка всех элементов в массиве 'data'
                        'id',
                        'resource_id',
                        'user_id',
                        'start_time',
                        'end_time',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ])
            ->assertJsonPath('data.0.id', $booking[0]->id) // Проверка первого элемента
            ->assertJsonPath('data.0.resource_id', $resource->id);
    }

    /** @test */
    public function it_returns_404_if_resource_not_found()
    {
        $response = $this->getJson('/api/resources/999/bookings');

        $response->assertStatus(404)
            ->assertJson(['message' => 'Resource not found']);
    }


}
