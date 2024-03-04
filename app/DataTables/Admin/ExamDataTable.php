<?php

namespace App\DataTables\Admin;

use App\Models\Admin\Exam;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class ExamDataTable extends DataTable
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


        $dataTable->editColumn('is_active', function (Exam $model) {

             $value = $model->is_active;
             return view('includes.datatables_column_bool', compact('value'));
        });

        $dataTable->editColumn('subject_id', function (Exam $model) {

              $subject_name = optional($model->subject)->name;;
             return $subject_name;
        });

        return $dataTable->addColumn('action', 'admin.exams.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin\Exam $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Exam $model)
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
                'dom'       => 'Bfrltip',
                'orderable' => true,
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

            'name' => new Column(['title' => __('models/exams.fields.name'), 'data' => 'name']),
            'type' => new Column(['title' => __('models/exams.fields.type'), 'data' => 'type']),
            'question_types' => new Column(['title' => __('models/exams.fields.question_types'), 'data' => 'question_types']),
            'level' => new Column(['title' => __('models/exams.fields.level'), 'data' => 'level']),
            'type_assessment' => new Column(['title' => __('models/exams.fields.type_assessment'), 'data' => 'type_assessment']),
            'semester' => new Column(['title' => __('models/exams.fields.semester'), 'data' => 'semester']),
            'points' => new Column(['title' => __('models/exams.fields.points'), 'data' => 'points']),
            'time' => new Column(['title' => __('models/exams.fields.time'), 'data' => 'time']),
            'subject_id' => new Column(['title' => __('models/exams.fields.subject_id'), 'data' => 'subject_id']),
            'is_active' => new Column(['title' => __('models/exams.fields.is_active'), 'data' => 'is_active'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'exams_datatable_' . time();
    }
}
