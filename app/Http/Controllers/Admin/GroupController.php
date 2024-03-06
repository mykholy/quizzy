<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\GroupDataTable;
use App\Http\Requests\Admin\CreateGroupRequest;
use App\Http\Requests\Admin\UpdateGroupRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Group;
use Illuminate\Http\Request;
use Chat;


class GroupController extends AppBaseController
{
    /**
     * Display a listing of the Group.
     */
    public function index(GroupDataTable $groupDataTable)
    {
        return $groupDataTable->render('admin.groups.index');
    }


    /**
     * Show the form for creating a new Group.
     */
    public function create()
    {
        return view('admin.groups.create');
    }

    /**
     * Store a newly created Group in storage.
     */
    public function store(CreateGroupRequest $request)
    {

        $request_data = $request->except(['_token', 'photo','student_ids']);
        if ($request->hasFile('photo')) {

            $request_data['photo'] = uploadImage('groups', $request->photo);

        }

        /** @var Group $group */
        $group = Group::create($request_data);

        if ($request->student_ids)
            $group->students()->sync($request->student_ids);

        $conversation = Chat::createConversation([$group, $group->teacher]);
        $group->conversation_id = $conversation->id;
        $group->save();

        /* add multiple participants */
        if ($group->students) {
            Chat::conversation($conversation)->addParticipants( $group->students->all());
        }

        session()->flash('success', __('messages.saved', ['model' => __('models/groups.singular')]));

        return redirect(route('admin.groups.index'));
    }

    /**
     * Display the specified Group.
     */
    public function show($id)
    {
        /** @var Group $group */
        $group = Group::with(['subject', 'teacher'])->find($id);

        if (empty($group)) {
            session()->flash('error', __('models/groups.singular') . ' ' . __('messages.not_found'));


            return redirect(route('admin.groups.index'));
        }

        return view('admin.groups.show')->with('group', $group);
    }

    /**
     * Show the form for editing the specified Group.
     */
    public function edit($id)
    {
        /** @var Group $group */
        $group = Group::find($id);

        if (empty($group)) {
            session()->flash('error', __('models/groups.singular') . ' ' . __('messages.not_found'));


            return redirect(route('admin.groups.index'));
        }

        return view('admin.groups.edit')->with('group', $group);
    }

    /**
     * Update the specified Group in storage.
     */
    public function update($id, UpdateGroupRequest $request)
    {
        /** @var Group $group */
        $group = Group::find($id);

        if (empty($group)) {
            session()->flash('error', __('models/groups.singular') . ' ' . __('messages.not_found'));


            return redirect(route('admin.groups.index'));
        }

        $request_data = $request->except(['_token', 'photo','student_ids']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('groups', $request->photo);
        }

        $group->fill($request_data);
        $group->save();

        if ($request->student_ids)
            $group->students()->sync($request->student_ids);

        /* add multiple participants */
        if ($group->students) {
            $conversation = Chat::conversations()->getById($group->conversation_id);
            Chat::conversation($conversation)->addParticipants($group->students->all());
        }

        session()->flash('success', __('messages.updated', ['model' => __('models/groups.singular')]));

        return redirect(route('admin.groups.index'));
    }

    /**
     * Remove the specified Group from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Group $group */
        $group = Group::find($id);

        if (empty($group)) {
            session()->flash('error', __('models/groups.singular') . ' ' . __('messages.not_found'));


            return redirect(route('admin.groups.index'));
        }

        $group->delete();

        session()->flash('success', __('messages.deleted', ['model' => __('models/groups.singular')]));


        return redirect(route('admin.groups.index'));
    }
}
