<?php

namespace App\DataTables;

use App\Models\CaseList;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CaseListDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->orderColumns(['case_code', 'status'], '-:column $1')
            ->addColumn('action', function ($row) {
                $name = 'case_list';
                $except = [];

                return view('partials.datatablesActions', compact(
                    'name',
                    'except',
                    'row'
                ));
            });
    }

    public function query(CaseList $model, Request $request): \Illuminate\Database\Eloquent\Builder
    {
        return $model->select($model->getTable() . '.*')->search($request->all());
    }

    public function html(): Builder
    {
//        dd(3);
        return $this->builder()
            ->setTableId('CaseListTable')
            ->columns($this->getColumns())
            ->parameters([
                'language' => dataTableLang(),
            ])
            ->responsive([
                'details' => [
                    'display' => '$.fn.dataTable.Responsive.display.childRowImmediate',
                    'type' => '',
                ],
            ])
            ->ajax([
                'url' => url()->current(),
                'type' => 'GET',
                'data' => "function (d) { d.case_code = $('#case_code').val(); d.status = $('#status').val(); },",
            ])
            ->dom('Brtip');
    }

    protected function getColumns(): array
    {
//        dd(4);
        return [
            Column::make('case_code')
                ->content('-'),
            Column::make('status')
                ->content('-'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
