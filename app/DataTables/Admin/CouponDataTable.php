<?php

namespace App\DataTables\Admin;

use App\Models\Admin\Coupon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CouponDataTable extends DataTable
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


        $dataTable->editColumn('is_active', function (Coupon $model) {

            $value = $model->is_active;
            return view('includes.datatables_column_bool', compact('value'));
        });

        return $dataTable->addColumn('action', 'admin.coupons.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin\Coupon $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Coupon $model)
    {
        $is_active = $this->request()->header('is_active');
        $start_date = $this->request()->header('start_date');
        $end_date = $this->request()->header('end_date');
        return $model->newQuery()
            ->when($is_active==0 || $is_active==1 , function ($q) use ($is_active) {
               return $q->where('is_active', $is_active);
            })
            ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                return $q->whereBetween('updated_at', [$start_date, $end_date]);
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
//            ->ajaxWithForm(url()->current(), '#coupon-filter')
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
            'id' => new Column(['title' => '#', 'data' => 'id', 'visible' => true, 'printable' => false, 'searchable' => false, 'exporting' => false]),

            'title' => new Column(['title' => __('models/coupons.fields.title'), 'data' => 'title']),
            'code' => new Column(['title' => __('models/coupons.fields.code'), 'data' => 'code']),
            'price' => new Column(['title' => __('models/coupons.fields.price'), 'data' => 'price']),
            'value' => new Column(['title' => __('models/coupons.fields.value'), 'data' => 'value']),
            'is_active' => new Column(['title' => __('models/coupons.fields.is_active'), 'data' => 'is_active']),
            'created_at' => new Column(['title' => __('models/coupons.fields.created_at'), 'data' => 'created_at']),
            'updated_at' => new Column(['title' => __('models/coupons.fields.updated_at'), 'data' => 'updated_at']),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'coupons_datatable_' . time();
    }
}
