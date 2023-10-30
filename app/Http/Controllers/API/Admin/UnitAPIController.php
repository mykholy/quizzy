<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateUnitAPIRequest;
use App\Http\Requests\API\Admin\UpdateUnitAPIRequest;
use App\Models\Admin\Unit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\UnitResource;

/**
 * Class UnitAPIController
 */
class UnitAPIController extends AppBaseController
{
    /**
     * Display a listing of the Units.
     * GET|HEAD /units
     */
    public function index(Request $request): JsonResponse
    {
        $query = Unit::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $units = $query->get();

        return $this->sendResponse(
            UnitResource::collection($units),
            __('messages.retrieved', ['model' => __('models/units.plural')])
        );
    }

    /**
     * Store a newly created Unit in storage.
     * POST /units
     */
    public function store(CreateUnitAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Unit $unit */
        $unit = Unit::create($input);

        return $this->sendResponse(
            new UnitResource($unit),
            __('messages.saved', ['model' => __('models/units.singular')])
        );
    }

    /**
     * Display the specified Unit.
     * GET|HEAD /units/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Unit $unit */
        $unit = Unit::find($id);

        if (empty($unit)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/units.singular')])
            );
        }

        return $this->sendResponse(
            new UnitResource($unit),
            __('messages.retrieved', ['model' => __('models/units.singular')])
        );
    }

    /**
     * Update the specified Unit in storage.
     * PUT/PATCH /units/{id}
     */
    public function update($id, UpdateUnitAPIRequest $request): JsonResponse
    {
        /** @var Unit $unit */
        $unit = Unit::find($id);

        if (empty($unit)) {
        return $this->sendError(
            __('messages.not_found', ['model' => __('models/units.singular')])
        );
        }

        $unit->fill($request->all());
        $unit->save();

        return $this->sendResponse(
            new UnitResource($unit),
            __('messages.updated', ['model' => __('models/units.singular')])
        );
    }

    /**
     * Remove the specified Unit from storage.
     * DELETE /units/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Unit $unit */
        $unit = Unit::find($id);

        if (empty($unit)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/units.singular')])
            );
        }

        $unit->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/units.singular')])
        );
    }
}
