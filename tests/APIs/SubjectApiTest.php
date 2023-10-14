<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Admin\Subject;

class SubjectApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_subject()
    {
        $subject = Subject::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/subjects', $subject
        );

        $this->assertApiResponse($subject);
    }

    /**
     * @test
     */
    public function test_read_subject()
    {
        $subject = Subject::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/subjects/'.$subject->id
        );

        $this->assertApiResponse($subject->toArray());
    }

    /**
     * @test
     */
    public function test_update_subject()
    {
        $subject = Subject::factory()->create();
        $editedSubject = Subject::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/subjects/'.$subject->id,
            $editedSubject
        );

        $this->assertApiResponse($editedSubject);
    }

    /**
     * @test
     */
    public function test_delete_subject()
    {
        $subject = Subject::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/subjects/'.$subject->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/subjects/'.$subject->id
        );

        $this->response->assertStatus(404);
    }
}
