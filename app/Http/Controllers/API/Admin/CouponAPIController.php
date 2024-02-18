<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateCouponAPIRequest;
use App\Http\Requests\API\Admin\UpdateCouponAPIRequest;
use App\Models\Admin\Coupon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\CouponResource;

/**
 * Class CouponAPIController
 */
class CouponAPIController extends AppBaseController
{
    /**
     * Display a listing of the Coupons.
     * GET|HEAD /coupons
     */
    public function index(Request $request): JsonResponse
    {
        $query = Coupon::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $coupons = $query->get();

        return $this->sendResponse(
            CouponResource::collection($coupons),
            __('messages.retrieved', ['model' => __('models/coupons.plural')])
        );
    }

    /**
     * Store a newly created Coupon in storage.
     * POST /coupons
     */
    public function store(CreateCouponAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Coupon $coupon */
        $coupon = Coupon::create($input);

        return $this->sendResponse(
            new CouponResource($coupon),
            __('messages.saved', ['model' => __('models/coupons.singular')])
        );
    }

    /**
     * Display the specified Coupon.
     * GET|HEAD /coupons/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Coupon $coupon */
        $coupon = Coupon::find($id);

        if (empty($coupon)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/coupons.singular')])
            );
        }

        return $this->sendResponse(
            new CouponResource($coupon),
            __('messages.retrieved', ['model' => __('models/coupons.singular')])
        );
    }

    /**
     * Update the specified Coupon in storage.
     * PUT/PATCH /coupons/{id}
     */
    public function update($id, UpdateCouponAPIRequest $request): JsonResponse
    {
        /** @var Coupon $coupon */
        $coupon = Coupon::find($id);

        if (empty($coupon)) {
        return $this->sendError(
            __('messages.not_found', ['model' => __('models/coupons.singular')])
        );
        }

        $coupon->fill($request->all());
        $coupon->save();

        return $this->sendResponse(
            new CouponResource($coupon),
            __('messages.updated', ['model' => __('models/coupons.singular')])
        );
    }

    /**
     * Remove the specified Coupon from storage.
     * DELETE /coupons/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Coupon $coupon */
        $coupon = Coupon::find($id);

        if (empty($coupon)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/coupons.singular')])
            );
        }

        $coupon->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/coupons.singular')])
        );
    }
}
