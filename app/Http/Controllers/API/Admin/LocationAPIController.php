<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateLocationAPIRequest;
use App\Http\Requests\API\Admin\UpdateLocationAPIRequest;
use App\Models\Admin\Client;
use App\Models\Admin\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\LocationResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Class LocationAPIController
 */
class LocationAPIController extends AppBaseController
{
    /**
     * Display a listing of the Locations.
     * GET|HEAD /locations
     */
    public function index(Request $request): JsonResponse
    {
        $data=$request->query();
       $cache_key= md5(json_encode($data));
        return Cache::remember("app.locations.".$cache_key, 86400, function () use ($request) {

        $latitude = $request->get('latitude', '30.033333');
        $longitude = $request->get('longitude', '31.233334');
        $limit = $request->get('limit', 5000)??500;
        $distance = $request->get('distance', 2000)??2000;
//        $limit = 800;
//        $distance = 3000;
        $name=$request->get('name');
        $query = Location::search($name);
//            ->whereHas('stations', function ($q) {
//            $q->when(\request('connector_id'), function ($query) {
//                $query->where('outlets', "connector_id:" . \request('connector_id'));
//            });
//        })
//            ->select(DB::raw("*, ( 6371 * acos( cos( radians('$latitude') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( latitude ) ) ) ) AS distance"))->havingRaw('distance <= ' . $distance);

//        if ($request->get('latitude')) {
//            $query->where('latitude', $latitude);
//        }
//        if ($request->get('longitude')) {
//            $query->where('longitude', $longitude);
//        }
//        if ($request->get('name')) {
//            $query->orWhere('name', 'like', '%' . $request->get('name') . '%');
//        }
//        if ($request->get('description')) {
//            $query->orWhere('description', 'like', '%' . $request->get('description') . '%');
//        }
//        if ($request->get('address')) {
//            $query->orWhere('address', 'like', '%' . $request->get('address') . '%');
//        }

//        if ($request->get('skip') && $limit) {
//            $query->skip($request->get('skip'));
//        }


        $locations = $query->paginate($limit);


        return $this->sendResponse(

            LocationResource::collection($locations),
            __('messages.retrieved', ['model' => __('models/locations.plural')])
        );

        });

    }

    /**
     * Store a newly created Location in storage.
     * POST /locations
     */
    public function store(CreateLocationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Location $location */
        $location = Location::create($input);

        return $this->sendResponse(
            new LocationResource($location),
            __('messages.saved', ['model' => __('models/locations.singular')])
        );
    }

    /**
     * Display the specified Location.
     * GET|HEAD /locations/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Location $location */
        $location = Location::with(['amenities', 'stations'])->find($id);

        if (empty($location)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/locations.singular')])
            );
        }

        return $this->sendResponse(
            new LocationResource($location),
            __('messages.retrieved', ['model' => __('models/locations.singular')])
        );
    }

    /**
     * Update the specified Location in storage.
     * PUT/PATCH /locations/{id}
     */
    public function update($id, UpdateLocationAPIRequest $request): JsonResponse
    {
        /** @var Location $location */
        $location = Location::find($id);

        if (empty($location)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/locations.singular')])
            );
        }

        $location->fill($request->all());
        $location->save();

        return $this->sendResponse(
            new LocationResource($location),
            __('messages.updated', ['model' => __('models/locations.singular')])
        );
    }

    /**
     * Remove the specified Location from storage.
     * DELETE /locations/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Location $location */
        $location = Location::find($id);

        if (empty($location)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/locations.singular')])
            );
        }

        $location->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/locations.singular')])
        );
    }

    public function make_favorite($id)
    {
        /** @var Location $location */
        $location = Location::find($id);


        if (empty($location)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/locations.singular')])
            );
        }

        $client = Client::find(auth('api-client')->id());
        $client->toggleFavorite($location);
        $message = $client->hasFavorited($location) ? 'Added to Favorite' : 'Deleted from Favorite';

        Cache::forget('app.locations');
        return $this->sendResponse(
            new LocationResource(Location::with(['amenities', 'stations'])->find($id)),
            $message
        );
    }

    public function get_all_favorites()
    {

        $favorites_Posts = auth('api-client')->user()->getFavoriteItems(Location::class)->paginate(10);


        if (empty($favorites_Posts)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/locations.singular')])
            );
        }

        return $this->sendResponse(
            LocationResource::collection($favorites_Posts)->response()->getData(true),
            __('lang.api.retrieved', ['model' => __('models/locations.singular')])
        );
    }

}
