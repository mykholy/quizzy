<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\API\Admin\CreateGroupAPIRequest;
use App\Http\Requests\API\Admin\UpdateGroupAPIRequest;
use App\Models\Admin\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\GroupResource;

/**
 * Class GroupAPIController
 */
class GroupAPIController extends AppBaseController
{
    /**
     * Display a listing of the Groups.
     * GET|HEAD /groups
     */
    public function index(Request $request): JsonResponse
    {
        $query = Group::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $groups = $query->get();

        return $this->sendResponse(
            GroupResource::collection($groups),
            __('messages.retrieved', ['model' => __('models/groups.plural')])
        );
    }

    /**
     * Store a newly created Group in storage.
     * POST /groups
     */
    public function store(CreateGroupAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Group $group */
        $group = Group::create($input);

        return $this->sendResponse(
            new GroupResource($group),
            __('messages.saved', ['model' => __('models/groups.singular')])
        );
    }

    /**
     * Display the specified Group.
     * GET|HEAD /groups/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Group $group */
        $group = Group::find($id);

        if (empty($group)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/groups.singular')])
            );
        }

        return $this->sendResponse(
            new GroupResource($group),
            __('messages.retrieved', ['model' => __('models/groups.singular')])
        );
    }

    /**
     * Update the specified Group in storage.
     * PUT/PATCH /groups/{id}
     */
    public function update($id, UpdateGroupAPIRequest $request): JsonResponse
    {
        /** @var Group $group */
        $group = Group::find($id);

        if (empty($group)) {
        return $this->sendError(
            __('messages.not_found', ['model' => __('models/groups.singular')])
        );
        }

        $group->fill($request->all());
        $group->save();

        return $this->sendResponse(
            new GroupResource($group),
            __('messages.updated', ['model' => __('models/groups.singular')])
        );
    }

    /**
     * Remove the specified Group from storage.
     * DELETE /groups/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Group $group */
        $group = Group::find($id);

        if (empty($group)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/groups.singular')])
            );
        }

        $group->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/groups.singular')])
        );
    }
}
