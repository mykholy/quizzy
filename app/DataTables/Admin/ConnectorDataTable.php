<?php

namespace App\DataTables\Admin;

use App\Models\Admin\Connector;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class ConnectorDataTable extends DataTable
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
        $dataTable->editColumn('photo', function (Connector $model) {

            $photo = $model->photo ;
            return view('includes.lazy_photo', compact('photo'));
        });

        $dataTable->editColumn('is_active', function (Connector $model) {

             $value = $model->is_active;
             return view('includes.datatables_column_bool', compact('value'));
        });

        return $dataTable->rawColumns(['photo','is_active','action'])
            ->addColumn('action', 'admin.connectors.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin\Connector $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Connector $model)
    {
        return $model->newQuery();
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
            'name' => new Column(['title' => __('models/connectors.fields.name'), 'data' => 'name']),
            'description' => new Column(['title' => __('models/connectors.fields.description'), 'data' => 'description']),
            'power' => new Column(['title' => __('models/connectors.fields.power'), 'data' => 'power']),
            'kilowatts' => new Column(['title' => __('models/connectors.fields.kilowatts'), 'data' => 'kilowatts']),
            'photo' => new Column(['title' => __('models/connectors.fields.photo'), 'data' => 'photo']),
            'is_active' => new Column(['title' => __('models/connectors.fields.is_active'), 'data' => 'is_active'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'connectors_datatable_' . time();
    }
}
