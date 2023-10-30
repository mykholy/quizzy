<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateLessonAPIRequest;
use App\Http\Requests\API\Admin\UpdateLessonAPIRequest;
use App\Models\Admin\Lesson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\LessonResource;

/**
 * Class LessonAPIController
 */
class LessonAPIController extends AppBaseController
{
    /**
     * Display a listing of the Lessons.
     * GET|HEAD /lessons
     */
    public function index(Request $request): JsonResponse
    {
        $query = Lesson::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $lessons = $query->get();

        return $this->sendResponse(
            LessonResource::collection($lessons),
            __('messages.retrieved', ['model' => __('models/lessons.plural')])
        );
    }

    /**
     * Store a newly created Lesson in storage.
     * POST /lessons
     */
    public function store(CreateLessonAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Lesson $lesson */
        $lesson = Lesson::create($input);

        return $this->sendResponse(
            new LessonResource($lesson),
            __('messages.saved', ['model' => __('models/lessons.singular')])
        );
    }

    /**
     * Display the specified Lesson.
     * GET|HEAD /lessons/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Lesson $lesson */
        $lesson = Lesson::find($id);

        if (empty($lesson)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/lessons.singular')])
            );
        }

        return $this->sendResponse(
            new LessonResource($lesson),
            __('messages.retrieved', ['model' => __('models/lessons.singular')])
        );
    }

    /**
     * Update the specified Lesson in storage.
     * PUT/PATCH /lessons/{id}
     */
    public function update($id, UpdateLessonAPIRequest $request): JsonResponse
    {
        /** @var Lesson $lesson */
        $lesson = Lesson::find($id);

        if (empty($lesson)) {
        return $this->sendError(
            __('messages.not_found', ['model' => __('models/lessons.singular')])
        );
        }

        $lesson->fill($request->all());
        $lesson->save();

        return $this->sendResponse(
            new LessonResource($lesson),
            __('messages.updated', ['model' => __('models/lessons.singular')])
        );
    }

    /**
     * Remove the specified Lesson from storage.
     * DELETE /lessons/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Lesson $lesson */
        $lesson = Lesson::find($id);

        if (empty($lesson)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/lessons.singular')])
            );
        }

        $lesson->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/lessons.singular')])
        );
    }
}
