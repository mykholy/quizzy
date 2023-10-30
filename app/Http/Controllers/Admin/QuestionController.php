<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\QuestionDataTable;
use App\Http\Requests\Admin\CreateQuestionRequest;
use App\Http\Requests\Admin\UpdateQuestionRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Question;
use Illuminate\Http\Request;


class QuestionController extends AppBaseController
{
    /**
     * Display a listing of the Question.
     */
    public function index(QuestionDataTable $questionDataTable)
    {
    return $questionDataTable->render('admin.questions.index');
    }


    /**
     * Show the form for creating a new Question.
     */
    public function create()
    {
        return view('admin.questions.create');
    }

    /**
     * Store a newly created Question in storage.
     */
    public function store(CreateQuestionRequest $request)
    {

        $request_data = $request->except(['_token', 'photo','file']);
        if ($request->hasFile('photo')) {

             $request_data['photo'] = uploadImage('questions', $request->photo);

        }
        if ($request->hasFile('file')) {

             $request_data['file'] = uploadImage('questions', $request->file);

        }

        /** @var Question $question */
        $question = Question::create($request_data);

        session()->flash('success',__('messages.saved', ['model' => __('models/questions.singular')]));

        return redirect(route('admin.questions.index'));
    }

    /**
     * Display the specified Question.
     */
    public function show($id)
    {
        /** @var Question $question */
        $question = Question::find($id);

        if (empty($question)) {
            session()->flash('error',__('models/questions.singular').' '.__('messages.not_found'));


            return redirect(route('admin.questions.index'));
        }

        return view('admin.questions.show')->with('question', $question);
    }

    /**
     * Show the form for editing the specified Question.
     */
    public function edit($id)
    {
        /** @var Question $question */
        $question = Question::find($id);

        if (empty($question)) {
            session()->flash('error',__('models/questions.singular').' '.__('messages.not_found'));


            return redirect(route('admin.questions.index'));
        }

        return view('admin.questions.edit')->with('question', $question);
    }

    /**
     * Update the specified Question in storage.
     */
    public function update($id, UpdateQuestionRequest $request)
    {
        /** @var Question $question */
        $question = Question::find($id);

        if (empty($question)) {
            session()->flash('error',__('models/questions.singular').' '.__('messages.not_found'));


            return redirect(route('admin.questions.index'));
        }

        $request_data = $request->except(['_token', 'photo','file']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('questions', $request->photo);
        }

        if ($request->hasFile('file')) {

            $request_data['file'] = uploadImage('questions', $request->file);

        }
        $question->fill($request_data);
        $question->save();

        session()->flash('success',__('messages.updated', ['model' => __('models/questions.singular')]));

        return redirect(route('admin.questions.index'));
    }

    /**
     * Remove the specified Question from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Question $question */
        $question = Question::find($id);

        if (empty($question)) {
            session()->flash('error',__('models/questions.singular').' '.__('messages.not_found'));


            return redirect(route('admin.questions.index'));
        }

        $question->delete();

        session()->flash('success',__('messages.deleted', ['model' => __('models/questions.singular')]));


        return redirect(route('admin.questions.index'));
    }
}
