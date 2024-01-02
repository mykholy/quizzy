<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateExamAPIRequest;
use App\Http\Requests\API\Admin\UpdateExamAPIRequest;
use App\Models\Admin\Exam;
use App\Models\Admin\Lesson;
use App\Models\Admin\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\ExamResource;

/**
 * Class ExamAPIController
 */
class ExamAPIController extends AppBaseController
{
    public function __construct()
    {

        $this->middleware('auth:api-student');

    }

    /**
     * Display a listing of the Exams.
     * GET|HEAD /exams
     */
    public function index(Request $request): JsonResponse
    {
        $query = Exam::query()->whereHas('students', function ($q) {
            $q->where('students.id', auth('api-student')->id());
        });

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        if ($request->get('type')) {
            $query->where('type', $request->type);
        }
        if ($request->get('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }if ($request->get('type_assessment')) {
            $query->where('type_assessment', $request->type_assessment);
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
        $request_data = $request->except(['_token', 'photo']);
        if ($request->hasFile('photo')) {

            $request_data['photo'] = uploadImage('exams', $request->photo);

        }
        /** @var Exam $exam */
        $exam = Exam::create($request_data);
        $student = auth('api-student')->user();
        $numberOfQuestions = 10; // Adjust the number as needed
        $query = Question::query();
        if ($request_data['type'] == Exam::$EXAM_TYPE_RANDOMLY) {

            $questionIds = $query->inRandomOrder()->pluck('id')->take($numberOfQuestions);

        } else if ($request_data['type'] == Exam::$EXAM_TYPE_CHOICE) {
            if ($request->unit_id && !($request->lesson_id)) {
                $lessonIds = Lesson::where('unit_id', $request->unit_id)->pluck('id')->toArray();
                $questionIds = $query->whereIn('lesson_id', $lessonIds)->inRandomOrder()->pluck('id')->take($numberOfQuestions);
            } elseif ($request->lesson_id)
                $questionIds = $query->where('lesson_id', $request->lesson_id)->inRandomOrder()->pluck('id')->take($numberOfQuestions);
            else
                $questionIds = $query->inRandomOrder()->pluck('id')->take($numberOfQuestions);

        } else {
            $questionIds = $query->inRandomOrder()->pluck('id')->take($numberOfQuestions);
        }


        $exam->questions()->attach($questionIds);

        $student->exams()->attach([$exam->id]);

        return $this->sendResponse(
            new ExamResource(Exam::with('questions')->find($exam->id)),
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
        $exam = Exam::with('questions')->whereHas('students', function ($q) {
            $q->where('students.id', auth('api-student')->id());
        })->find($id);

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
