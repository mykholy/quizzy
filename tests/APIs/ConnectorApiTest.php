<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Admin\Connector;

class ConnectorApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_connector()
    {
        $connector = Connector::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/connectors', $connector
        );

        $this->assertApiResponse($connector);
    }

    /**
     * @test
     */
    public function test_read_connector()
    {
        $connector = Connector::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/connectors/'.$connector->id
        );

        $this->assertApiResponse($connector->toArray());
    }

    /**
     * @test
     */
    public function test_update_connector()
    {
        $connector = Connector::factory()->create();
        $editedConnector = Connector::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/connectors/'.$connector->id,
            $editedConnector
        );

        $this->assertApiResponse($editedConnector);
    }

    /**
     * @test
     */
    public function test_delete_connector()
    {
        $connector = Connector::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/connectors/'.$connector->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/connectors/'.$connector->id
        );

        $this->response->assertStatus(404);
    }
}
