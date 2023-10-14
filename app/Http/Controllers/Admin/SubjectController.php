<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SubjectDataTable;
use App\Http\Requests\Admin\CreateSubjectRequest;
use App\Http\Requests\Admin\UpdateSubjectRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Subject;
use Illuminate\Http\Request;


class SubjectController extends AppBaseController
{
    /**
     * Display a listing of the Subject.
     */
    public function index(SubjectDataTable $subjectDataTable)
    {
    return $subjectDataTable->render('admin.subjects.index');
    }


    /**
     * Show the form for creating a new Subject.
     */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /**
     * Store a newly created Subject in storage.
     */
    public function store(CreateSubjectRequest $request)
    {

        $request_data = $request->except(['_token', 'photo']);
        if ($request->hasFile('photo')) {

             $request_data['photo'] = uploadImage('subjects', $request->photo);

        }

        /** @var Subject $subject */
        $subject = Subject::create($request_data);

        session()->flash('success',__('messages.saved', ['model' => __('models/subjects.singular')]));

        return redirect(route('admin.subjects.index'));
    }

    /**
     * Display the specified Subject.
     */
    public function show($id)
    {
        /** @var Subject $subject */
        $subject = Subject::find($id);

        if (empty($subject)) {
            session()->flash('error',__('models/subjects.singular').' '.__('messages.not_found'));


            return redirect(route('admin.subjects.index'));
        }

        return view('admin.subjects.show')->with('subject', $subject);
    }

    /**
     * Show the form for editing the specified Subject.
     */
    public function edit($id)
    {
        /** @var Subject $subject */
        $subject = Subject::find($id);

        if (empty($subject)) {
            session()->flash('error',__('models/subjects.singular').' '.__('messages.not_found'));


            return redirect(route('admin.subjects.index'));
        }

        return view('admin.subjects.edit')->with('subject', $subject);
    }

    /**
     * Update the specified Subject in storage.
     */
    public function update($id, UpdateSubjectRequest $request)
    {
        /** @var Subject $subject */
        $subject = Subject::find($id);

        if (empty($subject)) {
            session()->flash('error',__('models/subjects.singular').' '.__('messages.not_found'));


            return redirect(route('admin.subjects.index'));
        }

        $request_data = $request->except(['_token', 'photo']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('subjects', $request->photo);
        }

        $subject->fill($request_data);
        $subject->save();

        session()->flash('success',__('messages.updated', ['model' => __('models/subjects.singular')]));

        return redirect(route('admin.subjects.index'));
    }

    /**
     * Remove the specified Subject from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Subject $subject */
        $subject = Subject::find($id);

        if (empty($subject)) {
            session()->flash('error',__('models/subjects.singular').' '.__('messages.not_found'));


            return redirect(route('admin.subjects.index'));
        }

        $subject->delete();

        session()->flash('success',__('messages.deleted', ['model' => __('models/subjects.singular')]));


        return redirect(route('admin.subjects.index'));
    }
}
