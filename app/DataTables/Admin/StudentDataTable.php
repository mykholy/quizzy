<?php

namespace App\DataTables\Admin;

use App\Models\Admin\Student;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class StudentDataTable extends DataTable
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
        $dataTable->editColumn('photo', function (Student $model) {

            $photo = $model->photo ;
            return view('includes.lazy_photo', compact('photo'));
        });
        $dataTable->editColumn('academic_year_id', function (Student $model) {
            $academicYear=$model->academicYear?$model->academicYear->name:'---';
            return $academicYear;
        });

        $dataTable->editColumn('is_active', function (Student $model) {

             $value = $model->is_active;
             return view('includes.datatables_column_bool', compact('value'));
        });

        return $dataTable->addColumn('action', 'admin.students.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Student $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Student $model)
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

            'username' => new Column(['title' => __('models/students.fields.username'), 'data' => 'username']),
            'name' => new Column(['title' => __('models/students.fields.name'), 'data' => 'name']),
            'email' => new Column(['title' => __('models/students.fields.email'), 'data' => 'email']),
            'phone' => new Column(['title' => __('models/students.fields.phone'), 'data' => 'phone']),
            'photo' => new Column(['title' => __('models/students.fields.photo'), 'data' => 'photo']),
            'date_of_birth' => new Column(['title' => __('models/students.fields.date_of_birth'), 'data' => 'date_of_birth']),
            'governorate' => new Column(['title' => __('models/students.fields.governorate'), 'data' => 'governorate']),
            'area' => new Column(['title' => __('models/students.fields.area'), 'data' => 'area']),
            'residence_area' => new Column(['title' => __('models/students.fields.residence_area'), 'data' => 'residence_area']),
            'specialization' => new Column(['title' => __('models/students.fields.specialization'), 'data' => 'specialization']),
            'academic_year_id' => new Column(['title' => __('models/students.fields.academic_year_id'), 'data' => 'academic_year_id']),
            'is_active' => new Column(['title' => __('models/students.fields.is_active'), 'data' => 'is_active'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'students_datatable_' . time();
    }
}
