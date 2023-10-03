<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ConnectorDataTable;
use App\Http\Requests\Admin\CreateConnectorRequest;
use App\Http\Requests\Admin\UpdateConnectorRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Connector;
use Illuminate\Http\Request;
use Flash;

class ConnectorController extends AppBaseController
{
    /**
     * Display a listing of the Connector.
     */
    public function index(ConnectorDataTable $connectorDataTable)
    {
    return $connectorDataTable->render('admin.connectors.index');
    }


    /**
     * Show the form for creating a new Connector.
     */
    public function create()
    {
        return view('admin.connectors.create');
    }

    /**
     * Store a newly created Connector in storage.
     */
    public function store(CreateConnectorRequest $request)
    {

        $request_data = $request->except(['_token', 'photo']);
        if ($request->hasFile('photo')) {

             $request_data['photo'] = uploadImage('connectors', $request->photo);

        }

        /** @var Connector $connector */
        $connector = Connector::create($request_data);

        Flash::success(__('messages.saved', ['model' => __('models/connectors.singular')]));

        return redirect(route('admin.connectors.index'));
    }

    /**
     * Display the specified Connector.
     */
    public function show($id)
    {
        /** @var Connector $connector */
        $connector = Connector::find($id);

        if (empty($connector)) {
            Flash::error(__('models/connectors.singular').' '.__('messages.not_found'));

            return redirect(route('admin.connectors.index'));
        }

        return view('admin.connectors.show')->with('connector', $connector);
    }

    /**
     * Show the form for editing the specified Connector.
     */
    public function edit($id)
    {
        /** @var Connector $connector */
        $connector = Connector::find($id);

        if (empty($connector)) {
            Flash::error(__('models/connectors.singular').' '.__('messages.not_found'));

            return redirect(route('admin.connectors.index'));
        }

        return view('admin.connectors.edit')->with('connector', $connector);
    }

    /**
     * Update the specified Connector in storage.
     */
    public function update($id, UpdateConnectorRequest $request)
    {
        /** @var Connector $connector */
        $connector = Connector::find($id);

        if (empty($connector)) {
            Flash::error(__('models/connectors.singular').' '.__('messages.not_found'));

            return redirect(route('admin.connectors.index'));
        }

        $request_data = $request->except(['_token', 'photo']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('connectors', $request->photo);
        }

        $connector->fill($request_data);
        $connector->save();

        Flash::success(__('messages.updated', ['model' => __('models/connectors.singular')]));

        return redirect(route('admin.connectors.index'));
    }

    /**
     * Remove the specified Connector from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Connector $connector */
        $connector = Connector::find($id);

        if (empty($connector)) {
            Flash::error(__('models/connectors.singular').' '.__('messages.not_found'));

            return redirect(route('admin.connectors.index'));
        }

        $connector->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/connectors.singular')]));

        return redirect(route('admin.connectors.index'));
    }
}
