<?php

namespace App\DataTables\Admin;

use App\Models\Admin\Answer;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AnswerDataTable extends DataTable
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
        $dataTable->editColumn('photo', function (Answer $model) {

            $photo = $model->photo ;
            return view('includes.lazy_photo', compact('photo'));
        });

        $dataTable->editColumn('is_active', function (Answer $model) {

             $value = $model->is_active;
             return view('includes.datatables_column_bool', compact('value'));
        });

        return $dataTable->addColumn('action', 'admin.answers.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Answer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Answer $model)
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
            'title' => new Column(['title' => __('models/answers.fields.title'), 'data' => 'title']),
            'question_type' => new Column(['title' => __('models/answers.fields.question_type'), 'data' => 'question_type']),
            'answer_two_gap_match' => new Column(['title' => __('models/answers.fields.answer_two_gap_match'), 'data' => 'answer_two_gap_match']),
            'answer_view_format' => new Column(['title' => __('models/answers.fields.answer_view_format'), 'data' => 'answer_view_format']),
            'answer_order' => new Column(['title' => __('models/answers.fields.answer_order'), 'data' => 'answer_order']),
            'photo' => new Column(['title' => __('models/answers.fields.photo'), 'data' => 'photo']),
            'is_correct' => new Column(['title' => __('models/answers.fields.is_correct'), 'data' => 'is_correct'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'answers_datatable_' . time();
    }
}
