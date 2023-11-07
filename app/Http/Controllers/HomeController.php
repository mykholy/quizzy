<?php

namespace App\Http\Controllers;

use App\Models\Admin\AcademicYear;
use App\Models\Admin\Book;
use App\Models\Admin\Group;
use App\Models\Admin\Lesson;
use App\Models\Admin\Question;
use App\Models\Admin\Student;
use App\Models\Admin\Subject;
use App\Models\Admin\Teacher;
use App\Models\Admin\Unit;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cards = [
            ['title' => __('models/teachers.plural'), 'color' => 'primary', 'count' => Teacher::count()],
            ['title' => __('models/subjects.plural'), 'color' => 'warning', 'count' => Subject::count()],
            ['title' => __('models/groups.plural'), 'color' => 'info', 'count' => Group::count()],
            ['title' => __('models/students.plural'), 'color' => 'success', 'count' => Student::count()],
            ['title' => __('models/academicYears.plural'), 'color' => 'danger', 'count' => AcademicYear::count()],
            ['title' => __('models/books.plural'), 'color' => 'primary', 'count' => Book::count()],
            ['title' => __('models/units.plural'), 'color' => 'success', 'count' => Unit::count()],
            ['title' => __('models/lessons.plural'), 'color' => 'warning', 'count' => Lesson::count()],
            ['title' => __('models/questions.plural'), 'color' => 'primary', 'count' => Question::count()],
        ];
        return view('home', compact('cards'));
    }
}
