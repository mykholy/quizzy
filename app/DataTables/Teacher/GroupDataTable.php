<?php

namespace App\DataTables\Teacher;

use App\Models\Admin\Group;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class GroupDataTable extends DataTable
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
        $dataTable->editColumn('photo', function (Group $model) {

            $photo = $model->photo ;
            return view('includes.lazy_photo', compact('photo'));
        });

        $dataTable->editColumn('teacher_id', function (Group $model) {

            $value = optional($model->teacher)->name ;
            return $value;
        });
        $dataTable->editColumn('subject_id', function (Group $model) {

            $value = optional($model->subject)->name ;
            return $value;
        });
        $dataTable->editColumn('is_active', function (Group $model) {

             $value = $model->is_active;
             return view('includes.datatables_column_bool', compact('value'));
        });

        return $dataTable->addColumn('action', 'admin.groups.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin\Group $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Group $model)
    {
        return $model->newQuery()->with(['subject','teacher'])
            ->where('teacher_id',auth('teacher')->id());
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

            'name' => new Column(['title' => __('models/groups.fields.name'), 'data' => 'name']),
            'teacher_id' => new Column(['title' => __('models/groups.fields.teacher_id'), 'data' => 'teacher_id']),
            'subject_id' => new Column(['title' => __('models/groups.fields.subject_id'), 'data' => 'subject_id']),
            'photo' => new Column(['title' => __('models/groups.fields.photo'), 'data' => 'photo'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'groups_datatable_' . time();
    }
}
