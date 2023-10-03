<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateClientAPIRequest;
use App\Http\Requests\API\Admin\UpdateClientAPIRequest;
use App\Models\Admin\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\ClientResource;

/**
 * Class ClientAPIController
 */
class ClientAPIController extends AppBaseController
{
    /**
     * Display a listing of the Clients.
     * GET|HEAD /clients
     */
    public function index(Request $request): JsonResponse
    {
        $query = Client::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $clients = $query->get();

        return $this->sendResponse(
            ClientResource::collection($clients),
            __('messages.retrieved', ['model' => __('models/clients.plural')])
        );
    }

    /**
     * Store a newly created Client in storage.
     * POST /clients
     */
    public function store(CreateClientAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Client $client */
        $client = Client::create($input);

        return $this->sendResponse(
            new ClientResource($client),
            __('messages.saved', ['model' => __('models/clients.singular')])
        );
    }

    /**
     * Display the specified Client.
     * GET|HEAD /clients/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Client $client */
        $client = Client::find($id);

        if (empty($client)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/clients.singular')])
            );
        }

        return $this->sendResponse(
            new ClientResource($client),
            __('messages.retrieved', ['model' => __('models/clients.singular')])
        );
    }

    /**
     * Update the specified Client in storage.
     * PUT/PATCH /clients/{id}
     */
    public function update($id, UpdateClientAPIRequest $request): JsonResponse
    {
        /** @var Client $client */
        $client = Client::find($id);

        if (empty($client)) {
        return $this->sendError(
            __('messages.not_found', ['model' => __('models/clients.singular')])
        );
        }

        $client->fill($request->all());
        $client->save();

        return $this->sendResponse(
            new ClientResource($client),
            __('messages.updated', ['model' => __('models/clients.singular')])
        );
    }

    /**
     * Remove the specified Client from storage.
     * DELETE /clients/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Client $client */
        $client = Client::find($id);

        if (empty($client)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/clients.singular')])
            );
        }

        $client->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/clients.singular')])
        );
    }
}
