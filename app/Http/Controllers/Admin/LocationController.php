<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\LocationDataTable;
use App\Http\Requests\Admin\CreateLocationRequest;
use App\Http\Requests\Admin\UpdateLocationRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Location;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Cache;

class LocationController extends AppBaseController
{
    /**
     * Display a listing of the Location.
     */
    public function index(LocationDataTable $locationDataTable)
    {
        return $locationDataTable->render('admin.locations.index');
    }


    /**
     * Show the form for creating a new Location.
     */
    public function create()
    {
        return view('admin.locations.create');
    }

    /**
     * Store a newly created Location in storage.
     */
    public function store(CreateLocationRequest $request)
    {

        $request_data = $request->except(['_token', 'photos', 'icon']);
        if ($request->hasFile('icon')) {

            $request_data['icon'] = uploadImage('locations', $request->icon);

        }

        if ($request->photos) {

            $request_data['photos'] = saveArrayImage('locations', $request->photos);

        }


        /** @var Location $location */
        $location = Location::create($request_data);
        if ($request->amenity_ids)
            $location->amenities()->sync($request_data['amenity_ids']);

        Cache::flush();
        Flash::success(__('messages.saved', ['model' => __('models/locations.singular')]));

        return redirect(route('admin.locations.index'));
    }

    public function import_get()
    {
        return view('admin.locations.import');
    }

    public function import(Request $request)
    {

        $json_data = json_decode($request->json_locations, true);
//        $amenities=collect($json_data['amenities'])->pluck('type')->toArray();
//        $photos=collect($json_data['photos'])->pluck('url')->toArray();
//        $json_data['photos']=json_encode($photos);
        foreach ($json_data as $item) {
            $item['plugshare_location_id'] = $item['id'];
            $location = Location::where('plugshare_location_id', $item['id'])->first();
            if (!$location) {
                $location = Location::create($item);
            }

            $location->update_stations($location, $item);
        }

        Cache::flush();

        Flash::success(__('messages.saved', ['model' => __('models/locations.singular')]));

        return redirect(route('admin.locations.index'));
    }

    /**
     * Display the specified Location.
     */
    public function show($id)
    {
        /** @var Location $location */
        $location = Location::find($id);

        if (empty($location)) {
            Flash::error(__('models/locations.singular') . ' ' . __('messages.not_found'));

            return redirect(route('admin.locations.index'));
        }

        return view('admin.locations.show')->with('location', $location);
    }

    /**
     * Show the form for editing the specified Location.
     */
    public function edit($id)
    {
        /** @var Location $location */
        $location = Location::find($id);

        if (empty($location)) {
            Flash::error(__('models/locations.singular') . ' ' . __('messages.not_found'));

            return redirect(route('admin.locations.index'));
        }


        return view('admin.locations.edit')->with('location', $location);
    }

    /**
     * Update the specified Location in storage.
     */
    public function update($id, UpdateLocationRequest $request)
    {
        /** @var Location $location */
        $location = Location::find($id);

        if (empty($location)) {
            Flash::error(__('models/locations.singular') . ' ' . __('messages.not_found'));

            return redirect(route('admin.locations.index'));
        }


        if ($request->json_location) {
            $json_data = json_decode($request->json_location, true);
            $amenities = collect($json_data['amenities'])->pluck('type')->toArray();
            $photos = collect($json_data['photos'])->pluck('url')->toArray();
            $json_data['photos'] = json_encode($photos);
            $json_data['plugshare_location_id'] = $json_data['id'];
            $location->fill($json_data);
            $location->save();
            if ($amenities)
                $location->amenities()->sync($amenities);

            $location->update_stations($location, $json_data);

            Flash::success(__('messages.updated', ['model' => __('models/locations.singular')]));

            return redirect(route('admin.locations.index'));
        }

        $request_data = $request->except(['_token', 'photos', 'icon']);
        if ($request->hasFile('icon')) {

            $request_data['icon'] = uploadImage('locations', $request->icon);

        }
        if ($request->photos) {

            $request_data['photos'] = saveArrayImage('locations', $request->photos);

        }


        $location->fill($request_data);
        $location->save();

        if ($request->amenity_ids)
            $location->amenities()->sync($request_data['amenity_ids']);

        Cache::flush();
        Flash::success(__('messages.updated', ['model' => __('models/locations.singular')]));

        return redirect(route('admin.locations.index'));
    }

    /**
     * Remove the specified Location from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Location $location */
        $location = Location::find($id);

        if (empty($location)) {
            Flash::error(__('models/locations.singular') . ' ' . __('messages.not_found'));

            return redirect(route('admin.locations.index'));
        }

        $location->delete();
        Cache::flush();
        Flash::success(__('messages.deleted', ['model' => __('models/locations.singular')]));

        return redirect(route('admin.locations.index'));
    }
}
