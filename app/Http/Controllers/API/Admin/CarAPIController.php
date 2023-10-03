<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateCarAPIRequest;
use App\Http\Requests\API\Admin\UpdateCarAPIRequest;
use App\Models\Admin\Car;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\CarResource;

/**
 * Class CarAPIController
 */
class CarAPIController extends AppBaseController
{
    /**
     * Display a listing of the Cars.
     * GET|HEAD /cars
     */
    public function index(Request $request): JsonResponse
    {
        $query = Car::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
        $cars = $query->get();

        return $this->sendResponse(
            CarResource::collection($cars),
            __('messages.retrieved', ['model' => __('models/cars.plural')])
        );
    }

    /**
     * Store a newly created Car in storage.
     * POST /cars
     */
    public function store(CreateCarAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Car $car */
        $car = Car::create($input);

        return $this->sendResponse(
            new CarResource($car),
            __('messages.saved', ['model' => __('models/cars.singular')])
        );
    }

    /**
     * Display the specified Car.
     * GET|HEAD /cars/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Car $car */
        $car = Car::find($id);

        if (empty($car)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/cars.singular')])
            );
        }

        return $this->sendResponse(
            new CarResource($car),
            __('messages.retrieved', ['model' => __('models/cars.singular')])
        );
    }

    /**
     * Update the specified Car in storage.
     * PUT/PATCH /cars/{id}
     */
    public function update($id, UpdateCarAPIRequest $request): JsonResponse
    {
        /** @var Car $car */
        $car = Car::find($id);

        if (empty($car)) {
        return $this->sendError(
            __('messages.not_found', ['model' => __('models/cars.singular')])
        );
        }

        $car->fill($request->all());
        $car->save();

        return $this->sendResponse(
            new CarResource($car),
            __('messages.updated', ['model' => __('models/cars.singular')])
        );
    }

    /**
     * Remove the specified Car from storage.
     * DELETE /cars/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Car $car */
        $car = Car::find($id);

        if (empty($car)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/cars.singular')])
            );
        }

        $car->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/cars.singular')])
        );
    }
}
