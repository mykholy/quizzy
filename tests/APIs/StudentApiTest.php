<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Admin\Student;

class StudentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_student()
    {
        $student = Student::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/students', $student
        );

        $this->assertApiResponse($student);
    }

    /**
     * @test
     */
    public function test_read_student()
    {
        $student = Student::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/students/'.$student->id
        );

        $this->assertApiResponse($student->toArray());
    }

    /**
     * @test
     */
    public function test_update_student()
    {
        $student = Student::factory()->create();
        $editedStudent = Student::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/students/'.$student->id,
            $editedStudent
        );

        $this->assertApiResponse($editedStudent);
    }

    /**
     * @test
     */
    public function test_delete_student()
    {
        $student = Student::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/students/'.$student->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/students/'.$student->id
        );

        $this->response->assertStatus(404);
    }
}
