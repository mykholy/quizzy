<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Admin\Amenity;

class AmenityApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_amenity()
    {
        $amenity = Amenity::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/amenities', $amenity
        );

        $this->assertApiResponse($amenity);
    }

    /**
     * @test
     */
    public function test_read_amenity()
    {
        $amenity = Amenity::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/amenities/'.$amenity->id
        );

        $this->assertApiResponse($amenity->toArray());
    }

    /**
     * @test
     */
    public function test_update_amenity()
    {
        $amenity = Amenity::factory()->create();
        $editedAmenity = Amenity::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/amenities/'.$amenity->id,
            $editedAmenity
        );

        $this->assertApiResponse($editedAmenity);
    }

    /**
     * @test
     */
    public function test_delete_amenity()
    {
        $amenity = Amenity::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/amenities/'.$amenity->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/amenities/'.$amenity->id
        );

        $this->response->assertStatus(404);
    }
}
