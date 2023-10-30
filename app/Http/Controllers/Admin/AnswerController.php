<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\AnswerDataTable;
use App\Http\Requests\Admin\CreateAnswerRequest;
use App\Http\Requests\Admin\UpdateAnswerRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Answer;
use App\Models\Admin\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AnswerController extends AppBaseController
{
    public function __construct()
    {
        if (!(\request('question_id') && Question::find(\request('question_id'))))
            abort(404);
    }

    /**
     * Display a listing of the Answer.
     */
    public function index(AnswerDataTable $answerDataTable)
    {
        $question_id = \request('question_id');

        $question = Question::find($question_id);

        return $answerDataTable->with('question_id', $question_id)->render('admin.answers.index',['question_id' => $question_id],compact('question'));

//        return $answerDataTable->render('admin.answers.index', ['question_id' => $question_id], compact('question'));
    }


    /**
     * Show the form for creating a new Answer.
     */
    public function create()
    {
        $question_id = \request('question_id');
        $question = Question::find($question_id);
        return view('admin.answers.create', compact('question'));
    }

    /**
     * Store a newly created Answer in storage.
     */
    public function store(CreateAnswerRequest $request)
    {
        try {
            DB::beginTransaction();
            $request_data = $request->except(['_token', 'photo']);
            $question = Question::with('answers')->find($request->question_id);
            $request_data['question_type'] = $question->type;

            //update other answer
            if (($question->type == Question::$QUESTION_TYPE_SINGLE_CHOICE && $request->has('is_correct'))) {
                if ($question->answers && !empty($request->is_correct))
                    $question->answers()->update([
                        'is_correct' => false,
                    ]);
            } elseif ($question->type == Question::$QUESTION_TYPE_MULTIPLE_CHOICE || $question->question_type == Question::$QUESTION_TYPE_TRUE_FALSE) {
                if (!$request->has('is_correct'))
                    $request_data['is_correct'] = false;
            }


            if ($request->hasFile('photo')) {

                $request_data['photo'] = uploadImage('answers', $request->photo);

            }

            /** @var Answer $answer */
            $answer = Answer::create($request_data);
            DB::commit();
            session()->flash('success', __('messages.saved', ['model' => __('models/answers.singular')]));
            return redirect(route('admin.answers.index', ['question_id' => request('question_id')]));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            session()->flash('error', $exception->getMessage());
            return redirect(route('admin.answers.index', ['question_id' => request('question_id')]));
        }
    }

    /**
     * Display the specified Answer.
     */
    public function show($id)
    {
        /** @var Answer $answer */
        $answer = Answer::find($id);

        if (empty($answer)) {
            session()->flash('error', __('models/answers.singular') . ' ' . __('messages.not_found'));


            return redirect(route('admin.answers.index', ['question_id' => request('question_id')]));
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
            session()->flash('error', __('models/answers.singular') . ' ' . __('messages.not_found'));


            return redirect(route('admin.answers.index', ['question_id' => request('question_id')]));
        }
        $question_id = \request('question_id');
        $question = Question::find($question_id);

        return view('admin.answers.edit', compact('question'))->with('answer', $answer);
    }

    /**
     * Update the specified Answer in storage.
     */
    public function update($id, UpdateAnswerRequest $request)
    {
        /** @var Answer $answer */
        $answer = Answer::find($id);

        if (empty($answer)) {
            session()->flash('error', __('models/answers.singular') . ' ' . __('messages.not_found'));


            return redirect(route('admin.answers.index', ['question_id' => request('question_id')]));
        }

        $request_data = $request->except(['_token', 'photo']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('answers', $request->photo);
        }

        $question = Question::with('answers')->find($answer->question_id);

        //update other answer
        if ($question->type == Question::$QUESTION_TYPE_SINGLE_CHOICE && $request->has('is_correct')) {
            if ($question->answers && !empty($request->is_correct))
                $question->answers()->update([
                    'is_correct' => false,
                ]);
        } elseif ($question->type == Question::$QUESTION_TYPE_MULTIPLE_CHOICE || $question->type == Question::$QUESTION_TYPE_TRUE_FALSE) {
            if (!$request->has('is_correct'))
                $request_data['is_correct'] = false;
            if ($question->type == Question::$QUESTION_TYPE_TRUE_FALSE)
                $question->answers()->update([
                    'is_correct' => false,
                ]);
        }

        $answer->fill($request_data);
        $answer->save();

        session()->flash('success', __('messages.updated', ['model' => __('models/answers.singular')]));

        return redirect(route('admin.answers.index', ['question_id' => request('question_id')]));
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
            session()->flash('error', __('models/answers.singular') . ' ' . __('messages.not_found'));


            return redirect(route('admin.answers.index', ['question_id' => request('question_id')]));
        }

        $answer->delete();

        session()->flash('success', __('messages.deleted', ['model' => __('models/answers.singular')]));


        return redirect(route('admin.answers.index', ['question_id' => request('question_id')]));
    }
}
