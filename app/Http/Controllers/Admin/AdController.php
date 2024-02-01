<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\AdDataTable;
use App\Http\Requests\Admin\CreateAdRequest;
use App\Http\Requests\Admin\UpdateAdRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Ad;
use Illuminate\Http\Request;


class AdController extends AppBaseController
{
    /**
     * Display a listing of the Ad.
     */
    public function index(AdDataTable $adDataTable)
    {
    return $adDataTable->render('admin.ads.index');
    }


    /**
     * Show the form for creating a new Ad.
     */
    public function create()
    {
        return view('admin.ads.create');
    }

    /**
     * Store a newly created Ad in storage.
     */
    public function store(CreateAdRequest $request)
    {

        $request_data = $request->except(['_token', 'photo']);
        if ($request->hasFile('photo')) {

             $request_data['photo'] = uploadImage('ads', $request->photo);

        }

        /** @var Ad $ad */
        $ad = Ad::create($request_data);

        session()->flash('success',__('messages.saved', ['model' => __('models/ads.singular')]));

        return redirect(route('admin.ads.index'));
    }

    /**
     * Display the specified Ad.
     */
    public function show($id)
    {
        /** @var Ad $ad */
        $ad = Ad::find($id);

        if (empty($ad)) {
            session()->flash('error',__('models/ads.singular').' '.__('messages.not_found'));


            return redirect(route('admin.ads.index'));
        }

        return view('admin.ads.show')->with('ad', $ad);
    }

    /**
     * Show the form for editing the specified Ad.
     */
    public function edit($id)
    {
        /** @var Ad $ad */
        $ad = Ad::find($id);

        if (empty($ad)) {
            session()->flash('error',__('models/ads.singular').' '.__('messages.not_found'));


            return redirect(route('admin.ads.index'));
        }

        return view('admin.ads.edit')->with('ad', $ad);
    }

    /**
     * Update the specified Ad in storage.
     */
    public function update($id, UpdateAdRequest $request)
    {
        /** @var Ad $ad */
        $ad = Ad::find($id);

        if (empty($ad)) {
            session()->flash('error',__('models/ads.singular').' '.__('messages.not_found'));


            return redirect(route('admin.ads.index'));
        }

        $request_data = $request->except(['_token', 'photo']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('ads', $request->photo);
        }

        $ad->fill($request_data);
        $ad->save();

        session()->flash('success',__('messages.updated', ['model' => __('models/ads.singular')]));

        return redirect(route('admin.ads.index'));
    }

    /**
     * Remove the specified Ad from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Ad $ad */
        $ad = Ad::find($id);

        if (empty($ad)) {
            session()->flash('error',__('models/ads.singular').' '.__('messages.not_found'));


            return redirect(route('admin.ads.index'));
        }

        $ad->delete();

        session()->flash('success',__('messages.deleted', ['model' => __('models/ads.singular')]));


        return redirect(route('admin.ads.index'));
    }
}
