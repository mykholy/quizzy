<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateQuestionAPIRequest;
use App\Http\Requests\API\Admin\UpdateQuestionAPIRequest;
use App\Models\Admin\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\QuestionResource;

/**
 * Class QuestionAPIController
 */
class QuestionAPIController extends AppBaseController
{
    /**
     * Display a listing of the Questions.
     * GET|HEAD /questions
     */
    public function index(Request $request): JsonResponse
    {
        $query = Question::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $questions = $query->get();

        return $this->sendResponse(
            QuestionResource::collection($questions),
            __('messages.retrieved', ['model' => __('models/questions.plural')])
        );
    }

    /**
     * Store a newly created Question in storage.
     * POST /questions
     */
    public function store(CreateQuestionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Question $question */
        $question = Question::create($input);

        return $this->sendResponse(
            new QuestionResource($question),
            __('messages.saved', ['model' => __('models/questions.singular')])
        );
    }

    /**
     * Display the specified Question.
     * GET|HEAD /questions/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Question $question */
        $question = Question::find($id);

        if (empty($question)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/questions.singular')])
            );
        }

        return $this->sendResponse(
            new QuestionResource($question),
            __('messages.retrieved', ['model' => __('models/questions.singular')])
        );
    }

    /**
     * Update the specified Question in storage.
     * PUT/PATCH /questions/{id}
     */
    public function update($id, UpdateQuestionAPIRequest $request): JsonResponse
    {
        /** @var Question $question */
        $question = Question::find($id);

        if (empty($question)) {
        return $this->sendError(
            __('messages.not_found', ['model' => __('models/questions.singular')])
        );
        }

        $question->fill($request->all());
        $question->save();

        return $this->sendResponse(
            new QuestionResource($question),
            __('messages.updated', ['model' => __('models/questions.singular')])
        );
    }

    /**
     * Remove the specified Question from storage.
     * DELETE /questions/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Question $question */
        $question = Question::find($id);

        if (empty($question)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/questions.singular')])
            );
        }

        $question->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/questions.singular')])
        );
    }
}
