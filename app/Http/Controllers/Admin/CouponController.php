<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\CouponDataTable;
use App\Http\Requests\Admin\CreateCouponRequest;
use App\Http\Requests\Admin\UpdateCouponRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CouponController extends AppBaseController
{
    /**
     * Display a listing of the Coupon.
     */
    public function index(CouponDataTable $couponDataTable)
    {
    return $couponDataTable->render('admin.coupons.index');
    }


    /**
     * Show the form for creating a new Coupon.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created Coupon in storage.
     */
    public function store(CreateCouponRequest $request)
    {

        $request_data = $request->except(['_token', 'photo']);
        if ($request->hasFile('photo')) {

             $request_data['photo'] = uploadImage('coupons', $request->photo);

        }

        if($request->bulk){
            $codes=[];
            for ($i=0; $i < $request->count;$i++){
                $code=Str::random(10);
                $data=[
                    'title' =>'Bulk '.$i,
                    'code' =>$code,
                    'value' =>$request->value,
                ];
                $coupon = Coupon::create($data);
            }
            session()->flash('success',__('messages.saved', ['model' => __('models/coupons.singular')]));

            return redirect(route('admin.coupons.index',compact('codes')));
        }

        /** @var Coupon $coupon */
        $coupon = Coupon::create($request_data);

        session()->flash('success',__('messages.saved', ['model' => __('models/coupons.singular')]));

        return redirect(route('admin.coupons.index'));
    }

    /**
     * Display the specified Coupon.
     */
    public function show($id)
    {
        /** @var Coupon $coupon */
        $coupon = Coupon::find($id);

        if (empty($coupon)) {
            session()->flash('error',__('models/coupons.singular').' '.__('messages.not_found'));


            return redirect(route('admin.coupons.index'));
        }

        return view('admin.coupons.show')->with('coupon', $coupon);
    }

    /**
     * Show the form for editing the specified Coupon.
     */
    public function edit($id)
    {
        /** @var Coupon $coupon */
        $coupon = Coupon::find($id);

        if (empty($coupon)) {
            session()->flash('error',__('models/coupons.singular').' '.__('messages.not_found'));


            return redirect(route('admin.coupons.index'));
        }

        return view('admin.coupons.edit')->with('coupon', $coupon);
    }

    /**
     * Update the specified Coupon in storage.
     */
    public function update($id, UpdateCouponRequest $request)
    {
        /** @var Coupon $coupon */
        $coupon = Coupon::find($id);

        if (empty($coupon)) {
            session()->flash('error',__('models/coupons.singular').' '.__('messages.not_found'));


            return redirect(route('admin.coupons.index'));
        }

        $request_data = $request->except(['_token', 'photo']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('coupons', $request->photo);
        }

        $coupon->fill($request_data);
        $coupon->save();

        session()->flash('success',__('messages.updated', ['model' => __('models/coupons.singular')]));

        return redirect(route('admin.coupons.index'));
    }

    /**
     * Remove the specified Coupon from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Coupon $coupon */
        $coupon = Coupon::find($id);

        if (empty($coupon)) {
            session()->flash('error',__('models/coupons.singular').' '.__('messages.not_found'));


            return redirect(route('admin.coupons.index'));
        }

        $coupon->delete();

        session()->flash('success',__('messages.deleted', ['model' => __('models/coupons.singular')]));


        return redirect(route('admin.coupons.index'));
    }
}
