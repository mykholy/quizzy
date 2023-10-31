<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\LessonDataTable;
use App\Http\Requests\Admin\CreateLessonRequest;
use App\Http\Requests\Admin\UpdateLessonRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Lesson;
use Illuminate\Http\Request;


class LessonController extends AppBaseController
{
    /**
     * Display a listing of the Lesson.
     */
    public function index(LessonDataTable $lessonDataTable)
    {
    return $lessonDataTable->render('admin.lessons.index',['unit_id' => request('unit_id')]);
    }


    /**
     * Show the form for creating a new Lesson.
     */
    public function create()
    {
        return view('admin.lessons.create');
    }

    /**
     * Store a newly created Lesson in storage.
     */
    public function store(CreateLessonRequest $request)
    {

        $request_data = $request->except(['_token', 'photo']);
        if ($request->hasFile('photo')) {

             $request_data['photo'] = uploadImage('lessons', $request->photo);

        }

        /** @var Lesson $lesson */
        $lesson = Lesson::create($request_data);

        session()->flash('success',__('messages.saved', ['model' => __('models/lessons.singular')]));

        return redirect(route('admin.lessons.index',['unit_id' => request('unit_id')]));
    }

    /**
     * Display the specified Lesson.
     */
    public function show($id)
    {
        /** @var Lesson $lesson */
        $lesson = Lesson::find($id);

        if (empty($lesson)) {
            session()->flash('error',__('models/lessons.singular').' '.__('messages.not_found'));


            return redirect(route('admin.lessons.index',['unit_id' => request('unit_id')]));
        }

        return view('admin.lessons.show',['unit_id' => request('unit_id')])->with('lesson', $lesson);
    }

    /**
     * Show the form for editing the specified Lesson.
     */
    public function edit($id)
    {
        /** @var Lesson $lesson */
        $lesson = Lesson::find($id);

        if (empty($lesson)) {
            session()->flash('error',__('models/lessons.singular').' '.__('messages.not_found'));


            return redirect(route('admin.lessons.index',['unit_id' => request('unit_id')]));
        }

        return view('admin.lessons.edit',)->with('lesson', $lesson);
    }

    /**
     * Update the specified Lesson in storage.
     */
    public function update($id, UpdateLessonRequest $request)
    {
        /** @var Lesson $lesson */
        $lesson = Lesson::find($id);

        if (empty($lesson)) {
            session()->flash('error',__('models/lessons.singular').' '.__('messages.not_found'));


            return redirect(route('admin.lessons.index',['unit_id' => request('unit_id')]));
        }

        $request_data = $request->except(['_token', 'photo']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('lessons', $request->photo);
        }

        $lesson->fill($request_data);
        $lesson->save();

        session()->flash('success',__('messages.updated', ['model' => __('models/lessons.singular')]));

        return redirect(route('admin.lessons.index',['unit_id' => request('unit_id')]));
    }

    /**
     * Remove the specified Lesson from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Lesson $lesson */
        $lesson = Lesson::find($id);

        if (empty($lesson)) {
            session()->flash('error',__('models/lessons.singular').' '.__('messages.not_found'));


            return redirect(route('admin.lessons.index',['unit_id' => request('unit_id')]));
        }

        $lesson->delete();

        session()->flash('success',__('messages.deleted', ['model' => __('models/lessons.singular')]));


        return redirect(route('admin.lessons.index',['unit_id' => request('unit_id')]));
    }
}
