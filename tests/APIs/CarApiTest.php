<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Admin\Car;

class CarApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_car()
    {
        $car = Car::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/cars', $car
        );

        $this->assertApiResponse($car);
    }

    /**
     * @test
     */
    public function test_read_car()
    {
        $car = Car::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/cars/'.$car->id
        );

        $this->assertApiResponse($car->toArray());
    }

    /**
     * @test
     */
    public function test_update_car()
    {
        $car = Car::factory()->create();
        $editedCar = Car::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/cars/'.$car->id,
            $editedCar
        );

        $this->assertApiResponse($editedCar);
    }

    /**
     * @test
     */
    public function test_delete_car()
    {
        $car = Car::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/cars/'.$car->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/cars/'.$car->id
        );

        $this->response->assertStatus(404);
    }
}
