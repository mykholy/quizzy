<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\AcademicYearDataTable;
use App\Http\Requests\Admin\CreateAcademicYearRequest;
use App\Http\Requests\Admin\UpdateAcademicYearRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\AcademicYear;
use Illuminate\Http\Request;


class AcademicYearController extends AppBaseController
{
    /**
     * Display a listing of the AcademicYear.
     */
    public function index(AcademicYearDataTable $academicYearDataTable)
    {
    return $academicYearDataTable->render('admin.academic_years.index');
    }


    /**
     * Show the form for creating a new AcademicYear.
     */
    public function create()
    {
        return view('admin.academic_years.create');
    }

    /**
     * Store a newly created AcademicYear in storage.
     */
    public function store(CreateAcademicYearRequest $request)
    {

        $request_data = $request->except(['_token', 'photo']);
        if ($request->hasFile('photo')) {

             $request_data['photo'] = uploadImage('academicYears', $request->photo);

        }

        /** @var AcademicYear $academicYear */
        $academicYear = AcademicYear::create($request_data);

        session()->flash('success',__('messages.saved', ['model' => __('models/academicYears.singular')]));

        return redirect(route('admin.academicYears.index'));
    }

    /**
     * Display the specified AcademicYear.
     */
    public function show($id)
    {
        /** @var AcademicYear $academicYear */
        $academicYear = AcademicYear::find($id);

        if (empty($academicYear)) {
            session()->flash('error',__('models/academicYears.singular').' '.__('messages.not_found'));


            return redirect(route('admin.academicYears.index'));
        }

        return view('admin.academic_years.show')->with('academicYear', $academicYear);
    }

    /**
     * Show the form for editing the specified AcademicYear.
     */
    public function edit($id)
    {
        /** @var AcademicYear $academicYear */
        $academicYear = AcademicYear::find($id);

        if (empty($academicYear)) {
            session()->flash('error',__('models/academicYears.singular').' '.__('messages.not_found'));


            return redirect(route('admin.academicYears.index'));
        }

        return view('admin.academic_years.edit')->with('academicYear', $academicYear);
    }

    /**
     * Update the specified AcademicYear in storage.
     */
    public function update($id, UpdateAcademicYearRequest $request)
    {
        /** @var AcademicYear $academicYear */
        $academicYear = AcademicYear::find($id);

        if (empty($academicYear)) {
            session()->flash('error',__('models/academicYears.singular').' '.__('messages.not_found'));


            return redirect(route('admin.academicYears.index'));
        }

        $request_data = $request->except(['_token', 'photo']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('academicYears', $request->photo);
        }

        $academicYear->fill($request_data);
        $academicYear->save();

        session()->flash('success',__('messages.updated', ['model' => __('models/academicYears.singular')]));

        return redirect(route('admin.academicYears.index'));
    }

    /**
     * Remove the specified AcademicYear from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var AcademicYear $academicYear */
        $academicYear = AcademicYear::find($id);

        if (empty($academicYear)) {
            session()->flash('error',__('models/academicYears.singular').' '.__('messages.not_found'));


            return redirect(route('admin.academicYears.index'));
        }

        $academicYear->delete();

        session()->flash('success',__('messages.deleted', ['model' => __('models/academicYears.singular')]));


        return redirect(route('admin.academicYears.index'));
    }
}
