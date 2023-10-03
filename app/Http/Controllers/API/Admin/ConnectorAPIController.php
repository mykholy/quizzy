<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateConnectorAPIRequest;
use App\Http\Requests\API\Admin\UpdateConnectorAPIRequest;
use App\Models\Admin\Connector;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\ConnectorResource;

/**
 * Class ConnectorAPIController
 */
class ConnectorAPIController extends AppBaseController
{
    /**
     * Display a listing of the Connectors.
     * GET|HEAD /connectors
     */
    public function index(Request $request): JsonResponse
    {
        $query = Connector::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $connectors = $query->get();

        return $this->sendResponse(
            ConnectorResource::collection($connectors),
            __('messages.retrieved', ['model' => __('models/connectors.plural')])
        );
    }

    /**
     * Store a newly created Connector in storage.
     * POST /connectors
     */
    public function store(CreateConnectorAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Connector $connector */
        $connector = Connector::create($input);

        return $this->sendResponse(
            new ConnectorResource($connector),
            __('messages.saved', ['model' => __('models/connectors.singular')])
        );
    }

    /**
     * Display the specified Connector.
     * GET|HEAD /connectors/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Connector $connector */
        $connector = Connector::find($id);

        if (empty($connector)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/connectors.singular')])
            );
        }

        return $this->sendResponse(
            new ConnectorResource($connector),
            __('messages.retrieved', ['model' => __('models/connectors.singular')])
        );
    }

    /**
     * Update the specified Connector in storage.
     * PUT/PATCH /connectors/{id}
     */
    public function update($id, UpdateConnectorAPIRequest $request): JsonResponse
    {
        /** @var Connector $connector */
        $connector = Connector::find($id);

        if (empty($connector)) {
        return $this->sendError(
            __('messages.not_found', ['model' => __('models/connectors.singular')])
        );
        }

        $connector->fill($request->all());
        $connector->save();

        return $this->sendResponse(
            new ConnectorResource($connector),
            __('messages.updated', ['model' => __('models/connectors.singular')])
        );
    }

    /**
     * Remove the specified Connector from storage.
     * DELETE /connectors/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Connector $connector */
        $connector = Connector::find($id);

        if (empty($connector)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/connectors.singular')])
            );
        }

        $connector->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/connectors.singular')])
        );
    }
}
