<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateAdAPIRequest;
use App\Http\Requests\API\Admin\UpdateAdAPIRequest;
use App\Models\Admin\Ad;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\AdResource;

/**
 * Class AdAPIController
 */
class AdAPIController extends AppBaseController
{
    /**
     * Display a listing of the Ads.
     * GET|HEAD /ads
     */
    public function index(Request $request): JsonResponse
    {
        $query = Ad::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $ads = $query->get();

        return $this->sendResponse(
            AdResource::collection($ads),
            __('messages.retrieved', ['model' => __('models/ads.plural')])
        );
    }

    /**
     * Store a newly created Ad in storage.
     * POST /ads
     */
    public function store(CreateAdAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Ad $ad */
        $ad = Ad::create($input);

        return $this->sendResponse(
            new AdResource($ad),
            __('messages.saved', ['model' => __('models/ads.singular')])
        );
    }

    /**
     * Display the specified Ad.
     * GET|HEAD /ads/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Ad $ad */
        $ad = Ad::find($id);

        if (empty($ad)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/ads.singular')])
            );
        }

        return $this->sendResponse(
            new AdResource($ad),
            __('messages.retrieved', ['model' => __('models/ads.singular')])
        );
    }

    /**
     * Update the specified Ad in storage.
     * PUT/PATCH /ads/{id}
     */
    public function update($id, UpdateAdAPIRequest $request): JsonResponse
    {
        /** @var Ad $ad */
        $ad = Ad::find($id);

        if (empty($ad)) {
        return $this->sendError(
            __('messages.not_found', ['model' => __('models/ads.singular')])
        );
        }

        $ad->fill($request->all());
        $ad->save();

        return $this->sendResponse(
            new AdResource($ad),
            __('messages.updated', ['model' => __('models/ads.singular')])
        );
    }

    /**
     * Remove the specified Ad from storage.
     * DELETE /ads/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Ad $ad */
        $ad = Ad::find($id);

        if (empty($ad)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/ads.singular')])
            );
        }

        $ad->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/ads.singular')])
        );
    }
}
