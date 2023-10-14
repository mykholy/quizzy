<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\StudentDataTable;
use App\Http\Requests\Admin\CreateStudentRequest;
use App\Http\Requests\Admin\UpdateStudentRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Student;
use Illuminate\Http\Request;


class StudentController extends AppBaseController
{
    /**
     * Display a listing of the Student.
     */
    public function index(StudentDataTable $studentDataTable)
    {
        return $studentDataTable->render('admin.students.index');
    }


    /**
     * Show the form for creating a new Student.
     */
    public function create()
    {
        return view('admin.students.create');
    }

    /**
     * Store a newly created Student in storage.
     */
    public function store(CreateStudentRequest $request)
    {

        $request_data = $request->except(['_token', 'photo', 'password']);
        if ($request->hasFile('photo')) {

            $request_data['photo'] = uploadImage('students', $request->photo);

        }

        if ($request->password)
            $request_data['password'] = bcrypt($request->password);

        /** @var Student $student */
        $student = Student::create($request_data);

        session()->flash('success', __('messages.saved', ['model' => __('models/students.singular')]));

        return redirect(route('admin.students.index'));
    }

    /**
     * Display the specified Student.
     */
    public function show($id)
    {
        /** @var Student $student */
        $student = Student::find($id);

        if (empty($student)) {
            session()->flash('error', __('models/students.singular') . ' ' . __('messages.not_found'));


            return redirect(route('admin.students.index'));
        }

        return view('admin.students.show')->with('student', $student);
    }

    /**
     * Show the form for editing the specified Student.
     */
    public function edit($id)
    {
        /** @var Student $student */
        $student = Student::find($id);

        if (empty($student)) {
            session()->flash('error', __('models/students.singular') . ' ' . __('messages.not_found'));


            return redirect(route('admin.students.index'));
        }

        return view('admin.students.edit')->with('student', $student);
    }

    /**
     * Update the specified Student in storage.
     */
    public function update($id, UpdateStudentRequest $request)
    {
        /** @var Student $student */
        $student = Student::find($id);

        if (empty($student)) {
            session()->flash('error', __('models/students.singular') . ' ' . __('messages.not_found'));


            return redirect(route('admin.students.index'));
        }

        $request_data = $request->except(['_token', 'photo']);

        if ($request->password)
            $request_data['password'] = bcrypt($request->password);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('students', $request->photo);
        }

        $student->fill($request_data);
        $student->save();

        session()->flash('success', __('messages.updated', ['model' => __('models/students.singular')]));

        return redirect(route('admin.students.index'));
    }

    /**
     * Remove the specified Student from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Student $student */
        $student = Student::find($id);

        if (empty($student)) {
            session()->flash('error', __('models/students.singular') . ' ' . __('messages.not_found'));


            return redirect(route('admin.students.index'));
        }

        $student->delete();

        session()->flash('success', __('messages.deleted', ['model' => __('models/students.singular')]));


        return redirect(route('admin.students.index'));
    }
}
