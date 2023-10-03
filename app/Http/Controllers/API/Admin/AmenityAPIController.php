<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateAmenityAPIRequest;
use App\Http\Requests\API\Admin\UpdateAmenityAPIRequest;
use App\Models\Admin\Amenity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\AmenityResource;

/**
 * Class AmenityAPIController
 */
class AmenityAPIController extends AppBaseController
{
    /**
     * Display a listing of the Amenities.
     * GET|HEAD /amenities
     */
    public function index(Request $request): JsonResponse
    {
        $query = Amenity::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $amenities = $query->get();

        return $this->sendResponse(
            AmenityResource::collection($amenities),
            __('messages.retrieved', ['model' => __('models/amenities.plural')])
        );
    }

    /**
     * Store a newly created Amenity in storage.
     * POST /amenities
     */
    public function store(CreateAmenityAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Amenity $amenity */
        $amenity = Amenity::create($input);

        return $this->sendResponse(
            new AmenityResource($amenity),
            __('messages.saved', ['model' => __('models/amenities.singular')])
        );
    }

    /**
     * Display the specified Amenity.
     * GET|HEAD /amenities/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Amenity $amenity */
        $amenity = Amenity::find($id);

        if (empty($amenity)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/amenities.singular')])
            );
        }

        return $this->sendResponse(
            new AmenityResource($amenity),
            __('messages.retrieved', ['model' => __('models/amenities.singular')])
        );
    }

    /**
     * Update the specified Amenity in storage.
     * PUT/PATCH /amenities/{id}
     */
    public function update($id, UpdateAmenityAPIRequest $request): JsonResponse
    {
        /** @var Amenity $amenity */
        $amenity = Amenity::find($id);

        if (empty($amenity)) {
        return $this->sendError(
            __('messages.not_found', ['model' => __('models/amenities.singular')])
        );
        }

        $amenity->fill($request->all());
        $amenity->save();

        return $this->sendResponse(
            new AmenityResource($amenity),
            __('messages.updated', ['model' => __('models/amenities.singular')])
        );
    }

    /**
     * Remove the specified Amenity from storage.
     * DELETE /amenities/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Amenity $amenity */
        $amenity = Amenity::find($id);

        if (empty($amenity)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/amenities.singular')])
            );
        }

        $amenity->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/amenities.singular')])
        );
    }
}
