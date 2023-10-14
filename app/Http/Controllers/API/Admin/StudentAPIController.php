<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateStudentAPIRequest;
use App\Http\Requests\API\Admin\UpdateStudentAPIRequest;
use App\Models\Admin\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\StudentResource;

/**
 * Class StudentAPIController
 */
class StudentAPIController extends AppBaseController
{
    /**
     * Display a listing of the Students.
     * GET|HEAD /students
     */
    public function index(Request $request): JsonResponse
    {
        $query = Student::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $students = $query->get();

        return $this->sendResponse(
            StudentResource::collection($students),
            __('messages.retrieved', ['model' => __('models/students.plural')])
        );
    }

    /**
     * Store a newly created Student in storage.
     * POST /students
     */
    public function store(CreateStudentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Student $student */
        $student = Student::create($input);

        return $this->sendResponse(
            new StudentResource($student),
            __('messages.saved', ['model' => __('models/students.singular')])
        );
    }

    /**
     * Display the specified Student.
     * GET|HEAD /students/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Student $student */
        $student = Student::find($id);

        if (empty($student)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/students.singular')])
            );
        }

        return $this->sendResponse(
            new StudentResource($student),
            __('messages.retrieved', ['model' => __('models/students.singular')])
        );
    }

    /**
     * Update the specified Student in storage.
     * PUT/PATCH /students/{id}
     */
    public function update($id, UpdateStudentAPIRequest $request): JsonResponse
    {
        /** @var Student $student */
        $student = Student::find($id);

        if (empty($student)) {
        return $this->sendError(
            __('messages.not_found', ['model' => __('models/students.singular')])
        );
        }

        $student->fill($request->all());
        $student->save();

        return $this->sendResponse(
            new StudentResource($student),
            __('messages.updated', ['model' => __('models/students.singular')])
        );
    }

    /**
     * Remove the specified Student from storage.
     * DELETE /students/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Student $student */
        $student = Student::find($id);

        if (empty($student)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/students.singular')])
            );
        }

        $student->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/students.singular')])
        );
    }
}
