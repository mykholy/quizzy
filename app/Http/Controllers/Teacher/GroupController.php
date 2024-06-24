<?php

namespace App\Http\Controllers\Teacher;

use App\DataTables\Teacher\GroupDataTable;
use App\Http\Requests\Admin\CreateGroupRequest;
use App\Http\Requests\Admin\UpdateGroupRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Group;
use App\Models\Admin\Student;
use Chat;

class GroupController extends AppBaseController
{
    /**
     * Display a listing of the Group.
     */
    public function index(GroupDataTable $groupDataTable)
    {
        return $groupDataTable->render('teacher.groups.index');
    }


    /**
     * Show the form for creating a new Group.
     */
    public function create()
    {
        return view('teacher.groups.create');
    }

    /**
     * Store a newly created Group in storage.
     */
    public function store(CreateGroupRequest $request)
    {

        $request_data = $request->except(['_token', 'photo', 'student_ids']);
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
            Chat::conversation($conversation)->addParticipants($group->students->all());
        }

        session()->flash('success', __('messages.saved', ['model' => __('models/groups.singular')]));

        return redirect(route('teacher.groups.index'));
    }

    /**
     * Display the specified Group.
     */
    public function show($id)
    {
        /** @var Group $group */
        $group = Group::with(['subject', 'teacher'])
            ->where('teacher_id', auth('teacher')->id())
            ->find($id);

        if (empty($group)) {
            session()->flash('error', __('models/groups.singular') . ' ' . __('messages.not_found'));


            return redirect(route('teacher.groups.index'));
        }

        return view('teacher.groups.show')->with('group', $group);
    }

    /**
     * Show the form for editing the specified Group.
     */
    public function edit($id)
    {
        /** @var Group $group */
        $group = Group::firstWhere([
            ['id', $id],
            ['teacher_id', auth('teacher')->id()]
        ]);

        if (empty($group)) {
            session()->flash('error', __('models/groups.singular') . ' ' . __('messages.not_found'));


            return redirect(route('teacher.groups.index'));
        }

        return view('teacher.groups.edit')->with('group', $group);
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


            return redirect(route('teacher.groups.index'));
        }

        $request_data = $request->except(['_token', 'photo', 'student_ids']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('groups', $request->photo);
        }

        $group->fill($request_data);
        $group->save();
        $current_students = $group->students->pluck('id')->toArray();

        if ($request->student_ids)
            $group->students()->sync($request->student_ids);

        /* add multiple participants */
        if ($group->students) {
            $conversation = Chat::conversations()->getById($group->conversation_id);
            $newParticipants = array_diff($group->students()->get()->pluck('id')->toArray(), $current_students);
//            dd( $group->students()->get()->pluck('id')->toArray(),$current_students, $newParticipants);

            if (!empty($newParticipants))
                Chat::conversation($conversation)->addParticipants(collect(Student::whereIn('id', $newParticipants)->get())->all());
        }

        session()->flash('success', __('messages.updated', ['model' => __('models/groups.singular')]));

        return redirect(route('teacher.groups.index'));
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


            return redirect(route('teacher.groups.index'));
        }

        $group->delete();

        session()->flash('success', __('messages.deleted', ['model' => __('models/groups.singular')]));


        return redirect(route('teacher.groups.index'));
    }
}
