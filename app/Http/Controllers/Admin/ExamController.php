<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ExamDataTable;
use App\Http\Requests\Admin\CreateExamRequest;
use App\Http\Requests\Admin\UpdateExamRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Exam;
use Illuminate\Http\Request;


class ExamController extends AppBaseController
{
    /**
     * Display a listing of the Exam.
     */
    public function index(ExamDataTable $examDataTable)
    {
    return $examDataTable->render('admin.exams.index');
    }


    /**
     * Show the form for creating a new Exam.
     */
    public function create()
    {
        return view('admin.exams.create');
    }

    /**
     * Store a newly created Exam in storage.
     */
    public function store(CreateExamRequest $request)
    {

        $request_data = $request->except(['_token', 'photo']);
        if ($request->hasFile('photo')) {

             $request_data['photo'] = uploadImage('exams', $request->photo);

        }

        /** @var Exam $exam */
        $exam = Exam::create($request_data);

        session()->flash('success',__('messages.saved', ['model' => __('models/exams.singular')]));

        return redirect(route('admin.exams.index'));
    }

    /**
     * Display the specified Exam.
     */
    public function show($id)
    {
        /** @var Exam $exam */
        $exam = Exam::find($id);

        if (empty($exam)) {
            session()->flash('error',__('models/exams.singular').' '.__('messages.not_found'));


            return redirect(route('admin.exams.index'));
        }

        return view('admin.exams.show')->with('exam', $exam);
    }

    /**
     * Show the form for editing the specified Exam.
     */
    public function edit($id)
    {
        /** @var Exam $exam */
        $exam = Exam::find($id);

        if (empty($exam)) {
            session()->flash('error',__('models/exams.singular').' '.__('messages.not_found'));


            return redirect(route('admin.exams.index'));
        }

        return view('admin.exams.edit')->with('exam', $exam);
    }

    /**
     * Update the specified Exam in storage.
     */
    public function update($id, UpdateExamRequest $request)
    {
        /** @var Exam $exam */
        $exam = Exam::find($id);

        if (empty($exam)) {
            session()->flash('error',__('models/exams.singular').' '.__('messages.not_found'));


            return redirect(route('admin.exams.index'));
        }

        $request_data = $request->except(['_token', 'photo']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('exams', $request->photo);
        }

        $exam->fill($request_data);
        $exam->save();

        session()->flash('success',__('messages.updated', ['model' => __('models/exams.singular')]));

        return redirect(route('admin.exams.index'));
    }

    /**
     * Remove the specified Exam from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Exam $exam */
        $exam = Exam::find($id);

        if (empty($exam)) {
            session()->flash('error',__('models/exams.singular').' '.__('messages.not_found'));


            return redirect(route('admin.exams.index'));
        }

        $exam->delete();

        session()->flash('success',__('messages.deleted', ['model' => __('models/exams.singular')]));


        return redirect(route('admin.exams.index'));
    }
}
