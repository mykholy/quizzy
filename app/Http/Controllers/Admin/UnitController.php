<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UnitDataTable;
use App\Http\Requests\Admin\CreateUnitRequest;
use App\Http\Requests\Admin\UpdateUnitRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Unit;
use Illuminate\Http\Request;


class UnitController extends AppBaseController
{
    /**
     * Display a listing of the Unit.
     */
    public function index(UnitDataTable $unitDataTable)
    {
    return $unitDataTable->render('admin.units.index',['book_id' => request('book_id')]);
    }


    /**
     * Show the form for creating a new Unit.
     */
    public function create()
    {
        return view('admin.units.create');
    }

    /**
     * Store a newly created Unit in storage.
     */
    public function store(CreateUnitRequest $request)
    {

        $request_data = $request->except(['_token', 'photo']);
        if ($request->hasFile('photo')) {

             $request_data['photo'] = uploadImage('units', $request->photo);

        }

        /** @var Unit $unit */
        $unit = Unit::create($request_data);

        session()->flash('success',__('messages.saved', ['model' => __('models/units.singular')]));

        return redirect(route('admin.units.index',['book_id'=>request('book_id')]));
    }

    /**
     * Display the specified Unit.
     */
    public function show($id)
    {
        /** @var Unit $unit */
        $unit = Unit::find($id);

        if (empty($unit)) {
            session()->flash('error',__('models/units.singular').' '.__('messages.not_found'));


            return redirect(route('admin.units.index',['book_id'=>request('book_id')]));
        }

        return view('admin.units.show',['book_id'=>request('book_id')])->with('unit', $unit);
    }

    /**
     * Show the form for editing the specified Unit.
     */
    public function edit($id)
    {
        /** @var Unit $unit */
        $unit = Unit::find($id);

        if (empty($unit)) {
            session()->flash('error',__('models/units.singular').' '.__('messages.not_found'));


            return redirect(route('admin.units.index',['book_id'=>request('book_id')]));
        }

        return view('admin.units.edit',['book_id'=>request('book_id')])->with('unit', $unit);
    }

    /**
     * Update the specified Unit in storage.
     */
    public function update($id, UpdateUnitRequest $request)
    {
        /** @var Unit $unit */
        $unit = Unit::find($id);

        if (empty($unit)) {
            session()->flash('error',__('models/units.singular').' '.__('messages.not_found'));


            return redirect(route('admin.units.index',['book_id'=>request('book_id')]));
        }

        $request_data = $request->except(['_token', 'photo']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('units', $request->photo);
        }

        $unit->fill($request_data);
        $unit->save();

        session()->flash('success',__('messages.updated', ['model' => __('models/units.singular')]));

        return redirect(route('admin.units.index',['book_id'=>request('book_id')]));
    }

    /**
     * Remove the specified Unit from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Unit $unit */
        $unit = Unit::find($id);

        if (empty($unit)) {
            session()->flash('error',__('models/units.singular').' '.__('messages.not_found'));


            return redirect(route('admin.units.index',['book_id'=>request('book_id')]));
        }

        $unit->delete();

        session()->flash('success',__('messages.deleted', ['model' => __('models/units.singular')]));


        return redirect(route('admin.units.index',['book_id'=>request('book_id')]));
    }
}
