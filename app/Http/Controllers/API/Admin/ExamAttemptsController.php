<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\AppBaseController;


use App\Http\Requests\API\Admin\AttemptAnswerAPIRequest;
use App\Http\Requests\API\Admin\ExamAttemptAPIRequest;
use App\Models\Admin\Answer;
use App\Models\Admin\AttemptAnswer;
use App\Models\Admin\Exam;
use App\Models\Admin\ExamAttempt;
use App\Models\Admin\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ExamAttemptsController extends AppBaseController
{


    public function start_exam(ExamAttemptAPIRequest $request)
    {
        $exam_id = $request->input('exam_id');
        $exam = Exam::with('questions')->find($exam_id);
        if (!$exam)
            return $this->sendError(__('messages.not_found', ['model' => __('exam_attempts.singular')]));


        $request_data = $request->only(['exam_id']);

        $request_data['total_questions'] = $exam->questions->count();
        $request_data['total_marks'] = $exam->questions->sum('points');
        $request_data['total_answered_questions'] = 0;
        $request_data['attempt_status'] = "attempt_started";

        $request_data['attempt_ip'] = request()->ip();
        $request_data['attempt_started_at'] = Carbon::now();

        $request_data['exam_id'] = $exam_id;
        $request_data['book_id'] = $exam->book_id;
        $request_data['student_id'] = auth('api-student')->id();
        $exam_attempt = ExamAttempt::create($request_data);
        return $this->sendResponse($exam_attempt, __('messages.retrieved', ['model' => __('models/exam_attempts.plural')]));

    }

    public function answer_question(AttemptAnswerAPIRequest $request)
    {
        $exam_attempt_id = $request->input('exam_attempt_id');
        $question_id = $request->input('question_id');
        $exam_attempt = ExamAttempt::find($exam_attempt_id);
        $review_required = false;
        if (!$exam_attempt)
            return $this->sendError(__('messages.not_found', ['model' => __('exam_attempts.singular')]));



        $request_data = $request->except(['student_id', 'exam_id', 'is_correct']);

        $question = Question::find($question_id);
        $question_type = $question->type;

        $is_answer_was_correct = false;
        $given_answer = $request->input('given_answer');
        if ($question_type === Question::$QUESTION_TYPE_TRUE_FALSE || $question_type === Question::$QUESTION_TYPE_SINGLE_CHOICE) {
            $answer = Answer::find($given_answer);//id for selected ans
            if ($answer)
                $is_answer_was_correct = (bool)$answer->is_correct;
            else
                return $this->sendError(__('messages.not_found', ['model' => __('exam_attempts.singular')]));



        } elseif ($question_type === Question::$QUESTION_TYPE_MULTIPLE_CHOICE ) {

            $given_answer = array_filter($given_answer, function ($id) {
                return is_numeric($id) && $id > 0;
            });
            $get_original_answers = Answer::where(['question_id' => $question_id, 'question_type' => $question_type, 'is_correct' => 1])
                ->pluck('id')
                ->toArray();


            if (count(array_diff($get_original_answers, $given_answer)) === 0 && count($get_original_answers) === count($given_answer)) {
                $is_answer_was_correct = true;
            }
            $given_answer = json_encode($given_answer);

        } elseif ($question_type === 'fill_in_the_blank') {

            $given_answer = ($given_answer);
            $given_answer = json_encode($given_answer);

            $get_original_answer = Answer::where(['question_id' => $question_id, 'question_type' => $question_type])
                ->first();

            $gap_answer = (array)explode('|', $get_original_answer->answer_two_gap_match);
            $gap_answer = array_map('trim', $gap_answer);

            if (strtolower($given_answer) == strtolower(json_encode($gap_answer))) {
                $is_answer_was_correct = true;
            }

        } elseif ($question_type === Question::$QUESTION_TYPE_SHORT_ANSWER || $question_type === Question::$QUESTION_TYPE_LONG_ANSWER ) {
            $review_required = true;
        } elseif ($question_type === 'ordering' || $question_type === 'matching' || $question_type === 'image_matching') {
            $given_answer = str_replace('"', '', json_encode($given_answer));
            $given_answer = str_replace(' ', '', $given_answer);

            $get_original_answers = Answer::where(['question_id' => $question_id, 'question_type' => $question_type])
                ->orderBy('answer_order', 'ASC')
                ->pluck('id')
                ->toArray();


            if ($given_answer == json_encode($get_original_answers)) {
                $is_answer_was_correct = true;
            }
        } elseif ($question_type === 'image_answering' ) { //TO::DO
            $given_answer = ($given_answer);
            $given_answer = json_encode($given_answer);
            $get_original_answers = Answer::where(['question_id' => $question_id, 'question_type' => $question_type])
                ->orderBy('answer_order', 'ASC')
                ->pluck('title')
                ->toArray();
            if (strtolower($given_answer) == strtolower(json_encode($get_original_answers))) {
                $is_answer_was_correct = true;
            }
        }
        $question_mark = $is_answer_was_correct ? $question->question_mark : 0;
        $request_data['given_answer'] = $given_answer;
        $request_data['question_mark'] = $question->question_mark;
        $request_data['achieved_mark'] = $question_mark;
        $request_data['minus_mark'] = 0;
        $request_data['is_correct'] = $is_answer_was_correct ? 1 : 0;
        $request_data['exam_id'] = $exam_attempt->exam_id;
        $request_data['student_id'] = auth('api-student')->id();

        /* check if question_type open ended or short ans the set is_correct default value null before saving
                    */
        if (in_array($question_type, array(Question::$QUESTION_TYPE_LONG_ANSWER, Question::$QUESTION_TYPE_SHORT_ANSWER, 'image_answering'))) {
            $request_data['is_correct'] = null;
        }
        $attempt_answer = AttemptAnswer::create($request_data);


        //start update quiz_attempt
        $questions_answered_correct = AttemptAnswer::where(['exam_attempt_id' => $exam_attempt_id, 'is_correct' => 1, 'student_id' => auth('api-student')->id()])->pluck('question_id')->toArray();
        $total_earned_marks = Question::whereIn('id', $questions_answered_correct)->sum('points');
        $attempt_info = [
            'total_answered_questions' => AttemptAnswer::where('exam_attempt_id', $exam_attempt_id)->count(),
            'earned_marks' => $total_earned_marks,

        ];

        if ($review_required) {
            $attempt_info['attempt_status'] = 'review_required';
        }
        if ($attempt_info['total_answered_questions'] == $exam_attempt->total_questions) {
            $attempt_info['attempt_status'] = 'attempt_ended';
            $attempt_info['attempt_ended_at'] = Carbon::now();
        }


        $exam_attempt->update($attempt_info);
        //end update quiz_attempt
        return $this->sendResponse($attempt_answer, __('messages.retrieved', ['model' => __('models/exam_attempts.plural')]));


    }

    public function quizzes(Request $request)
    {
        $student_id = auth('api-student')->id();
        $quizzes_attempts = QuizAttempt::with(['quiz', 'book', 'student', 'page_section'])
            ->whereHas('book')
            ->where('student_id', $student_id)
            ->when(request('selected_book_id'), function ($q) {
                $q->where('book_id', request('selected_book_id'));
            })
            ->when(request('selected_from') && request('selected_to'), function ($q) {
                $q->whereBetween('created_at', [request('selected_from'), request('selected_to')]);
            })
            ->select('*', \DB::raw('count(*) as total_attempt'))
            ->groupBy('page_section_id')
            ->orderby('id', 'asc')
            ->paginate(env('BACKEND_PAGINATION'));

        $charts = $this->quizzes_chart($student_id);
        $data['quizzes_attempts'] = $quizzes_attempts;
        $data['charts'] = $charts;

        return $this->sendResponse($data, trans('backend.api.saved'));
    }

    public function quiz_attempts($quiz_id, Request $request)
    {


        $quiz = Quiz::find($quiz_id);
        $student_id = auth('api-student')->id();

        if (!$quiz)
            return $this->sendError(trans('backend.api.not_found_model', ['model' => trans('backend.quiz_attempts')]));

        $quiz_attempts = QuizAttempt::with(['quiz', 'book', 'student', 'page_section'])
            ->whereHas('book')
            ->where('student_id', $student_id)
            ->where('quiz_id', $quiz_id)
            ->when(request('selected_book_id'), function ($q) {
                $q->where('book_id', request('selected_book_id'));
            })
            ->when(request('selected_from') && request('selected_to'), function ($q) {
                $q->whereBetween('created_at', [request('selected_from'), request('selected_to')]);
            })
            ->orderby('id', 'asc')
            ->paginate(env('BACKEND_PAGINATION'));

        $charts = $this->quiz_attempts_chart($student_id, $quiz_id);
        $data['quiz_attempts'] = $quiz_attempts;
        $data['charts'] = $charts;

        return $this->sendResponse($data, trans('backend.api.saved'));
    }

    public function attempt_answers($quiz_attempt_id)
    {


        $quiz_attempt = QuizAttempt::with(['quiz', 'book'])
            ->where(['student_id' => auth('api-student')->id()])
            ->find($quiz_attempt_id);
        if (!$quiz_attempt)
            return $this->sendError(trans('backend.api.not_found_model', ['model' => trans('backend.quiz_attempt')]));


        $attempt_answers = AttemptAnswer::with(['question'])
            ->where('quiz_attempt_id', $quiz_attempt_id)
            ->orderby('id', 'asc')
            ->paginate(env('BACKEND_PAGINATION'));


        $charts = $this->attempt_answers_chart($quiz_attempt_id);

        $data['quiz_attempt'] = $quiz_attempt;
        $data['attempt_answers'] = $attempt_answers;
        $data['charts'] = $charts;

        return $this->sendResponse($data, trans('backend.api.received'));

    }

    public function quizzes_chart($student_id)
    {
        $data = [];
        $charts = [
            ['chart_key' => 'book_id', 'chart_name' => __('backend.book'), 'foreign' => true, 'relation' => 'book', 'title' => 'title_en'],
            ['chart_key' => 'page_section_id', 'chart_name' => __('backend.page_section'), 'foreign' => true, 'relation' => 'page_section', 'title' => 'title'],
        ];
        foreach ($charts as $chart) {
            if ($chart['foreign'])
                $cf_details_lines = \App\Models\Crm\QuizAttempt::with(['book', 'page_section'])->whereHas('book')->select('id', 'book_id', 'student_id', 'page_section_id', \DB::raw('CAST(count(*) AS UNSIGNED) as num'))
                    ->when(request('selected_book_id'), function ($q) {
                        $q->where('book_id', request('selected_book_id'));
                    })
                    ->when(request('selected_student_id'), function ($q) use ($student_id) {
                        $q->where('student_id', $student_id);
                    })
                    ->when(request('selected_from') && request('selected_to'), function ($q) {
                        $q->whereBetween('created_at', [request('selected_from'), request('selected_to')]);
                    })
                    ->groupBy($chart['chart_key'])
                    ->withCasts(['num' => 'integer'])
                    ->get();
            else
                $cf_details_lines = \App\Models\Crm\QuizAttempt::select(\DB::raw('CAST(count(*) AS UNSIGNED) as num'), "{$chart["chart_key"]} as label")
                    ->when(request('selected_book_id'), function ($q) {
                        $q->where('book_id', request('selected_book_id'));
                    })
                    ->when(request('selected_student_id'), function ($q) use ($student_id) {
                        $q->where('student_id', $student_id);
                    })
                    ->when(request('selected_from') && request('selected_to'), function ($q) {
                        $q->whereBetween('created_at', [request('selected_from'), request('selected_to')]);
                    })
                    ->groupBy($chart['chart_key'])
                    ->withCasts(['num' => 'integer'])
                    ->get();

            $data[$chart['chart_key']] = $cf_details_lines;

        }
        return $data;

    }

    public function quiz_attempts_chart($student_id, $quiz_id)
    {
        $data = [];
        $charts = [
            ['chart_key' => 'attempt_started_at', 'chart_name' => __('backend.attempt_started_at'), 'foreign' => false],
            ['chart_key' => 'attempt_ended_at', 'chart_name' => __('backend.attempt_ended_at'), 'foreign' => false],
            ['chart_key' => 'attempt_status', 'chart_name' => __('backend.attempt_status'), 'foreign' => false],
            ['chart_key' => 'book_id', 'chart_name' => __('backend.book'), 'foreign' => true, 'relation' => 'book', 'title' => 'title_en'],
            ['chart_key' => 'page_section_id', 'chart_name' => __('backend.page_section'), 'foreign' => true, 'relation' => 'page_section', 'title' => 'title'],
        ];
        foreach ($charts as $chart) {
            if ($chart['foreign'])
                $cf_details_lines = \App\Models\Crm\QuizAttempt::with(['book', 'page_section', 'quiz'])->select('id', 'quiz_id', 'book_id', 'student_id', 'page_section_id', \DB::raw('CAST(count(*) AS UNSIGNED) as num'))
                    ->when(request('selected_book_id'), function ($q) {
                        $q->where('book_id', request('selected_book_id'));
                    })
                    ->where('quiz_id', $quiz_id)
                    ->when(request('selected_student_id'), function ($q) use ($student_id) {
                        $q->where('student_id', $student_id);
                    })
                    ->when(request('selected_from') && request('selected_to'), function ($q) {
                        $q->whereBetween('created_at', [request('selected_from'), request('selected_to')]);
                    })
                    ->groupBy($chart['chart_key'])
                    ->withCasts(['num' => 'integer'])
                    ->get();
            else
                $cf_details_lines = \App\Models\Crm\QuizAttempt::select(\DB::raw('CAST(count(*) AS UNSIGNED) as num'), "{$chart["chart_key"]} as label")
                    ->when(request('selected_book_id'), function ($q) {
                        $q->where('book_id', request('selected_book_id'));
                    })
                    ->where('quiz_id', $quiz_id)
                    ->when(request('selected_student_id'), function ($q) use ($student_id) {
                        $q->where('student_id', $student_id);
                    })
                    ->when(request('selected_from') && request('selected_to'), function ($q) {
                        $q->whereBetween('created_at', [request('selected_from'), request('selected_to')]);
                    })
                    ->groupBy($chart['chart_key'])
                    ->withCasts(['num' => 'integer'])
                    ->get();

            $data[$chart['chart_key']] = $cf_details_lines;

        }
        return $data;

    }

    public function attempt_answers_chart($quiz_attempt_id)
    {
        $data = [];
        $charts = [
            ['chart_key' => 'is_correct', 'chart_name' => __('backend.is_correct'), 'foreign' => false],
        ];
        foreach ($charts as $chart) {
            if ($chart['foreign'])
                $cf_details_lines = \App\Models\Crm\AttemptAnswer::with(['question'])->select('id', 'quiz_id', 'question_id', 'student_id', \DB::raw('CAST(count(*) AS UNSIGNED) as num'))
                    ->where('quiz_attempt_id', $quiz_attempt_id)
                    ->groupBy($chart['chart_key'])
                    ->withCasts(['num' => 'integer'])
                    ->get();
            else
                $cf_details_lines = \App\Models\Crm\AttemptAnswer::select(\DB::raw('CAST(count(*) AS UNSIGNED) as num'), "{$chart["chart_key"]} as label")
                    ->where('quiz_attempt_id', $quiz_attempt_id)
                    ->groupBy($chart['chart_key'])
                    ->withCasts(['num' => 'integer'])
                    ->get();


            $data[$chart['chart_key']] = $cf_details_lines;

        }
        return $data;

    }


}
