<?php

namespace App\DataTables;

use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AuditLogsDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->orderColumns(['user_id'], '-:column $1')
            ->addColumn('action', function ($row) {
                $name = 'audit log';
                $except = ['show'];

                return view('partials.datatablesActions', compact(
                    'name',
                    'except',
                    'row'
                ));
            });
    }

    public function query(Activity $model)
    {
        return $model->newQuery()->select($model->getTable().'.*');
    }

    public function html(): Builder
    {
        return $this->builder()
            ->setTableId('AuditLogsDataTable')
            ->columns($this->getColumns())
            ->responsive([
                'details' => [
                    'display' => '$.fn.dataTable.Responsive.display.childRowImmediate',
                    'type' => '',
                ],
            ])
            ->minifiedAjax()
            ->dom('Brtip');
    }

    protected function getColumns(): array
    {
        return [
            Column::make('log_name'),
            Column::make('description'),
            Column::make('subject_type')
                ->content('-'),
            Column::make('subject_id')
                ->content('-'),
            Column::make('causer_type')
                ->content('-'),
            Column::make('causer_id')
                ->content('-'),
            Column::make('properties')
                ->content('-'),
            Column::make('event')
                ->content('-'),
//            Column::computed('action')
//                ->exportable(false)
//                ->printable(false)
//                ->width(100)
//                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'AuditLog_'.date('YmdHis');
    }
}
