<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateExamAPIRequest;
use App\Http\Requests\API\Admin\UpdateExamAPIRequest;
use App\Models\Admin\Exam;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\ExamResource;

/**
 * Class ExamAPIController
 */
class ExamAPIController extends AppBaseController
{
    /**
     * Display a listing of the Exams.
     * GET|HEAD /exams
     */
    public function index(Request $request): JsonResponse
    {
        $query = Exam::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $exams = $query->get();

        return $this->sendResponse(
            ExamResource::collection($exams),
            __('messages.retrieved', ['model' => __('models/exams.plural')])
        );
    }

    /**
     * Store a newly created Exam in storage.
     * POST /exams
     */
    public function store(CreateExamAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Exam $exam */
        $exam = Exam::create($input);

        return $this->sendResponse(
            new ExamResource($exam),
            __('messages.saved', ['model' => __('models/exams.singular')])
        );
    }

    /**
     * Display the specified Exam.
     * GET|HEAD /exams/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Exam $exam */
        $exam = Exam::find($id);

        if (empty($exam)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/exams.singular')])
            );
        }

        return $this->sendResponse(
            new ExamResource($exam),
            __('messages.retrieved', ['model' => __('models/exams.singular')])
        );
    }

    /**
     * Update the specified Exam in storage.
     * PUT/PATCH /exams/{id}
     */
    public function update($id, UpdateExamAPIRequest $request): JsonResponse
    {
        /** @var Exam $exam */
        $exam = Exam::find($id);

        if (empty($exam)) {
        return $this->sendError(
            __('messages.not_found', ['model' => __('models/exams.singular')])
        );
        }

        $exam->fill($request->all());
        $exam->save();

        return $this->sendResponse(
            new ExamResource($exam),
            __('messages.updated', ['model' => __('models/exams.singular')])
        );
    }

    /**
     * Remove the specified Exam from storage.
     * DELETE /exams/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Exam $exam */
        $exam = Exam::find($id);

        if (empty($exam)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/exams.singular')])
            );
        }

        $exam->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/exams.singular')])
        );
    }
}
