<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateSubjectAPIRequest;
use App\Http\Requests\API\Admin\UpdateSubjectAPIRequest;
use App\Models\Admin\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\SubjectResource;

/**
 * Class SubjectAPIController
 */
class SubjectAPIController extends AppBaseController
{
    /**
     * Display a listing of the Subjects.
     * GET|HEAD /subjects
     */
    public function index(Request $request): JsonResponse
    {
        $query = Subject::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $subjects = $query
            ->when(\request('semester'), function ($q) {
                $q->where('semester', \request('semester'));
            })
            ->when(\request('academic_year_id'), function ($q) {
                $q->where('academic_year_id', \request('academic_year_id'));
            })
            ->get();

        return $this->sendResponse(
            SubjectResource::collection($subjects),
            __('messages.retrieved', ['model' => __('models/subjects.plural')])
        );
    }

    /**
     * Store a newly created Subject in storage.
     * POST /subjects
     */
    public function store(CreateSubjectAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Subject $subject */
        $subject = Subject::create($input);

        return $this->sendResponse(
            new SubjectResource($subject),
            __('messages.saved', ['model' => __('models/subjects.singular')])
        );
    }

    /**
     * Display the specified Subject.
     * GET|HEAD /subjects/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Subject $subject */
        $subject = Subject::with('academicYear')->find($id);

        if (empty($subject)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/subjects.singular')])
            );
        }

        return $this->sendResponse(
            new SubjectResource($subject),
            __('messages.retrieved', ['model' => __('models/subjects.singular')])
        );
    }

    /**
     * Update the specified Subject in storage.
     * PUT/PATCH /subjects/{id}
     */
    public function update($id, UpdateSubjectAPIRequest $request): JsonResponse
    {
        /** @var Subject $subject */
        $subject = Subject::find($id);

        if (empty($subject)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/subjects.singular')])
            );
        }

        $subject->fill($request->all());
        $subject->save();

        return $this->sendResponse(
            new SubjectResource($subject),
            __('messages.updated', ['model' => __('models/subjects.singular')])
        );
    }

    /**
     * Remove the specified Subject from storage.
     * DELETE /subjects/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Subject $subject */
        $subject = Subject::find($id);

        if (empty($subject)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/subjects.singular')])
            );
        }

        $subject->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/subjects.singular')])
        );
    }
}
