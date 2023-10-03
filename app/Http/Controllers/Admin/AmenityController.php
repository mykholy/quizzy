<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\AmenityDataTable;
use App\Http\Requests\Admin\CreateAmenityRequest;
use App\Http\Requests\Admin\UpdateAmenityRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Amenity;
use Illuminate\Http\Request;
use Flash;

class AmenityController extends AppBaseController
{
    /**
     * Display a listing of the Amenity.
     */
    public function index(AmenityDataTable $amenityDataTable)
    {
    return $amenityDataTable->render('admin.amenities.index');
    }


    /**
     * Show the form for creating a new Amenity.
     */
    public function create()
    {
        return view('admin.amenities.create');
    }

    /**
     * Store a newly created Amenity in storage.
     */
    public function store(CreateAmenityRequest $request)
    {

        $request_data = $request->except(['_token', 'photo']);
        if ($request->hasFile('photo')) {

             $request_data['photo'] = uploadImage('amenities', $request->photo);

        }

        /** @var Amenity $amenity */
        $amenity = Amenity::create($request_data);

        Flash::success(__('messages.saved', ['model' => __('models/amenities.singular')]));

        return redirect(route('admin.amenities.index'));
    }

    /**
     * Display the specified Amenity.
     */
    public function show($id)
    {
        /** @var Amenity $amenity */
        $amenity = Amenity::find($id);

        if (empty($amenity)) {
            Flash::error(__('models/amenities.singular').' '.__('messages.not_found'));

            return redirect(route('admin.amenities.index'));
        }

        return view('admin.amenities.show')->with('amenity', $amenity);
    }

    /**
     * Show the form for editing the specified Amenity.
     */
    public function edit($id)
    {
        /** @var Amenity $amenity */
        $amenity = Amenity::find($id);

        if (empty($amenity)) {
            Flash::error(__('models/amenities.singular').' '.__('messages.not_found'));

            return redirect(route('admin.amenities.index'));
        }

        return view('admin.amenities.edit')->with('amenity', $amenity);
    }

    /**
     * Update the specified Amenity in storage.
     */
    public function update($id, UpdateAmenityRequest $request)
    {
        /** @var Amenity $amenity */
        $amenity = Amenity::find($id);

        if (empty($amenity)) {
            Flash::error(__('models/amenities.singular').' '.__('messages.not_found'));

            return redirect(route('admin.amenities.index'));
        }

        $request_data = $request->except(['_token', 'photo']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('amenities', $request->photo);
        }

        $amenity->fill($request_data);
        $amenity->save();

        Flash::success(__('messages.updated', ['model' => __('models/amenities.singular')]));

        return redirect(route('admin.amenities.index'));
    }

    /**
     * Remove the specified Amenity from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Amenity $amenity */
        $amenity = Amenity::find($id);

        if (empty($amenity)) {
            Flash::error(__('models/amenities.singular').' '.__('messages.not_found'));

            return redirect(route('admin.amenities.index'));
        }

        $amenity->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/amenities.singular')]));

        return redirect(route('admin.amenities.index'));
    }
}
