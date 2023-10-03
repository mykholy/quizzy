<?php

namespace App\DataTables\Admin;

use App\Models\Admin\Station;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class StationDataTable extends DataTable
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
//        $dataTable->editColumn('location_id', function (Station $model) {
//
//            $name = optional($model->location)->name;
//            return $name;
//        });
        $dataTable->editColumn('qr_enabled', function (Station $model) {

            $value = $model->qr_enabled;
            return view('includes.datatables_column_bool', compact('value'));
        });
        $dataTable->editColumn('is_active', function (Station $model) {

            $value = $model->is_active;
            return view('includes.datatables_column_bool', compact('value'));
        });

        return $dataTable->addColumn('action', 'admin.stations.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin\Station $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Station $model)
    {
        return $model->newQuery()->with('location');
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

            'name' => new Column(['title' => __('models/stations.fields.name'), 'data' => 'name']),
            'latitude' => new Column(['title' => __('models/stations.fields.latitude'), 'data' => 'latitude']),
            'longitude' => new Column(['title' => __('models/stations.fields.longitude'), 'data' => 'longitude']),
            'cost' => new Column(['title' => __('models/stations.fields.cost'), 'data' => 'cost']),
            'cost_description' => new Column(['title' => __('models/stations.fields.cost_description'), 'data' => 'cost_description']),
            'manufacturer' => new Column(['title' => __('models/stations.fields.manufacturer'), 'data' => 'manufacturer']),
            'model' => new Column(['title' => __('models/stations.fields.model'), 'data' => 'model']),
            'pwps_version' => new Column(['title' => __('models/stations.fields.pwps_version'), 'data' => 'pwps_version']),
            'qr_enabled' => new Column(['title' => __('models/stations.fields.qr_enabled'), 'data' => 'qr_enabled']),
//            'outlets' => new Column(['title' => __('models/stations.fields.outlets'), 'data' => 'outlets']),
            'hours' => new Column(['title' => __('models/stations.fields.hours'), 'data' => 'hours']),
            'pre_charge_instructions' => new Column(['title' => __('models/stations.fields.pre_charge_instructions'), 'data' => 'pre_charge_instructions']),
            'available' => new Column(['title' => __('models/stations.fields.available'), 'data' => 'available']),
            'location_id' => new Column(['title' => __('models/stations.fields.location_id'), 'data' => 'location.name']),
//            'plugshare_location_id' => new Column(['title' => __('models/stations.fields.plugshare_location_id'), 'data' => 'plugshare_location_id']),
//            'plugshare_station_id' => new Column(['title' => __('models/stations.fields.plugshare_station_id'), 'data' => 'plugshare_station_id'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'stations_datatable_' . time();
    }
}
