<?php

namespace App\DataTables\Admin;

use App\Models\Admin\Lesson;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class LessonDataTable extends DataTable
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
        $dataTable->editColumn('photo', function (Lesson $model) {

            $photo = $model->photo;
            return view('includes.lazy_photo', compact('photo'));
        });
        $dataTable->editColumn('unit_id', function (Lesson $model) {

            $value = optional($model->unit)->name;

            return $value;
        });

        $dataTable->editColumn('is_active', function (Lesson $model) {

            $value = $model->is_active;
            return view('includes.datatables_column_bool', compact('value'));
        });

        return $dataTable->addColumn('action', 'admin.lessons.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin\Lesson $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Lesson $model)
    {
        return $model->newQuery()->when(request('unit_id'), function ($q) {
            $q->where('unit_id', request('unit_id'));
        });
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
            ->ajax(['url' => url()->full()])
            ->addAction(['width' => 'auto', 'printable' => false, 'searchable' => false, 'exporting' => false, 'title' => __('lang.action')])
            ->parameters([
                'stateSave' => true,
                'responsive' => true,
                "autoWidth" => true,
                'dom' => 'Bfrltip',
                'orderable' => true,
                'order' => [[0, 'desc']],
                'buttons' => [
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
            'name' => new Column(['title' => __('models/lessons.fields.name'), 'data' => 'name']),
            'photo' => new Column(['title' => __('models/lessons.fields.photo'), 'data' => 'photo']),
            'unit_id' => new Column(['title' => __('models/lessons.fields.unit_id'), 'data' => 'unit_id']),
            'is_active' => new Column(['title' => __('models/lessons.fields.is_active'), 'data' => 'is_active'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'lessons_datatable_' . time();
    }
}
