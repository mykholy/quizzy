<?php

namespace App\DataTables\Admin;

use App\Models\Admin\Location;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class LocationDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $dataTable->addColumn('photo', function (Location $model) {
            $photos=json_decode($model->photos);
            $photo = $photos[0]??'';
            return view('includes.lazy_photo', compact('photo'));
        });

        $dataTable->editColumn('description', function (Location $model) {

            $value = Str::limit($model->description,20);
            return $value;
        });
        $dataTable->editColumn('is_active', function (Location $model) {

             $value = $model->is_active;
             return view('includes.datatables_column_bool', compact('value'));
        });
        $dataTable->editColumn('open247', function (Location $model) {

             $value = $model->open247;
             return view('includes.datatables_column_bool', compact('value'));
        });
        $dataTable->editColumn('coming_soon', function (Location $model) {

             $value = $model->coming_soon;
             return view('includes.datatables_column_bool', compact('value'));
        });
        $dataTable->editColumn('under_repair', function (Location $model) {

             $value = $model->under_repair;
             return view('includes.datatables_column_bool', compact('value'));
        });
        $dataTable->editColumn('qr_enabled', function (Location $model) {

             $value = $model->qr_enabled;
             return view('includes.datatables_column_bool', compact('value'));
        });
        $dataTable->editColumn('cost', function (Location $model) {

             $value = $model->cost;
             return view('includes.datatables_column_bool', compact('value'));
        });
        $dataTable->editColumn('plugshare_location_id', function (Location $model) {

             $value = $model->plugshare_location_id;
             return '<a href="https://www.plugshare.com/location/'.$value.'">'.trans('lang.show').'</a>';
        });

        return $dataTable->rawColumns(['plugshare_location_id','action'])->addColumn('action', 'admin.locations.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin\Location $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Location $model)
    {
        return $model->newQuery()->withCount('stations');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => 'auto', 'printable' => false, 'searchable' => false, 'exporting' => false, 'title' => __('lang.action')])
            ->parameters([
                'stateSave' => true,
                'responsive' => true,
                "autoWidth" => true,
                "scrollX" => true,
                'orderable' => true,
                'dom' => '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l><"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>>t<"d-flex justify-content-between mx-2 row mb-1"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                'pagingType' => 'simple_numbers',
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    // Enable Buttons as per your need
//                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
                'drawCallback' => 'function() { lazyLoadInstance.update();}',
                'language' => [
                    'url' => url('//cdn.datatables.net/plug-ins/1.10.12/i18n/English.json'),
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => new Column(['title' => '#', 'data' => 'id', 'visible' => true, 'printable' => false, 'searchable' => false, 'exporting' => false]),

            'name' => new Column(['title' => __('models/locations.fields.name'), 'data' => 'name']),
            'latitude' => new Column(['title' => __('models/locations.fields.latitude'), 'data' => 'latitude']),
            'longitude' => new Column(['title' => __('models/locations.fields.longitude'), 'data' => 'longitude']),
            'stations_count' => new Column(['title' => __('models/locations.fields.stations_count'), 'data' => 'stations_count', 'searchable' => false]),
            'description' => new Column(['title' => __('models/locations.fields.description'), 'data' => 'description']),
            'photo' => new Column(['title' => __('models/locations.fields.photos'), 'data' => 'photo']),
            'score' => new Column(['title' => __('models/locations.fields.score'), 'data' => 'score']),
            'cost' => new Column(['title' => __('models/locations.fields.cost'), 'data' => 'cost']),
            'cost_description' => new Column(['title' => __('models/locations.fields.cost_description'), 'data' => 'cost_description']),
//            'access' => new Column(['title' => __('models/locations.fields.access'), 'data' => 'access']),
//            'icon' => new Column(['title' => __('models/locations.fields.icon'), 'data' => 'icon']),
//            'icon_type' => new Column(['title' => __('models/locations.fields.icon_type'), 'data' => 'icon_type']),
            'phone' => new Column(['title' => __('models/locations.fields.phone'), 'data' => 'phone']),
            'address' => new Column(['title' => __('models/locations.fields.address'), 'data' => 'address']),
//            'pwps_version' => new Column(['title' => __('models/locations.fields.pwps_version'), 'data' => 'pwps_version']),
            'qr_enabled' => new Column(['title' => __('models/locations.fields.qr_enabled'), 'data' => 'qr_enabled']),
//            'poi_name' => new Column(['title' => __('models/locations.fields.poi_name'), 'data' => 'poi_name']),
            'parking_type_name' => new Column(['title' => __('models/locations.fields.parking_type_name'), 'data' => 'parking_type_name']),
//            'locale' => new Column(['title' => __('models/locations.fields.locale'), 'data' => 'locale']),
            'opening_date' => new Column(['title' => __('models/locations.fields.opening_date'), 'data' => 'opening_date']),
            'hours' => new Column(['title' => __('models/locations.fields.hours'), 'data' => 'hours']),
            'open247' => new Column(['title' => __('models/locations.fields.open247'), 'data' => 'open247']),
            'coming_soon' => new Column(['title' => __('models/locations.fields.coming_soon'), 'data' => 'coming_soon']),
            'under_repair' => new Column(['title' => __('models/locations.fields.under_repair'), 'data' => 'under_repair']),
            'access_restrictions' => new Column(['title' => __('models/locations.fields.access_restrictions'), 'data' => 'access_restrictions']),
            'parking_attributes' => new Column(['title' => __('models/locations.fields.parking_attributes'), 'data' => 'parking_attributes']),
            'parking_level' => new Column(['title' => __('models/locations.fields.parking_level'), 'data' => 'parking_level']),
            'overhead_clearance_meters' => new Column(['title' => __('models/locations.fields.overhead_clearance_meters'), 'data' => 'overhead_clearance_meters']),
            'is_active' => new Column(['title' => __('models/locations.fields.is_active'), 'data' => 'is_active']),
            'plugshare_location_id' => new Column(['title' => __('models/locations.fields.plugshare_location_id'), 'data' => 'plugshare_location_id'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'locations_datatable_' . time();
    }
}
