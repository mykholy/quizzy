<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Admin\Teacher;

class TeacherApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_teacher()
    {
        $teacher = Teacher::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/teachers', $teacher
        );

        $this->assertApiResponse($teacher);
    }

    /**
     * @test
     */
    public function test_read_teacher()
    {
        $teacher = Teacher::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/teachers/'.$teacher->id
        );

        $this->assertApiResponse($teacher->toArray());
    }

    /**
     * @test
     */
    public function test_update_teacher()
    {
        $teacher = Teacher::factory()->create();
        $editedTeacher = Teacher::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/teachers/'.$teacher->id,
            $editedTeacher
        );

        $this->assertApiResponse($editedTeacher);
    }

    /**
     * @test
     */
    public function test_delete_teacher()
    {
        $teacher = Teacher::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/teachers/'.$teacher->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/teachers/'.$teacher->id
        );

        $this->response->assertStatus(404);
    }
}
