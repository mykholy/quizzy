<?php

namespace App\Http\Controllers\Teacher;

use App\DataTables\Teacher\ExamDataTable;
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
        return $examDataTable->render('teacher.exams.index');
    }


    /**
     * Show the form for creating a new Exam.
     */
    public function create()
    {
        return view('teacher.exams.create');
    }

    /**
     * Store a newly created Exam in storage.
     */
    public function store(CreateExamRequest $request)
    {

        $request_data = $request->except(['_token', 'photo', 'question_types']);
        if ($request->hasFile('photo')) {

            $request_data['photo'] = uploadImage('exams', $request->photo);

        }
        if (\request('question_types')) {
            $request_data['question_types'] = json_encode(\request('question_types'));
        }


        /** @var Exam $exam */
        $request_data['teacher_id'] = auth('teacher')->id();
        $request_data['type'] = Exam::$EXAM_TYPE_CHOICE_SPECIALIST;
        $exam = Exam::create($request_data);

        if ($request->questionIds)
            $exam->questions()->attach($request->questionIds);

        if ($request->studentIds)
            $exam->students()->attach($request->studentIds);;


        session()->flash('success', __('messages.saved', ['model' => __('models/exams.singular')]));

        return redirect(route('teacher.exams.index'));
    }

    /**
     * Display the specified Exam.
     */
    public function show($id)
    {
        /** @var Exam $exam */
        $exam = Exam::find($id);

        if (empty($exam)) {
            session()->flash('error', __('models/exams.singular') . ' ' . __('messages.not_found'));


            return redirect(route('teacher.exams.index'));
        }

        return view('teacher.exams.show')->with('exam', $exam);
    }

    /**
     * Show the form for editing the specified Exam.
     */
    public function edit($id)
    {
        /** @var Exam $exam */
        $exam = Exam::find($id);

        if (empty($exam)) {
            session()->flash('error', __('models/exams.singular') . ' ' . __('messages.not_found'));


            return redirect(route('teacher.exams.index'));
        }

        return view('teacher.exams.edit')->with('exam', $exam);
    }

    /**
     * Update the specified Exam in storage.
     */
    public function update($id, UpdateExamRequest $request)
    {
        /** @var Exam $exam */
        $exam = Exam::find($id);

        if (empty($exam)) {
            session()->flash('error', __('models/exams.singular') . ' ' . __('messages.not_found'));


            return redirect(route('teacher.exams.index'));
        }

        $request_data = $request->except(['_token', 'photo']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('exams', $request->photo);
        }

        $exam->fill($request_data);
        $exam->save();

        session()->flash('success', __('messages.updated', ['model' => __('models/exams.singular')]));

        return redirect(route('teacher.exams.index'));
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
            session()->flash('error', __('models/exams.singular') . ' ' . __('messages.not_found'));


            return redirect(route('teacher.exams.index'));
        }

        $exam->delete();

        session()->flash('success', __('messages.deleted', ['model' => __('models/exams.singular')]));


        return redirect(route('teacher.exams.index'));
    }
}
