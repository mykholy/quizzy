<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ClientDataTable;
use App\Http\Requests\Admin\CreateClientRequest;
use App\Http\Requests\Admin\UpdateClientRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Client;
use Illuminate\Http\Request;
use Flash;

class ClientController extends AppBaseController
{
    /**
     * Display a listing of the Client.
     */
    public function index(ClientDataTable $clientDataTable)
    {
        return $clientDataTable->render('admin.clients.index');
    }


    /**
     * Show the form for creating a new Client.
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created Client in storage.
     */
    public function store(CreateClientRequest $request)
    {
        $request_data = $request->except(['_token', 'photo']);
        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('clients', $request->photo);
        }

        /** @var Client $client */
        $client = Client::create($request_data);

        Flash::success(__('messages.saved', ['model' => __('models/clients.singular')]));

        return redirect(route('admin.clients.index'));
    }

    /**
     * Display the specified Client.
     */
    public function show($id)
    {
        /** @var Client $client */
        $client = Client::find($id);

        if (empty($client)) {
            Flash::error(__('models/clients.singular') . ' ' . __('messages.not_found'));

            return redirect(route('admin.clients.index'));
        }

        return view('admin.clients.show')->with('client', $client);
    }

    /**
     * Show the form for editing the specified Client.
     */
    public function edit($id)
    {
        /** @var Client $client */
        $client = Client::find($id);

        if (empty($client)) {
            Flash::error(__('models/clients.singular') . ' ' . __('messages.not_found'));

            return redirect(route('admin.clients.index'));
        }

        return view('admin.clients.edit')->with('client', $client);
    }

    /**
     * Update the specified Client in storage.
     */
    public function update($id, UpdateClientRequest $request)
    {
        /** @var Client $client */
        $client = Client::find($id);

        if (empty($client)) {
            Flash::error(__('models/clients.singular') . ' ' . __('messages.not_found'));

            return redirect(route('admin.clients.index'));
        }
        $request_data = $request->except(['_token', 'photo']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('clients', $request->photo);
        }
        $client->fill($request_data);
        $client->save();

        Flash::success(__('messages.updated', ['model' => __('models/clients.singular')]));

        return redirect(route('admin.clients.index'));
    }

    /**
     * Remove the specified Client from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Client $client */
        $client = Client::find($id);

        if (empty($client)) {
            Flash::error(__('models/clients.singular') . ' ' . __('messages.not_found'));

            return redirect(route('admin.clients.index'));
        }

        $client->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/clients.singular')]));

        return redirect(route('admin.clients.index'));
    }
}
