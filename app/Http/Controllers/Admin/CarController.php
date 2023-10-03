<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\CarDataTable;
use App\Http\Requests\Admin\CreateCarRequest;
use App\Http\Requests\Admin\UpdateCarRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Admin\Car;
use Illuminate\Http\Request;
use Flash;

class CarController extends AppBaseController
{
    /**
     * Display a listing of the Car.
     */
    public function index(CarDataTable $carDataTable)
    {
    return $carDataTable->render('admin.cars.index');
    }


    /**
     * Show the form for creating a new Car.
     */
    public function create()
    {
        return view('admin.cars.create');
    }

    /**
     * Store a newly created Car in storage.
     */
    public function store(CreateCarRequest $request)
    {

        $request_data = $request->except(['_token', 'photo']);
        if ($request->hasFile('photo')) {

             $request_data['photo'] = uploadImage('cars', $request->photo);

        }

        /** @var Car $car */
        $car = Car::create($request_data);

        Flash::success(__('messages.saved', ['model' => __('models/cars.singular')]));

        return redirect(route('admin.cars.index'));
    }

    /**
     * Display the specified Car.
     */
    public function show($id)
    {
        /** @var Car $car */
        $car = Car::find($id);

        if (empty($car)) {
            Flash::error(__('models/cars.singular').' '.__('messages.not_found'));

            return redirect(route('admin.cars.index'));
        }

        return view('admin.cars.show')->with('car', $car);
    }

    /**
     * Show the form for editing the specified Car.
     */
    public function edit($id)
    {
        /** @var Car $car */
        $car = Car::find($id);

        if (empty($car)) {
            Flash::error(__('models/cars.singular').' '.__('messages.not_found'));

            return redirect(route('admin.cars.index'));
        }

        return view('admin.cars.edit')->with('car', $car);
    }

    /**
     * Update the specified Car in storage.
     */
    public function update($id, UpdateCarRequest $request)
    {
        /** @var Car $car */
        $car = Car::find($id);

        if (empty($car)) {
            Flash::error(__('models/cars.singular').' '.__('messages.not_found'));

            return redirect(route('admin.cars.index'));
        }

        $request_data = $request->except(['_token', 'photo']);

        if ($request->hasFile('photo')) {
            $request_data['photo'] = uploadImage('cars', $request->photo);
        }

        $car->fill($request_data);
        $car->save();

        Flash::success(__('messages.updated', ['model' => __('models/cars.singular')]));

        return redirect(route('admin.cars.index'));
    }

    /**
     * Remove the specified Car from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Car $car */
        $car = Car::find($id);

        if (empty($car)) {
            Flash::error(__('models/cars.singular').' '.__('messages.not_found'));

            return redirect(route('admin.cars.index'));
        }

        $car->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/cars.singular')]));

        return redirect(route('admin.cars.index'));
    }
}
