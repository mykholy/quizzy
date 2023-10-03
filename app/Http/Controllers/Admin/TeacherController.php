<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\TeacherDataTable;
use App\Http\Requests\Admin\CreateTeacherRequest;
use App\Http\Requests\Admin\UpdateTeacherRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Teacher;
use Illuminate\Http\Request;
use Flash;

class TeacherController extends AppBaseController
{
    /**
     * Display a listing of the Teacher.
     */
    public function index(TeacherDataTable $teacherDataTable)
    {
    return $teacherDataTable->render('admin.teachers.index');
    }


    /**
     * Show the form for creating a new Teacher.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created Teacher in storage.
     */
    public function store(CreateTeacherRequest $request)
    {

        $request_data = $request->except(['_token','password', 'photo']);
        if ($request->hasFile('photo')) {

             $request_data['photo'] = uploadImage('teachers', $request->photo);

        }
        if ($request->input('password')) {
            $request_data['password'] = bcrypt($request->password);
        }

        /** @var Teacher $teacher */
        $teacher = Teacher::create($request_data);

        session()->flash('success',__('messages.saved', ['model' => __('models/teachers.singular')]));

        return redirect(route('admin.teachers.index'));
    }

    /**
     * Display the specified Teacher.
     */
    public function show($id)
    {
        /** @var Teacher $teacher */
        $teacher = Teacher::find($id);

        if (empty($teacher)) {
            session()->flash('error',__('models/teachers.singular').' '.__('messages.not_found'));

            return redirect(route('admin.teachers.index'));
        }

        return view('admin.teachers.show')->with('teacher', $teacher);
    }

    /**
     * Show the form for editing the specified Teacher.
     */
    public function edit($id)
    {
        /** @var Teacher $teacher */
        $teacher = Teacher::find($id);

        if (empty($teacher)) {
            session()->flash('error',__('models/teachers.singular').' '.__('messages.not_found'));

            return redirect(route('admin.teachers.index'));
        }

        return view('admin.teachers.edit')->with('teacher', $teacher);
    }

    /**
     * Update the specified Teacher in storage.
     */
    public function update($id, UpdateTeacherRequest $request)
    {
        /** @var Teacher $teacher */
        $teacher = Teacher::find($id);

        if (empty($teacher)) {
            session()->flash('error',__('models/teachers.singular').' '.__('messages.not_found'));

            return redirect(route('admin.teachers.index'));
        }

        $request_data = $request->except(['_token','password', 'photo']);
        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('teachers', $request->photo);
        }
        if ($request->input('password')) {
            $request_data['password'] = bcrypt($request->password);
        }

        $teacher->fill($request_data);
        $teacher->save();

        session()->flash('success',__('messages.saved', ['model' => __('models/teachers.singular')]));

        return redirect(route('admin.teachers.index'));
    }

    /**
     * Remove the specified Teacher from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Teacher $teacher */
        $teacher = Teacher::find($id);

        if (empty($teacher)) {
            session()->flash('error',__('models/teachers.singular').' '.__('messages.not_found'));

            return redirect(route('admin.teachers.index'));
        }

        $teacher->delete();

        session()->flash('success',__('messages.deleted', ['model' => __('models/teachers.singular')]));

        return redirect(route('admin.teachers.index'));
    }
}
