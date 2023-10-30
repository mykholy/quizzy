<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Admin\AcademicYear;

class AcademicYearApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_academic_year()
    {
        $academicYear = AcademicYear::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/academic-years', $academicYear
        );

        $this->assertApiResponse($academicYear);
    }

    /**
     * @test
     */
    public function test_read_academic_year()
    {
        $academicYear = AcademicYear::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/academic-years/'.$academicYear->id
        );

        $this->assertApiResponse($academicYear->toArray());
    }

    /**
     * @test
     */
    public function test_update_academic_year()
    {
        $academicYear = AcademicYear::factory()->create();
        $editedAcademicYear = AcademicYear::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/academic-years/'.$academicYear->id,
            $editedAcademicYear
        );

        $this->assertApiResponse($editedAcademicYear);
    }

    /**
     * @test
     */
    public function test_delete_academic_year()
    {
        $academicYear = AcademicYear::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/academic-years/'.$academicYear->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/academic-years/'.$academicYear->id
        );

        $this->response->assertStatus(404);
    }
}
