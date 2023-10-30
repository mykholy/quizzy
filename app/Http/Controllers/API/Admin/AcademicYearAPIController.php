<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateAcademicYearAPIRequest;
use App\Http\Requests\API\Admin\UpdateAcademicYearAPIRequest;
use App\Models\Admin\AcademicYear;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\AcademicYearResource;

/**
 * Class AcademicYearAPIController
 */
class AcademicYearAPIController extends AppBaseController
{
    /**
     * Display a listing of the AcademicYears.
     * GET|HEAD /academic-years
     */
    public function index(Request $request): JsonResponse
    {
        $query = AcademicYear::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $academicYears = $query->get();

        return $this->sendResponse(
            AcademicYearResource::collection($academicYears),
            __('messages.retrieved', ['model' => __('models/academicYears.plural')])
        );
    }

    /**
     * Store a newly created AcademicYear in storage.
     * POST /academic-years
     */
    public function store(CreateAcademicYearAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var AcademicYear $academicYear */
        $academicYear = AcademicYear::create($input);

        return $this->sendResponse(
            new AcademicYearResource($academicYear),
            __('messages.saved', ['model' => __('models/academicYears.singular')])
        );
    }

    /**
     * Display the specified AcademicYear.
     * GET|HEAD /academic-years/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var AcademicYear $academicYear */
        $academicYear = AcademicYear::find($id);

        if (empty($academicYear)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/academicYears.singular')])
            );
        }

        return $this->sendResponse(
            new AcademicYearResource($academicYear),
            __('messages.retrieved', ['model' => __('models/academicYears.singular')])
        );
    }

    /**
     * Update the specified AcademicYear in storage.
     * PUT/PATCH /academic-years/{id}
     */
    public function update($id, UpdateAcademicYearAPIRequest $request): JsonResponse
    {
        /** @var AcademicYear $academicYear */
        $academicYear = AcademicYear::find($id);

        if (empty($academicYear)) {
        return $this->sendError(
            __('messages.not_found', ['model' => __('models/academicYears.singular')])
        );
        }

        $academicYear->fill($request->all());
        $academicYear->save();

        return $this->sendResponse(
            new AcademicYearResource($academicYear),
            __('messages.updated', ['model' => __('models/academicYears.singular')])
        );
    }

    /**
     * Remove the specified AcademicYear from storage.
     * DELETE /academic-years/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var AcademicYear $academicYear */
        $academicYear = AcademicYear::find($id);

        if (empty($academicYear)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/academicYears.singular')])
            );
        }

        $academicYear->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/academicYears.singular')])
        );
    }
}
