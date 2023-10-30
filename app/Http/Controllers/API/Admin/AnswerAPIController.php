<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateAnswerAPIRequest;
use App\Http\Requests\API\Admin\UpdateAnswerAPIRequest;
use App\Models\Admin\Answer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\AnswerResource;

/**
 * Class AnswerAPIController
 */
class AnswerAPIController extends AppBaseController
{
    /**
     * Display a listing of the Answers.
     * GET|HEAD /answers
     */
    public function index(Request $request): JsonResponse
    {
        $query = Answer::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $answers = $query->get();

        return $this->sendResponse(
            AnswerResource::collection($answers),
            __('messages.retrieved', ['model' => __('models/answers.plural')])
        );
    }

    /**
     * Store a newly created Answer in storage.
     * POST /answers
     */
    public function store(CreateAnswerAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Answer $answer */
        $answer = Answer::create($input);

        return $this->sendResponse(
            new AnswerResource($answer),
            __('messages.saved', ['model' => __('models/answers.singular')])
        );
    }

    /**
     * Display the specified Answer.
     * GET|HEAD /answers/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Answer $answer */
        $answer = Answer::find($id);

        if (empty($answer)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/answers.singular')])
            );
        }

        return $this->sendResponse(
            new AnswerResource($answer),
            __('messages.retrieved', ['model' => __('models/answers.singular')])
        );
    }

    /**
     * Update the specified Answer in storage.
     * PUT/PATCH /answers/{id}
     */
    public function update($id, UpdateAnswerAPIRequest $request): JsonResponse
    {
        /** @var Answer $answer */
        $answer = Answer::find($id);

        if (empty($answer)) {
        return $this->sendError(
            __('messages.not_found', ['model' => __('models/answers.singular')])
        );
        }

        $answer->fill($request->all());
        $answer->save();

        return $this->sendResponse(
            new AnswerResource($answer),
            __('messages.updated', ['model' => __('models/answers.singular')])
        );
    }

    /**
     * Remove the specified Answer from storage.
     * DELETE /answers/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Answer $answer */
        $answer = Answer::find($id);

        if (empty($answer)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/answers.singular')])
            );
        }

        $answer->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/answers.singular')])
        );
    }
}
