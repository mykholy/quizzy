<?php

namespace App\DataTables\Admin;

use App\Models\Admin\Question;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class QuestionDataTable extends DataTable
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
        $dataTable->editColumn('photo', function (Question $model) {

            $photo = $model->photo;
            return view('includes.lazy_photo', compact('photo'));
        });
        $dataTable->editColumn('lesson_id', function (Question $model) {
            $lesson = $model->lesson;
            $lesson_name = optional($lesson)->name;
            $unit_name = optional($lesson->unit)->name;
            $subject_name = optional($lesson->unit->subject)->name;
            return $lesson_name . " >> " . $unit_name . " >> " . $subject_name;
        });

        $dataTable->editColumn('type', function (Question $question) {


            return Question::getQuestionType($question->type);
        });
        $dataTable->editColumn('is_active', function (Question $model) {

            $value = $model->is_active;
            return view('includes.datatables_column_bool', compact('value'));
        });
        return $dataTable->addColumn('action', function (Question $question) {
            return view('admin.questions.datatables_actions', compact('question'));
        })->rawColumns(["action", 'is_active']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin\Question $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Question $model)
    {
        return $model->newQuery()->with(['lesson.unit.subject'])->when(request('lesson_id'), function ($q) {
            $q->where('lesson_id', request('lesson_id'));
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
            'name' => new Column(['title' => __('models/questions.fields.name'), 'data' => 'name']),
            'type' => new Column(['title' => __('models/questions.fields.type'), 'data' => 'type']),
            'photo' => new Column(['title' => __('models/questions.fields.photo'), 'data' => 'photo']),
            'points' => new Column(['title' => __('models/questions.fields.points'), 'data' => 'points']),
            'time' => new Column(['title' => __('models/questions.fields.time'), 'data' => 'time']),
            'lesson_id' => new Column(['title' => __('models/questions.fields.lesson_unit_subject'), 'data' => 'lesson_id']),
            'is_active' => new Column(['title' => __('models/questions.fields.is_active'), 'data' => 'is_active'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'questions_datatable_' . time();
    }
}
