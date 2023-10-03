<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateTeacherAPIRequest;
use App\Http\Requests\API\Admin\UpdateTeacherAPIRequest;
use App\Models\Admin\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\TeacherResource;

/**
 * Class TeacherAPIController
 */
class TeacherAPIController extends AppBaseController
{
    /**
     * Display a listing of the Teachers.
     * GET|HEAD /teachers
     */
    public function index(Request $request): JsonResponse
    {
        $query = Teacher::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $teachers = $query->get();

        return $this->sendResponse(
            TeacherResource::collection($teachers),
            __('messages.retrieved', ['model' => __('models/teachers.plural')])
        );
    }

    /**
     * Store a newly created Teacher in storage.
     * POST /teachers
     */
    public function store(CreateTeacherAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Teacher $teacher */
        $teacher = Teacher::create($input);

        return $this->sendResponse(
            new TeacherResource($teacher),
            __('messages.saved', ['model' => __('models/teachers.singular')])
        );
    }

    /**
     * Display the specified Teacher.
     * GET|HEAD /teachers/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Teacher $teacher */
        $teacher = Teacher::find($id);

        if (empty($teacher)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/teachers.singular')])
            );
        }

        return $this->sendResponse(
            new TeacherResource($teacher),
            __('messages.retrieved', ['model' => __('models/teachers.singular')])
        );
    }

    /**
     * Update the specified Teacher in storage.
     * PUT/PATCH /teachers/{id}
     */
    public function update($id, UpdateTeacherAPIRequest $request): JsonResponse
    {
        /** @var Teacher $teacher */
        $teacher = Teacher::find($id);

        if (empty($teacher)) {
        return $this->sendError(
            __('messages.not_found', ['model' => __('models/teachers.singular')])
        );
        }

        $teacher->fill($request->all());
        $teacher->save();

        return $this->sendResponse(
            new TeacherResource($teacher),
            __('messages.updated', ['model' => __('models/teachers.singular')])
        );
    }

    /**
     * Remove the specified Teacher from storage.
     * DELETE /teachers/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Teacher $teacher */
        $teacher = Teacher::find($id);

        if (empty($teacher)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/teachers.singular')])
            );
        }

        $teacher->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/teachers.singular')])
        );
    }
}
