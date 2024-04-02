<?php

namespace App\Http\Controllers\API\Admin\Teacher;


use App\Models\Admin\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Admin\GroupResource;

/**
 * Class GroupTeacherAPIController
 */
class GroupTeacherAPIController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('auth:api-teacher');

    }

    /**
     * Display a listing of the Groups.
     * GET|HEAD /groups
     */
    public function index(Request $request): JsonResponse
    {
        $query = Group::query();
        $teacherId = auth('api-teacher')->id();

        // Filter groups based on the specific teacher ID
        $query->where('teacher_id', $teacherId);


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



}
