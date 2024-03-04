<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\QuestionDataTable;
use App\Http\Requests\Admin\CreateQuestionRequest;
use App\Http\Requests\Admin\UpdateQuestionRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Answer;
use App\Models\Admin\Book;
use App\Models\Admin\Lesson;
use App\Models\Admin\Question;
use App\Models\Admin\QuestionsImport;
use App\Models\Admin\Unit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class QuestionController extends AppBaseController
{
    /**
     * Display a listing of the Question.
     */
    public function index(QuestionDataTable $questionDataTable)
    {
        return $questionDataTable->render('admin.questions.index', ['lesson_id' => request('lesson_id')]);
    }


    /**
     * Show the form for creating a new Question.
     */
    public function create()
    {
        if (\request('bulkImport')) {
            return view('admin.questions.bulkImport');
        }
        return view('admin.questions.create');
    }

    /**
     * Store a newly created Question in storage.
     */
    public function store(CreateQuestionRequest $request)
    {

        $request_data = $request->except(['_token', 'photo', 'file']);
        if ($request->hasFile('photo')) {

            $request_data['photo'] = uploadImage('questions', $request->photo);

        }
        if ($request->hasFile('file')) {

            $request_data['file'] = uploadImage('questions', $request->file);

        }

        /** @var Question $question */
        $question = Question::create($request_data);

        $this->generate_answer_question_helper($question);
        session()->flash('success', __('messages.saved', ['model' => __('models/questions.singular')]));

        return redirect(route('admin.questions.index', ['lesson_id' => request('lesson_id')]));
    }

    public function bulkStore(Request $request)
    {

        if ($request->hasFile('bulk_file')) {
            $import = new QuestionsImport;
            Excel::import($import, request()->file('bulk_file'));
            session()->flash('success', __('messages.saved', ['model' => __('models/questions.singular')]));

            return redirect(route('admin.questions.index', ['lesson_id' => request('lesson_id')]));
        }

        if ($request->hasFile('files')) {

            if ($request->files) {
                $files_url_data = [];
                $files_url = json_decode(saveArrayImage('uploads', $request->files), true);
                foreach ($files_url as $file)
                    $files_url_data[] = asset($file);

                return view('admin.questions.bulkImport', compact('files_url_data'));

            }
        }
        return back();

    }

    /**
     * Display the specified Question.
     */
    public function show($id)
    {
        /** @var Question $question */
        $question = Question::find($id);

        if (empty($question)) {
            session()->flash('error', __('models/questions.singular') . ' ' . __('messages.not_found'));


            return redirect(route('admin.questions.index', ['lesson_id' => request('lesson_id')]));
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
            session()->flash('error', __('models/questions.singular') . ' ' . __('messages.not_found'));


            return redirect(route('admin.questions.index', ['lesson_id' => request('lesson_id')]));
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
            session()->flash('error', __('models/questions.singular') . ' ' . __('messages.not_found'));


            return redirect(route('admin.questions.index', ['lesson_id' => request('lesson_id')]));
        }

        $request_data = $request->except(['_token', 'photo', 'file']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('questions', $request->photo);
        }

        if ($request->hasFile('file')) {

            $request_data['file'] = uploadImage('questions', $request->file);

        }
        $question->fill($request_data);
        $question->save();

        session()->flash('success', __('messages.updated', ['model' => __('models/questions.singular')]));

        return redirect(route('admin.questions.index', ['lesson_id' => request('lesson_id')]));
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
            session()->flash('error', __('models/questions.singular') . ' ' . __('messages.not_found'));


            return redirect(route('admin.questions.index', ['lesson_id' => request('lesson_id')]));
        }

        $question->delete();

        session()->flash('success', __('messages.deleted', ['model' => __('models/questions.singular')]));


        return redirect(route('admin.questions.index', ['lesson_id' => request('lesson_id')]));
    }

    public function generate_answer_question_helper($question)
    {
        switch ($question->type) {
            case Question::$QUESTION_TYPE_TRUE_FALSE:
                $ans = [[
                    'title' => 'True',
                    'is_correct' => true,
                    'answer_two_gap_match' => 'true',
                    'answer_view_format' => 'text',
                    'question_id' => $question->id,
                    'answer_order' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ], [
                    'title' => 'False',
                    'is_correct' => false,
                    'answer_two_gap_match' => 'false',
                    'answer_view_format' => 'text',
                    'question_id' => $question->id,
                    'answer_order' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]];
                Answer::insert($ans);
                break;
            default:
                return false;
        }


    }

    public function ajax_get_books_by_subject($id)
    {

        $books = Book::where('subject_id', $id)->pluck('name', 'id')->toArray();

        return view('includes.ajax_options', ['data' => $books, 'name' => 'book_id', 'placeholder' => __('models/books.singular')]);
    }

    public function ajax_get_units_by_book($id)
    {

        $unites = Unit::where('book_id', $id)->pluck('name', 'id')->toArray();

        return view('includes.ajax_options', ['data' => $unites, 'name' => 'unit_id', 'placeholder' => __('models/units.singular')]);
    }

    public function ajax_get_lessons_by_unit($id)
    {

        $lessons = Lesson::where('unit_id', $id)->pluck('name', 'id')->toArray();

        return view('includes.ajax_options', ['data' => $lessons, 'name' => 'lesson_id', 'placeholder' => __('models/lessons.singular')]);
    }
}
