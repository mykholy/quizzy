<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateExamAPIRequest;
use App\Http\Requests\API\Admin\UpdateExamAPIRequest;
use App\Http\Resources\Admin\SubjectResource;
use App\Http\Resources\Admin\UnitResource;
use App\Models\Admin\Exam;
use App\Models\Admin\Lesson;
use App\Models\Admin\Question;
use App\Models\Admin\Subject;
use App\Models\Admin\Unit;
use Carbon\Carbon;
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
        }
        if ($request->get('type_assessment')) {
            $query->where('type_assessment', $request->type_assessment);
        }

        $exams = $query->get();

        return $this->sendResponse(
            ExamResource::collection($exams),
            __('messages.retrieved', ['model' => __('models/exams.plural')])
        );
    }

    public function create(Request $request): JsonResponse
    {

        $subject = Subject::find($request->subject_id);
        $book_ids = $subject->books->pluck('id')->toArray();

        $units = Unit::whereIn('book_id', $book_ids)->get();

        $data['subject'] = new SubjectResource($subject);
        $data['units'] = UnitResource::collection($units);
        $data['lessons'] = UnitResource::collection($units);

        return $this->sendResponse(
            $data,
            __('messages.retrieved', ['model' => __('models/exams.singular')])
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

        $timeLimit = $request->input('time', null);

        $query = Question::query()
            ->when(\request('question_types'), function ($q) {
                $q->whereIn('question_types', \request('question_types'));
            });
        if ($request_data['type'] == Exam::$EXAM_TYPE_RANDOMLY) {

            $questionIds = $this->getQuestionsIdsByTotalTime($query, $numberOfQuestions, $timeLimit);

        } else if ($request_data['type'] == Exam::$EXAM_TYPE_CHOICE) {
            if ($request->unit_id && !($request->lesson_id)) {
                $lessonIds = Lesson::where('unit_id', $request->unit_id)->pluck('id')->toArray();
                $questionIds = $this->getQuestionsIdsByTotalTime($query->whereIn('lesson_id', $lessonIds), $numberOfQuestions, $timeLimit);

            } elseif ($request->lesson_id) {
                $questionIds = $this->getQuestionsIdsByTotalTime($query->where('lesson_id', $request->lesson_id), $numberOfQuestions, $timeLimit);

            } else {
                $unit_ids = Unit::where('book_id', $request->book_id)->pluck('id')->toArray();
                $lessonIds = Lesson::whereIn('unit_id', $unit_ids)->pluck('id')->toArray();

                $questionIds = $this->getQuestionsIdsByTotalTime($query->whereIn('lesson_id', $lessonIds), $numberOfQuestions, $timeLimit);
            }
        } else {
            $questionIds = $this->getQuestionsIdsByTotalTime($query, $numberOfQuestions, $timeLimit);
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

    public function getQuestionsIdsByTotalTime($query, $numberOfQuestions = 10, $time = null)
    {
        $questionIds = [];
        $uniqueQuestionIds = collect(); // Using a collection as a set for uniqueness
        if ($time) {
            $timeLimit = (int)$time;
            $cumulativeTime = 0;

            // Get questions randomly until cumulative time exceeds the limit
            while ($cumulativeTime <= $timeLimit && $uniqueQuestionIds->count() < $numberOfQuestions) {
                $randomQuestion = $query->inRandomOrder()->first();
                if ($randomQuestion) {
                    $questionTime = (int)$randomQuestion->time;
                    $cumulativeTime += $questionTime;

                    // Only add the question if the cumulative time is still within the limit and it's not already in the set
                    if ($cumulativeTime <= $timeLimit && !$uniqueQuestionIds->contains($randomQuestion->id)) {
                        $uniqueQuestionIds->push($randomQuestion->id);
                    }
                }
            }
        } else {
            $uniqueQuestionIds = $query->inRandomOrder()->pluck('id')->unique()->take($numberOfQuestions);
        }

        return $uniqueQuestionIds->toArray();
    }

}
