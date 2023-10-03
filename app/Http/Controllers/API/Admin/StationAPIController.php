<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateStationAPIRequest;
use App\Http\Requests\API\Admin\UpdateStationAPIRequest;
use App\Models\Admin\Station;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\StationResource;

/**
 * Class StationAPIController
 */
class StationAPIController extends AppBaseController
{
    /**
     * Display a listing of the Stations.
     * GET|HEAD /stations
     */
    public function index(Request $request): JsonResponse
    {
        $query = Station::query();

        if ($request->get('latitude')) {
            $query->where('latitude',$request->get('latitude'));
        }
        if ($request->get('longitude')) {
            $query->where('longitude',$request->get('longitude'));
        }
        if ($request->get('name')) {
            $query->orWhere('name','like','%'.$request->get('name').'%');
        }

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        $stations = $query->get();

        return $this->sendResponse(
            StationResource::collection($stations),
            __('messages.retrieved', ['model' => __('models/stations.plural')])
        );
    }

    /**
     * Store a newly created Station in storage.
     * POST /stations
     */
    public function store(CreateStationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Station $station */
        $station = Station::create($input);

        return $this->sendResponse(
            new StationResource($station),
            __('messages.saved', ['model' => __('models/stations.singular')])
        );
    }

    /**
     * Display the specified Station.
     * GET|HEAD /stations/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Station $station */
        $station = Station::with('location')->find($id);

        if (empty($station)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/stations.singular')])
            );
        }

        return $this->sendResponse(
            new StationResource($station),
            __('messages.retrieved', ['model' => __('models/stations.singular')])
        );
    }

    /**
     * Update the specified Station in storage.
     * PUT/PATCH /stations/{id}
     */
    public function update($id, UpdateStationAPIRequest $request): JsonResponse
    {
        /** @var Station $station */
        $station = Station::find($id);

        if (empty($station)) {
        return $this->sendError(
            __('messages.not_found', ['model' => __('models/stations.singular')])
        );
        }

        $station->fill($request->all());
        $station->save();

        return $this->sendResponse(
            new StationResource($station),
            __('messages.updated', ['model' => __('models/stations.singular')])
        );
    }

    /**
     * Remove the specified Station from storage.
     * DELETE /stations/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Station $station */
        $station = Station::find($id);

        if (empty($station)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/stations.singular')])
            );
        }

        $station->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/stations.singular')])
        );
    }
}
