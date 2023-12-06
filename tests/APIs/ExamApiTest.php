<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Admin\Exam;

class ExamApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_exam()
    {
        $exam = Exam::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/exams', $exam
        );

        $this->assertApiResponse($exam);
    }

    /**
     * @test
     */
    public function test_read_exam()
    {
        $exam = Exam::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/exams/'.$exam->id
        );

        $this->assertApiResponse($exam->toArray());
    }

    /**
     * @test
     */
    public function test_update_exam()
    {
        $exam = Exam::factory()->create();
        $editedExam = Exam::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/exams/'.$exam->id,
            $editedExam
        );

        $this->assertApiResponse($editedExam);
    }

    /**
     * @test
     */
    public function test_delete_exam()
    {
        $exam = Exam::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/exams/'.$exam->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/exams/'.$exam->id
        );

        $this->response->assertStatus(404);
    }
}
