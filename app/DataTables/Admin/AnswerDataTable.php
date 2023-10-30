<?php

namespace App\DataTables\Admin;

use App\Models\Admin\Answer;
use App\Models\Admin\Question;
use Illuminate\Routing\Route;
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

            $photo = $model->photo;
            return view('includes.lazy_photo', compact('photo'));
        });

        $dataTable->editColumn('is_correct', function (Answer $model) {

            $value = $model->is_correct;
            return view('includes.datatables_column_bool', compact('value'));
        });

        return $dataTable->addColumn('action', function (Answer $answer) {
            return view('admin.answers.datatables_actions', compact('answer'));
        })->rawColumns(["action",'is_correct']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin\Answer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Answer $model)
    {
        $question_id = request('question_id');
        return $model->newQuery()->where('question_id', $question_id);;
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
            ->ajax(url()->full())
            ->addAction(['width' => 'auto', 'printable' => false, 'searchable' => false, 'exporting' => false, 'title' => __('lang.action')])
            ->parameters([
                'stateSave' => false,
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
        $question_id = request('question_id');
        $question = Question::find($question_id);

        if ($question->type == Question::$QUESTION_TYPE_TRUE_FALSE) {
            $columns = ['title', 'is_correct', 'answer_order'];

        } elseif ($question->type == Question::$QUESTION_TYPE_MULTIPLE_CHOICE) {
            $columns = ['title', 'answer_view_format', 'photo', 'is_correct', 'answer_order'];

        } elseif ($question->type == Question::$QUESTION_TYPE_SINGLE_CHOICE) {
            $columns = ['title', 'answer_view_format', 'photo', 'is_correct', 'answer_order'];

        } elseif ($question->type == Question::$QUESTION_TYPE_TRUE_FALSE) {
            $columns = ['title', 'is_correct', 'answer_order'];

        } else {
            $columns = ['title', 'answer_two_gap_match', 'answer_view_format', 'photo', 'answer_order'];
        }
        $columns_array = [];
        $columns_array['id'] = new Column(['title' => '#', 'data' => 'id', 'visible' => true, 'printable' => false, 'searchable' => false, 'exporting' => false]);
        foreach ($columns as $column) {
            $columns_array[$column] = new Column(['title' => __("models/answers.fields.$column"), 'data' => "$column"]);
        }
        return $columns_array;
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
