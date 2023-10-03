<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\StationDataTable;
use App\Http\Requests\Admin\CreateStationRequest;
use App\Http\Requests\Admin\UpdateStationRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Station;
use Illuminate\Http\Request;
use Flash;

class StationController extends AppBaseController
{
    /**
     * Display a listing of the Station.
     */
    public function index(StationDataTable $stationDataTable)
    {
    return $stationDataTable->render('admin.stations.index');
    }


    /**
     * Show the form for creating a new Station.
     */
    public function create()
    {
        return view('admin.stations.create');
    }

    /**
     * Store a newly created Station in storage.
     */
    public function store(CreateStationRequest $request)
    {

        $request_data = $request->except(['_token', 'photo']);
        if ($request->hasFile('photo')) {

             $request_data['photo'] = uploadImage('stations', $request->photo);

        }


        $request_data['outlets']=json_encode($request->outlets);

        /** @var Station $station */
        $station = Station::create($request_data);

        Flash::success(__('messages.saved', ['model' => __('models/stations.singular')]));

        return redirect(route('admin.stations.index'));
    }

    /**
     * Display the specified Station.
     */
    public function show($id)
    {
        /** @var Station $station */
        $station = Station::find($id);

        if (empty($station)) {
            Flash::error(__('models/stations.singular').' '.__('messages.not_found'));

            return redirect(route('admin.stations.index'));
        }

        return view('admin.stations.show')->with('station', $station);
    }

    /**
     * Show the form for editing the specified Station.
     */
    public function edit($id)
    {
        /** @var Station $station */
        $station = Station::find($id);

        if (empty($station)) {
            Flash::error(__('models/stations.singular').' '.__('messages.not_found'));

            return redirect(route('admin.stations.index'));
        }

        return view('admin.stations.edit')->with('station', $station);
    }

    /**
     * Update the specified Station in storage.
     */
    public function update($id, UpdateStationRequest $request)
    {
        /** @var Station $station */
        $station = Station::find($id);

        if (empty($station)) {
            Flash::error(__('models/stations.singular').' '.__('messages.not_found'));

            return redirect(route('admin.stations.index'));
        }

        $request_data = $request->except(['_token', 'photo']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('stations', $request->photo);
        }
        $request_data['outlets']=json_encode($request->outlets);
        $station->fill($request_data);
        $station->save();

        Flash::success(__('messages.updated', ['model' => __('models/stations.singular')]));

        return redirect(route('admin.stations.index'));
    }

    /**
     * Remove the specified Station from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Station $station */
        $station = Station::find($id);

        if (empty($station)) {
            Flash::error(__('models/stations.singular').' '.__('messages.not_found'));

            return redirect(route('admin.stations.index'));
        }

        $station->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/stations.singular')]));

        return redirect(route('admin.stations.index'));
    }
}
