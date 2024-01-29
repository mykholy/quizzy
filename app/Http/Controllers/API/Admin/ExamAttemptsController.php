<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\AppBaseController;


use App\Http\Requests\API\Admin\AttemptAnswerAPIRequest;
use App\Http\Requests\API\Admin\ExamAttemptAPIRequest;
use App\Http\Resources\Admin\ExamAttemptResource;
use App\Http\Resources\Admin\TopStudentExamAttemptResource;
use App\Models\Admin\Answer;
use App\Models\Admin\AttemptAnswer;
use App\Models\Admin\Exam;
use App\Models\Admin\ExamAttempt;
use App\Models\Admin\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


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

        $is_answered = AttemptAnswer::where(['exam_attempt_id' => $exam_attempt_id, 'question_id' => $question_id])->first();
        if ($is_answered)
            return $this->sendError(__('lang.question_answered'));


        $request_data = $request->except(['student_id', 'exam_id', 'is_correct']);

        $question = Question::find($question_id);
        $question_type = $question->type;

        $is_answer_was_correct = false;
        $given_answer = $request->input('given_answer');
        if ($question_type === Question::$QUESTION_TYPE_TRUE_FALSE || $question_type === Question::$QUESTION_TYPE_SINGLE_CHOICE) {
            $answer = Answer::find($given_answer);//id for selected ans
            if ($answer)
                $is_answer_was_correct = (bool)$answer->is_correct;
//            else
//                return $this->sendError(__('messages.not_found', ['model' => __('exam_attempts.singular')]));


        } elseif ($question_type === Question::$QUESTION_TYPE_MULTIPLE_CHOICE) {

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

        } elseif ($question_type === Question::$QUESTION_TYPE_SHORT_ANSWER || $question_type === Question::$QUESTION_TYPE_LONG_ANSWER) {
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
        } elseif ($question_type === 'image_answering') { //TO::DO
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
        $question_mark = $is_answer_was_correct ? $question->points : 0;
        $request_data['given_answer'] = $given_answer;
        $request_data['question_mark'] = $question->points;
        $request_data['achieved_mark'] = $question_mark;
        $request_data['minus_mark'] = 0;
        $request_data['is_correct'] = $is_answer_was_correct ? 1 : 0;
        $request_data['exam_id'] = $exam_attempt->exam_id;
        $request_data['student_id'] = auth('api-student')->id();

        /* check if question_type open ended or short ans the set is_correct default value null before saving
                    */
        if (in_array($question_type, array(Question::$QUESTION_TYPE_LONG_ANSWER, Question::$QUESTION_TYPE_SHORT_ANSWER, 'image_answering'))) {
            $get_original_answer = $question->answers->first();
            similar_text(strtolower($given_answer), strtolower($get_original_answer->answer_two_gap_match), $per);
            Log::info("similar_text", [
                'strtolower($given_answer)' => strtolower($given_answer),
                'strtolower($get_original_answer->answer_two_gap_match)' => strtolower($get_original_answer->answer_two_gap_match),
                '$get_original_answer' => json_encode($get_original_answer),
                '$per' => $per,
            ]);
            if ($question_type == Question::$QUESTION_TYPE_LONG_ANSWER)
                $request_data['is_correct'] = $per > 60 ? 1 : 0;
            else
                $request_data['is_correct'] = $per > 90 ? 1 : 0;
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

    public function exams(Request $request)
    {
        $student_id = auth('api-student')->id();
        $exams_attempts = ExamAttempt::with(['exam', 'subject', 'student'])
            ->whereHas('exam', function ($q) {
                $q->where('type', '!=', 'after_finish'); // Filter exams where the type is 'after_finish'
            })
            ->whereColumn('total_questions', '!=', 'total_answered_questions') // Filter exams where total_questions != total_answered_questions
            ->where('student_id', $student_id)
            ->when(request('selected_subject_id'), function ($q) {
                $q->where('subject_id', request('selected_subject_id'));
            })
            ->when(request('selected_from') && request('selected_to'), function ($q) {
                $q->whereBetween('created_at', [request('selected_from'), request('selected_to')]);
            })
            ->select('*', \DB::raw('count(*) as total_attempt'))
            ->groupBy('exam_id')
            ->orderby('id', 'asc')
            ->paginate(10);

        $charts = $this->exams_chart($student_id);
        $data['exams_attempts'] = $exams_attempts;
        $data['charts'] = $charts;

        return $this->sendResponse($data, trans('backend.api.saved'));
    }

    public function top_students(Request $request)
    {
        $topStudents = ExamAttempt::with(['exam', 'subject', 'student'])

            ->whereHas('exam', function ($query)  {
                $query->when(request('selected_subject_id'), function ($q) {
                    $q->where('subject_id', request('selected_subject_id'));
                });
            })
            ->when(request('selected_exam_id'), function ($q) {
                $q->where('exam_id', request('selected_exam_id'));
            })
            ->when(request('selected_from') && request('selected_to'), function ($q) {
                $q->whereBetween('created_at', [request('selected_from'), request('selected_to')]);
            })
            ->orderByDesc('earned_marks')
//            ->limit(10)
            ->paginate($request->input('limit',10));

//        // Find the position of the current student
//        $currentStudentPosition = $topStudents->pluck('id')->search(auth('api-student')->id());
//
//// Retrieve the current student and 5 students above and below
//        $studentsToShow = $topStudents->splice(max(0, $currentStudentPosition - 5), 11);
//
//// Add rank to each student
//        $rankedStudents = $studentsToShow->map(function ($student, $index) {
//            $student->rank = $index + 1; // Ranks start from 1
//            return $student;
//        });

        return $this->sendResponse(TopStudentExamAttemptResource::collection($topStudents)->response()->getData(true), trans('backend.api.saved'));
    }

    public function achievements($subject_id, Request $request)
    {
        $subjectId = $subject_id; // your subject_id value;

        // 1. Calculate total earned marks for a specific subject
        $totalEarnedMarks = ExamAttempt::where('subject_id', $subjectId)->sum('earned_marks');

        // 2. Calculate total questions attempted for a specific subject
        $totalQuestions = ExamAttempt::where('subject_id', $subjectId)->value('total_answered_questions');

        // 3. Calculate your ranking for a specific subject
        // Replace 'your_score' with the actual score of the current student
        // Replace 'your_score' with the actual score of the current student
        $yourScore = ExamAttempt::where('subject_id', $subjectId)->value('earned_marks');

        // Check if $yourScore is not null before proceeding
        if ($yourScore !== null) {
            $yourRanking = ExamAttempt::where('subject_id', $subjectId)
                    ->where('earned_marks', '>', $yourScore)
                    ->count() + 1;
        } else {
            // Handle the case where $yourScore is null (e.g., subject_id not found)
            $yourRanking = null;
        }

        // 4. Calculate number of correct answers for a specific subject
        $numberCorrectAnswer = AttemptAnswer::whereHas('examAttempt', function ($query) use ($subjectId) {
            $query->where('subject_id', $subjectId);
        })
            ->where('is_correct', 1)
            ->where('student_id', auth('api-student')->id())
            ->count();

        // Now you have the calculated values based on the specified subject_id.
        $data = [
            'totalEarnedMarks' => $totalEarnedMarks,
            'totalQuestions' => $totalQuestions,
            'yourRanking' => $yourRanking,
            'numberCorrectAnswer' => $numberCorrectAnswer,
            'chart' => $this->chart_achievements($subjectId),
        ];

        return $this->sendResponse($data, trans('backend.api.saved'));
    }

    public function chart_achievements($subjectId)
    {
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();

        $data = ExamAttempt::whereHas('exam', function ($query) use ($subjectId) {
            $query->where('subject_id', $subjectId);
        })
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->get();

        // Initialize an array for each day of the week with zero values
        $dayLabels = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $chartData = array_fill_keys($dayLabels, 0);

// Update the values based on the fetched data
        foreach ($data as $attempt) {
            $day = $attempt->created_at->format('l');
            $chartData[$day] += $attempt->earned_marks;
        }

// Convert the associative array to a numeric array for Chart.js
        $numericChartData = array_values($chartData);


        // Calculate the total earned marks for the week
        $totalEarnedMarks = array_sum($chartData);

        return [
            'labels' => $dayLabels,
            'data' => $numericChartData,
            'totalEarnedMarks' => $totalEarnedMarks,
        ];
    }

    public function exam_attempts(Request $request)
    {


        $student_id = auth('api-student')->id();


        $exam_attempts = ExamAttempt::with(['exam', 'subject', 'student'])
            ->whereHas('exam', function ($q) {
                $q->where('type', '!=', 'after_finish'); // Filter exams where the type is 'after_finish'
            })
            ->whereColumn('total_questions', '!=', 'total_answered_questions') // Filter exams where total_questions != total_answered_questions
            ->where('student_id', $student_id)
            ->when(request('exam_id'), function ($q) {
                $q->where('exam_id', request('exam_id'));
            })
            ->when(request('selected_subject_id'), function ($q) {
                $q->where('subject_id', request('selected_subject_id'));
            })
            ->when(request('selected_from') && request('selected_to'), function ($q) {
                $q->whereBetween('created_at', [request('selected_from'), request('selected_to')]);
            })
            ->orderby('id', 'asc')
            ->paginate(10);

//        $charts = $this->exam_attempts_chart($student_id, $exam_id);
        $data['exam_attempts'] = $exam_attempts;
//        $data['charts'] = $charts;

        return $this->sendResponse($data, trans('backend.api.saved'));
    }

    public function attempt_answers($exam_attempt_id)
    {


        $exam_attempt = ExamAttempt::with(['exam', 'book', 'subject'])
            ->where(['student_id' => auth('api-student')->id()])
            ->find($exam_attempt_id);
        if (!$exam_attempt)
            return $this->sendError(trans('backend.api.not_found_model', ['model' => trans('backend.exam_attempt')]));


        $attempt_answers = AttemptAnswer::with(['question'])
            ->where('exam_attempt_id', $exam_attempt_id)
            ->orderby('id', 'asc')
            ->paginate(10);


        $charts = $this->attempt_answers_chart($exam_attempt_id);

        $data['exam_attempt'] = new ExamAttemptResource($exam_attempt);
        $data['attempt_answers'] = $attempt_answers;
        $data['charts'] = $charts;

        return $this->sendResponse($data, trans('backend.api.received'));

    }

    public function exams_chart($student_id)
    {
        $data = [];
        $charts = [
            ['chart_key' => 'subject_id', 'chart_name' => __('backend.subject'), 'foreign' => true, 'relation' => 'subject', 'title' => 'name'],
            ['chart_key' => 'exam_id', 'chart_name' => __('backend.exam'), 'foreign' => true, 'relation' => 'exam', 'title' => 'name'],
        ];
        foreach ($charts as $chart) {
            if ($chart['foreign'])
                $cf_details_lines = \App\Models\Admin\ExamAttempt::with(['subject', 'exam'])->whereHas('exam')->select('id', 'subject_id', 'student_id', 'exam_id', \DB::raw('CAST(count(*) AS UNSIGNED) as num'))
                    ->when(request('selected_subject_id'), function ($q) {
                        $q->where('subject_id', request('selected_subject_id'));
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
                $cf_details_lines = \App\Models\Admin\ExamAttempt::select(\DB::raw('CAST(count(*) AS UNSIGNED) as num'), "{$chart["chart_key"]} as label")
                    ->when(request('selected_subject_id'), function ($q) {
                        $q->where('subject_id', request('selected_subject_id'));
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

    public function exam_attempts_chart($student_id, $exam_id)
    {
        $data = [];
        $charts = [
            ['chart_key' => 'attempt_started_at', 'chart_name' => __('backend.attempt_started_at'), 'foreign' => false],
            ['chart_key' => 'attempt_ended_at', 'chart_name' => __('backend.attempt_ended_at'), 'foreign' => false],
            ['chart_key' => 'attempt_status', 'chart_name' => __('backend.attempt_status'), 'foreign' => false],
            ['chart_key' => 'subject_id', 'chart_name' => __('backend.subject'), 'foreign' => true, 'relation' => 'subject', 'title' => 'name'],
            ['chart_key' => 'exam_id', 'chart_name' => __('backend.exam'), 'foreign' => true, 'relation' => 'exam', 'title' => 'name'],
        ];
        foreach ($charts as $chart) {
            if ($chart['foreign'])
                $cf_details_lines = \App\Models\Admin\ExamAttempt::with(['subject', 'exam'])->select('id', 'exam_id', 'subject_id', 'student_id', \DB::raw('CAST(count(*) AS UNSIGNED) as num'))
                    ->when(request('selected_subject_id'), function ($q) {
                        $q->where('subject_id', request('selected_subject_id'));
                    })
                    ->where('exam_id', $exam_id)
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
                $cf_details_lines = \App\Models\Admin\ExamAttempt::select(\DB::raw('CAST(count(*) AS UNSIGNED) as num'), "{$chart["chart_key"]} as label")
                    ->when(request('selected_subject_id'), function ($q) {
                        $q->where('subject_id', request('selected_subject_id'));
                    })
                    ->where('exam_id', $exam_id)
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

    public function attempt_answers_chart($exam_attempt_id)
    {
        $data = [];
        $charts = [
            ['chart_key' => 'is_correct', 'chart_name' => __('backend.is_correct'), 'foreign' => false],
        ];
        foreach ($charts as $chart) {
            if ($chart['foreign'])
                $cf_details_lines = \App\Models\Admin\AttemptAnswer::with(['question'])->select('id', 'exam_id', 'question_id', 'student_id', \DB::raw('CAST(count(*) AS UNSIGNED) as num'))
                    ->where('exam_attempt_id', $exam_attempt_id)
                    ->groupBy($chart['chart_key'])
                    ->withCasts(['num' => 'integer'])
                    ->get();
            else
                $cf_details_lines = \App\Models\Admin\AttemptAnswer::select(\DB::raw('CAST(count(*) AS UNSIGNED) as num'), "{$chart["chart_key"]} as label")
                    ->where('exam_attempt_id', $exam_attempt_id)
                    ->groupBy($chart['chart_key'])
                    ->withCasts(['num' => 'integer'])
                    ->get();


            $data[$chart['chart_key']] = $cf_details_lines;

        }
        return $data;

    }


    //from http://www.phperz.com/article/14/1029/31806.html
    function mb_split_str($str)
    {
        preg_match_all("/./u", $str, $arr);
        return $arr[0];
    }

//based on http://www.phperz.com/article/14/1029/31806.html, added percent
    function mb_similar_text($str1, $str2, &$percent)
    {
        $arr_1 = array_unique($this->mb_split_str($str1));
        $arr_2 = array_unique($this->mb_split_str($str2));
        $similarity = count($arr_2) - count(array_diff($arr_2, $arr_1));
        $percent = ($similarity * 200) / (strlen($str1) + strlen($str2));
        return $similarity;
    }


}
