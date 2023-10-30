<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\AnswerDataTable;
use App\Http\Requests\Admin\CreateAnswerRequest;
use App\Http\Requests\Admin\UpdateAnswerRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Answer;
use Illuminate\Http\Request;


class AnswerController extends AppBaseController
{
    /**
     * Display a listing of the Answer.
     */
    public function index(AnswerDataTable $answerDataTable)
    {
    return $answerDataTable->render('admin.answers.index');
    }


    /**
     * Show the form for creating a new Answer.
     */
    public function create()
    {
        return view('admin.answers.create');
    }

    /**
     * Store a newly created Answer in storage.
     */
    public function store(CreateAnswerRequest $request)
    {

        $request_data = $request->except(['_token', 'photo']);
        if ($request->hasFile('photo')) {

             $request_data['photo'] = uploadImage('answers', $request->photo);

        }

        /** @var Answer $answer */
        $answer = Answer::create($request_data);

        session()->flash('success',__('messages.saved', ['model' => __('models/answers.singular')]));

        return redirect(route('admin.answers.index'));
    }

    /**
     * Display the specified Answer.
     */
    public function show($id)
    {
        /** @var Answer $answer */
        $answer = Answer::find($id);

        if (empty($answer)) {
            session()->flash('error',__('models/answers.singular').' '.__('messages.not_found'));


            return redirect(route('admin.answers.index'));
        }

        return view('admin.answers.show')->with('answer', $answer);
    }

    /**
     * Show the form for editing the specified Answer.
     */
    public function edit($id)
    {
        /** @var Answer $answer */
        $answer = Answer::find($id);

        if (empty($answer)) {
            session()->flash('error',__('models/answers.singular').' '.__('messages.not_found'));


            return redirect(route('admin.answers.index'));
        }

        return view('admin.answers.edit')->with('answer', $answer);
    }

    /**
     * Update the specified Answer in storage.
     */
    public function update($id, UpdateAnswerRequest $request)
    {
        /** @var Answer $answer */
        $answer = Answer::find($id);

        if (empty($answer)) {
            session()->flash('error',__('models/answers.singular').' '.__('messages.not_found'));


            return redirect(route('admin.answers.index'));
        }

        $request_data = $request->except(['_token', 'photo']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('answers', $request->photo);
        }

        $answer->fill($request_data);
        $answer->save();

        session()->flash('success',__('messages.updated', ['model' => __('models/answers.singular')]));

        return redirect(route('admin.answers.index'));
    }

    /**
     * Remove the specified Answer from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Answer $answer */
        $answer = Answer::find($id);

        if (empty($answer)) {
            session()->flash('error',__('models/answers.singular').' '.__('messages.not_found'));


            return redirect(route('admin.answers.index'));
        }

        $answer->delete();

        session()->flash('success',__('messages.deleted', ['model' => __('models/answers.singular')]));


        return redirect(route('admin.answers.index'));
    }
}
